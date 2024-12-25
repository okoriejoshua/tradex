<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login; 
use Illuminate\Http\Request;
use App\Models\Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event) 
    {
        $user = $event->user;
        $request = app(Request::class);

        if (!session()->has('login_recorded')) {
            Activity::create([
                'user_id' => $user->id,
                'login_time' => now(),
                'device' => $request->userAgent(),
                'ip_address' => $request->ip(),
            ]);

            session(['login_recorded' => true]);
        }
    }
}
