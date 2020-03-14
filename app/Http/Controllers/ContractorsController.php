<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\Contractor;

class ContractorsController extends Controller
{
    public function index() {
        $contractors = Contractor::all();
        return view('contractors.index', compact('contractors'));
    }
    
    public function create() {
        return view('contractors.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_contractors = Contractor::where('name', $input['name']);
        if ($existing_contractors->count() != 0) {
            $error .= "Contractor name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            $contractor = Contractor::create($input);
            if ($contractor) {
                ActivitiesController::log('Contractor was created - '.$contractor->name.'.');
                return Redirect::route('contractors.index')
                        ->with('success', UtilsController::response('Successful!', 'Contractor has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(Contractor $contractor) {
        return view('contractors.edit', compact('contractor'));
    }
    
    public function update(Contractor $contractor) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_contractors = Contractor::where('name', $input['name'])->where('id', '<>', $contractor->id);
        if ($existing_contractors->count() != 0) {
            $error .= "Contractor name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($contractor->update($input)) {
                ActivitiesController::log('Contractor was updated - '.$contractor->name.'.');
                return Redirect::route('contractors.index')
                        ->with('success', UtilsController::response('Successful!', 'Contractor has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function disable(Contractor $contractor) {
        $input['active'] = false;
        $contractor->update($input);
        ActivitiesController::log('Contractor was disabled - '.$contractor->name.'.');
        return Redirect::route('contractors.index')
                ->with('success', UtilsController::response('Successful!', 'Contractor has been disabled.'));
    }
    
    public function enable(Contractor $contractor) {
        $input['active'] = true;
        $contractor->update($input);
        ActivitiesController::log('Contractor was enabled - '.$contractor->name.'.');
        return Redirect::route('contractors.index')
                ->with('success', UtilsController::response('Successful!', 'Contractor has been enabled.'));
    }
}
