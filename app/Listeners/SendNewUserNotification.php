<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class SendNewUserNotification
{
    public function handle($event)
    {
        $admins = User::whereHas('roles', function ($query) {
                $query->where('id', 1);
            })->get();

        Notification::send($admins, new NewUserNotification($event->user));
    }
}
