<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LoanApplication;

class ApproveLoanApplication extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LoanApplication $loan_application)
    {
        $this->loan_application = $loan_application;
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
                    ->greeting('Congratulations')
                    ->line('Hi '.$this->loan_application->user->username.' Hope you are doing well, the Loan You applied for has been approved succesfully')
                    ->line('The funds will be credited within 2 Business working days using the payment method you selected')
                    ->action('Notification Action', url('/'))
                    ->line('Your Loan number is '.$this->loan_application->loan_number. ' Keep it secure.')
                    ->line('Thank you for using our system!');
    }


    public function toDatabase($notifiable)
    {
        return [
            'loan_application_number' => $this->loan_application->loan_number,
            'applicant' => $this->loan_application->user->username,

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
