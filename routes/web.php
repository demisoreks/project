<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'welcome', 'uses' => 'LoginController@index'
]);
Route::post('authenticate', [
    'as' => 'authenticate', 'uses' => 'LoginController@authenticate'
]);
Route::get('change_password/{employee}', [
    'as' => 'change_password', 'uses' => 'LoginController@change_password'
]);
Route::post('update_password/{employee}', [
    'as' => 'update_password', 'uses' => 'LoginController@update_password'
]);
Route::get('dashboard', [
    'as' => 'dashboard', 'uses' => 'LoginController@dashboard'
])->middleware('auth.user');
Route::get('logout', [
    'as' => 'logout', 'uses' => 'LoginController@logout'
]);

Route::get('contractors/{contractor}/disable', [
    'as' => 'contractors.disable', 'uses' => 'ContractorsController@disable'
])->middleware(['auth.user']);
Route::get('contractors/{contractor}/enable', [
    'as' => 'contractors.enable', 'uses' => 'ContractorsController@enable'
])->middleware(['auth.user']);
Route::resource('contractors', 'ContractorsController')->middleware(['auth.user']);
Route::bind('contractors', function($value, $route) {
    return App\Contractor::findBySlug($value)->first();
});

Route::get('contractors/{contractor}/contacts/{contact}/disable', [
    'as' => 'contractors.contacts.disable', 'uses' => 'ContactsController@disable'
])->middleware(['auth.user']);
Route::get('contractors/{contractor}/contacts/{contact}/enable', [
    'as' => 'contractors.contacts.enable', 'uses' => 'ContactsController@enable'
])->middleware(['auth.user']);
Route::resource('contractors.contacts', 'ContactsController')->middleware(['auth.user']);
Route::bind('contractors.contacts', function($value, $route) {
    return App\Contact::findBySlug($value)->first();
});

Route::get('projects/{project}/breakdown', [
    'as' => 'projects.breakdown', 'uses' => 'ProjectsController@breakdown'
])->middleware('auth.user');
Route::resource('projects', 'ProjectsController')->middleware('auth.user');
Route::bind('projects', function($value, $route) {
    return App\Project::findBySlug($value)->first();
});

Route::resource('projects.components', 'ComponentsController')->middleware('auth.user');
Route::bind('projects.components', function($value, $route) {
    return App\Component::findBySlug($value)->first();
});

Route::resource('projects.expenses', 'ExpensesController')->middleware('auth.user');
Route::bind('projects.expenses', function($value, $route) {
    return App\Component::findBySlug($value)->first();
});

Route::resource('projects.updates', 'UpdatesController')->middleware('auth.user');
Route::bind('projects.updates', function($value, $route) {
    return App\Update::findBySlug($value)->first();
});

Route::get('summary', [
    'as' => 'summary', 'uses' => 'ProjectsController@summary'
])->middleware('auth.user');