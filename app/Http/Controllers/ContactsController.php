<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\Contact;
use App\Contractor;

class ContactsController extends Controller
{
    public function index(Contractor $contractor) {
        $contacts = Contact::where('contractor_id', $contractor->id)->get();
        return view('contacts.index', compact('contractor', 'contacts'));
    }
    
    public function create(Contractor $contractor) {
        return view('contacts.create', compact('contractor'));
    }
    
    public function store(Contractor $contractor) {
        $input = Input::all();
        $error = "";
        $existing_contacts = Contact::where('name', $input['name'])->where('contractor_id', $contractor->id);
        if ($existing_contacts->count() != 0) {
            $error .= "Contact name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            $input['contractor_id'] = $contractor->id;
            $contact = Contact::create($input);
            if ($contact) {
                ActivitiesController::log('Contact was created - '.$contact->name.'.');
                return Redirect::route('contractors.contacts.index', $contractor->slug())
                        ->with('success', UtilsController::response('Successful!', 'Contact has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(Contractor $contractor, Contact $contact) {
        return view('contacts.edit', compact('contractor', 'contact'));
    }
    
    public function update(Contractor $contractor, Contact $contact) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_contacts = Contact::where('name', $input['name'])->where('contractor_id', $contractor->id)->where('id', '<>', $contact->id);
        if ($existing_contacts->count() != 0) {
            $error .= "Contact name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($contact->update($input)) {
                ActivitiesController::log('Contact was updated - '.$contact->name.'.');
                return Redirect::route('contractors.contacts.index', $contractor->slug())
                        ->with('success', UtilsController::response('Successful!', 'Contact has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function disable(Contractor $contractor, Contact $contact) {
        $input['active'] = false;
        $contact->update($input);
        ActivitiesController::log('Contact was disabled - '.$contact->name.'.');
        return Redirect::route('contractors.contacts.index', $contractor->slug())
                ->with('success', UtilsController::response('Successful!', 'Contact has been disabled.'));
    }
    
    public function enable(Contractor $contractor, Contact $contact) {
        $input['active'] = true;
        $contact->update($input);
        ActivitiesController::log('Contact was enabled - '.$contact->name.'.');
        return Redirect::route('contractors.contacts.index', $contractor->slug())
                ->with('success', UtilsController::response('Successful!', 'Contact has been enabled.'));
    }
}
