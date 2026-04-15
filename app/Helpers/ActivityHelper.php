<?php

use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logActivity')) {

    function logActivity($action, $description = null)
    {
        LogActivity::create([
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip()
        ]);
    }

}