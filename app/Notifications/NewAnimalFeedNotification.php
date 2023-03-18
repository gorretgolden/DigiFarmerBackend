<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AnimalFeed;

class NewAnimalFeedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $animal_feed;
    public function __construct(AnimalFeed $animal_feed)
    {
        $this->animal_feed = $animal_feed;
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
            'Title' => $this->animal_feed->name,
            'name' => $this->animal_feed->vendor->username,
            'email' => $this->animal_feed->vendor->email,
            'phone' => $this->animal_feed->vendor->phone,
            'message' =>'Vendor'.' '.$this->animal_feed->vendor->username.' '.'has posted '.' '.$this->animal_feed->name.' '.'as an animal feed'

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
