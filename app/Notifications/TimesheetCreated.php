<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TimesheetCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject("Simplistic IT: Invoice Created")
                    ->greeting('Hello!')
                    ->line('A new invoice has been created for your company on Simplistic IT\'s data system')
                    ->line('with ' . $this->invoice->credit_hours . ' hours.  You are invited to login to the')
                    ->line('system.  If you are a client, you\'ll have access to check on your company\'s')
                    ->line('timesheets as well as change your notification preferences.')
                    ->action('Login Now', url('/'))
                    ->line('Thank you for using our application!')
                    ->line('Please do not reply to this email, this is an unmonitored mailbox.  If you do not')
                    ->line('wish to receive anymore email, you may either change the setting in your preferences')
                    ->line('or email dan@simplisticit.com.');
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
