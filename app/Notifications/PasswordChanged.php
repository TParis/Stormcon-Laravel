<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordChanged extends Notification
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
                    ->subject("Simplistic IT: Password Changed")
                    ->greeting('Hello!')
                    ->line('Your password has been updated on Simplistic IT\'s data system.  You are invited')
                    ->line('to login to the system.  If you didn\'t change your password, or you haven\'t')
                    ->line('asked for it to be updated, then please notify Simplistic IT immediately.')
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
