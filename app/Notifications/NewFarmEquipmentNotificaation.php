<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SellerProduct;

class NewFarmEquipmentNotificaation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $seller_product;
    public function __construct(SellerProduct $seller_product)
    {
        $this->seller_product = $seller_product;
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
            'Title' => $this->seller_product->name,
            'name' => $this->seller_product->vendor->username,
            'email' => $this->seller_product->vendor->email,
            'phone' => $this->seller_product->vendor->phone,
            'message' =>'Vendor'.' '.$this->seller_product->vendor->username.' '.'has posted a'.' '.$this->seller_product->name.' '.'as a farm equipment for sale'

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
