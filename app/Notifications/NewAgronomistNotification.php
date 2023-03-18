<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AgronomistVendorService;

class NewAgronomistNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $agronomist_service;
    public function __construct(AgronomistVendorService $agronomist_service)
    {
        $this->agronomist_service = $agronomist_service;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable)
    {
        return [
            'Title' => $this->agronomist_service->name,
            'name' => $this->agronomist_service->user->username,
            'email' => $this->agronomist_service->user->email,
            'phone' => $this->agronomist_service->user->phone,
            'message' =>'Vendor'.' '.$this->agronomist_service->user->username.' '.'has posted '.' '.$this->agronomist_service->name.' '.'as an agronomist service'

        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
