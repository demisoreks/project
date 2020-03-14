<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\Project;
use App\Component;
use App\Update;

class UpdatesController extends Controller
{
    public function index(Project $project) {
        $updates = Update::where('project_id', $project->id)->get();
        return view('updates.index', compact('project', 'updates'));
    }
    
    public function create(Project $project) {
        $last_update = [];
        $components = Component::where('project_id', $project->id)->orderBy('order_no')->get();
        $updates = Update::where('project_id', $project->id)->orderBy('tracking_date', 'desc');
        if ($updates->count() > 0) {
            $update = $updates->first();
        }
        foreach ($components as $component) {
            $last_update[$component->id] = 0;
            if (isset($update)) {
                $component_updates = json_decode($update->component_updates, true);
                foreach ($component_updates as $component_update) {
                    if ($component_update['component_id'] == $component->id) {
                        $last_update[$component->id] = $component_update['percentage'];
                        break;
                    }
                }
            }
        }
        return view('updates.create', compact('project', 'last_update', 'components'));
    }
    
    public function store(Project $project) {
        $input = Input::all();
        $components = Component::where('project_id', $project->id)->orderBy('order_no')->get();
        $component_updates = [];
        foreach ($components as $component) {
            array_push($component_updates, [
                'component_id' => $component->id,
                'description' => $component->description,
                'percentage' => $input[$component->id],
                'order_no' => $component->order_no
            ]);
            unset($input[$component->id]);
        }
        $input['component_updates'] = json_encode($component_updates);
        $input['project_id'] = $project->id;
        
        $update = Update::create($input);
        if ($update) {
            ActivitiesController::log('Update was created  for '.$project->name.'.');
            return Redirect::route('projects.updates.index', $project->slug())
                    ->with('success', UtilsController::response('Successful!', 'Update has been created.'));
        } else {
            return Redirect::back()
                    ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                    ->withInput();
        }
    }
}
