<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\Project;
use App\Update;

use App\Charts\StatusChart;
use App\Charts\CostChart;

class LoginController extends Controller
{
    public function index() {
        if (Session::has('pmp_user')) {
            return Redirect::route('dashboard');
        }
        
        return view('welcome');
    }
    
    public static function hashPassword($password, $times) {
        $hashed_password = hash("sha512", $password, false);
        if ($times > 1) {
            return LoginController::hashPassword($hashed_password, $times-1);
        } else {
            return $hashed_password;
        }
    }
    
    public function authenticate() {
        $input = Input::all();
        /*$employees = HrmEmployee::where('username', $input['username'])->where('status', 'Active');
        if ($employees->count() != 0) {
            $employee = $employees->first();
            if ($input['password'] == "default") {
                $user = ['id' => $employee->id, 'username' => $employee->username, 'first_name' => $employee->first_name, 'surname' => $employee->surname];
                Session::put('fbnm_user', $user);
                $employee->update([
                    'last_login' => date("Y-m-d H:i:s"),
                    'last_login_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('dashboard');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Login error!</span><br />Invalid password.');
            }
        } else {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Login error!</span><br />Username does not exist.');
        }*/
        if ($input['username'] == "system" && $input['password'] == "default") {
            $user = ['id' => 1, 'username' => 'system', 'first_name' => 'System', 'surname' => 'Administrator'];
            Session::put('pmp_user', $user);
            ActivitiesController::log("User logged in.");
            return Redirect::route('dashboard');
        } else {
            return Redirect::back()
                    ->with('error', UtilsController::response('Login error!', 'Invalid username or password.'));
        }
    }
    
    static function checkAccess() {
        if (Session::has('pmp_user')) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function getRoles(AccLink $link) {
        $employee = HrmEmployee::whereId(Session::get('fbnm_user')['id'])->first();
        $roles = [];
        foreach (AccRole::where('link_id', $link->id)->get() as $role) {
            if ($role->all) {
                array_push($roles, $role->id);
            } else {
                $employees = explode(',', $role->employees);
                if (in_array($employee->id, $employees)) {
                    array_push($roles, $role->id);
                } else {
                    if ($employee->job_function_id != null) {
                        $job_functions = explode(',', $role->job_functions);
                        if (in_array($employee->job_function_id, $job_functions)) {
                            array_push($roles, $role->id);
                        } else {
                            $unit_id = HrmJobFunction::whereId($employee->job_function_id)->first()->unit_id;
                            $units = explode(',', $role->units);
                            if (in_array($unit_id, $units)) {
                                array_push($roles, $role->id);
                            } else {
                                $department_id = HrmUnit::whereId($unit_id)->first()->department_id;
                                $departments = explode(',', $role->departments);
                                if (in_array($department_id, $departments)) {
                                    array_push($roles, $role->id);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $roles;
    }
    
    public static function getAllRoles() {
        $all_roles = [];
        foreach (AccLink::where('active', true)->get() as $link) {
            $all_roles = array_merge($all_roles, LoginController::getRoles($link));
        }
        return $all_roles;
    }
    
    public static function allowed($roles) {
        $allowed = false;
        foreach ($roles as $role) {
            $r = AccRole::where('title', $role)->where('active', true);
            if ($r->count() > 0) {
                $role_id = $r->first()->id;
                if (in_array($role_id, LoginController::getAllRoles())) {
                    $allowed = true;
                    break;
                }
            }
        }
        return $allowed;
    }

    /*
    public function change_password(AccEmployee $employee) {
        return view('change_password', compact('employee'));
    }
    
    public function update_password(AccEmployee $employee) {
        $input = array_except(Input::all(), '_method');
        $input['password'] = LoginController::hashPassword($input['password'].$employee->salt, 8);
        $input['change_password'] = false;
        unset($input['password2']);
        if ($employee->update($input)) {
            $halo_user = $employee;
            AccActivity::create([
                'employee_id' => $halo_user->id,
                'detail' => 'Password was updated - '.$employee->username.'.',
                'source_ip' => $_SERVER['REMOTE_ADDR']
            ]);
            return Redirect::route('welcome')
                    ->with('success', '<span class="font-weight-bold">Password change successful!</span><br />You can now log in.');
        } else {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                    ->withInput();
        }
    }
     * */
    
    public function dashboard() {
        $status = new StatusChart();
        $status->labels(['On Track', 'Overdue']);
        $project_status = [
            Project::where('status', 'A')->where('end_date', '>=', date('Y-m-d'))->count(),
            Project::where('status', 'A')->where('end_date', '<', date('Y-m-d'))->count()
        ];
        $status_colors = [
            '#4285f4',
            '#ff4444'
        ];
        $status->dataset('On Track/Overdue', 'doughnut', $project_status)->backgroundColor($status_colors);
        
        $cost = new CostChart();
        $cost_labels = [];
        $cost_budget = [];
        $cost_spent = [];
        $i = 0;
        foreach (Project::where('status', 'A')->get() as $project) {
            $cost_labels[$i] = $project->name;
            $cost_budget[$i] = $project->budget;
            $cost_spent[$i] = Update::where('project_id', $project->id)->sum('amount_spent');
            $i ++;
        }
        $cost->labels($cost_labels);
        $cost->dataset('Budget', 'bar', $cost_budget)->color('#0d47a1')->backgroundColor('#4285f4');
        $cost->dataset('Spent', 'bar', $cost_spent)->color('#cc0000')->backgroundColor('#ff4444');
        $cost->title('Project Expense Performance');
        
        return view('dashboard', compact('status', 'cost'));
    }
    
    public function logout() {
        if (Session::has('pmp_user')) {
            ActivitiesController::log("User logged out.");
            Session::forget('pmp_user');
        }
        return Redirect::route('welcome')
                ->with('success', UtilsController::response('Successful!', 'You have logged out.'));
    }
}
