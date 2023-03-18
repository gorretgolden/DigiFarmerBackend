<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RentVendorService;

class NewRentServiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $rent_service;
    public function __construct(RentVendorService $rent_service)
    {
        $this->rent_service = $rent_service;
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
            'Title' => $this->rent_service->name,
            'name' => $this->rent_service->vendor->username,
            'email' => $this->rent_service->vendor->email,
            'phone' => $this->rent_service->vendor->phone,
            'message' =>'Vendor'.' '.$this->rent_service->vendor->username.' '.'has posted '.' '.$this->rent_service->name.' '.'as a rent service'

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
