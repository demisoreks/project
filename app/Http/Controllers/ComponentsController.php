<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\Component;
use App\Project;

class ComponentsController extends Controller
{
    public function index(Project $project) {
        $components = Component::where('project_id', $project->id)->get();
        return view('components.index', compact('project', 'components'));
    }
    
    public function create(Project $project) {
        return view('components.create', compact('project'));
    }
    
    public function store(Project $project) {
        $input = Input::all();
        $error = "";
        $existing_components = Component::where('description', $input['description'])->where('project_id', $project->id);
        if ($existing_components->count() != 0) {
            $error .= "Component already exists.<br />";
        }
        if ($input['end_date'] < $input['start_date']) {
            $error .= "Specified end date is before the start date.<br />";
        }
        if ($input['start_date'] < $project->start_date || $input['start_date'] > $project->end_date) {
            $error .= "Component start date does not fall with project timeline.<br />";
        }
        if ($input['end_date'] < $project->start_date || $input['end_date'] > $project->end_date) {
            $error .= "Component end date does not fall with project timeline.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            $input['project_id'] = $project->id;
            $component = Component::create($input);
            if ($component) {
                ActivitiesController::log('Component was created for '.$project->name.'.');
                return Redirect::route('projects.components.index', $project->slug())
                        ->with('success', UtilsController::response('Successful!', 'Component has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(Project $project, Component $component) {
        return view('components.edit', compact('project', 'component'));
    }
    
    public function update(Project $project, Component $component) {
        $input = Input::all();
        $error = "";
        $existing_components = Component::where('description', $input['description'])->where('project_id', $project->id)->where('id', '<>', $component->id);
        if ($existing_components->count() != 0) {
            $error .= "Component already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($component->update($input)) {
                ActivitiesController::log('Component was uupdated for '.$project->name.'.');
                return Redirect::route('projects.components.index', $project->slug())
                        ->with('success', UtilsController::response('Successful!', 'Component has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
}
