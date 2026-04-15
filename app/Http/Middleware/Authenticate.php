<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
{
    if (! $request->expectsJson()) {

        // untuk kasir
        if ($request->is('kasir') || 
            $request->is('kasir/*') || 
            $request->is('menus')) {

            return route('kasir.login');
        }

        // default admin
        return route('login');
    }
}
}