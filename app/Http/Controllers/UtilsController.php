<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilsController extends Controller
{
    static function response($short, $description) {
        return '<span class="font-weight-bold">'.$short.'</span><br />'.$description;
    }
}
