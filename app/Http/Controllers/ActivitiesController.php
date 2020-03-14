<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Activity;

class ActivitiesController extends Controller
{
    static function log($detail) {
        Activity::create([
            'user_id' => Session::get('pmp_user')['id'],
            'detail' => $detail,
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
    }
}
