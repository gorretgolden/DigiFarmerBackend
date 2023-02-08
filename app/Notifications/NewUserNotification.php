<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'fullname' => $this->user->username,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
        ];
    }

}
