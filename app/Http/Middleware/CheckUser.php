<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

use App\Http\Controllers\LoginController;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!LoginController::checkAccess()) {
            return Redirect::route('welcome')
                    ->with('error', '<span class="font-weight-bold">Access denied!</span><br />Please log in to gain access.');
        }
        
        return $next($request);
    }
}
