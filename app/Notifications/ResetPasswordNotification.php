<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Determine which delivery channels to use (mail in this case).
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail notification.
     */
    public function toMail($notifiable)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000'); // Update this to your frontend URL
        $resetUrl = "{$frontendUrl}/reset-password/{$this->token}?email=" . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->line('Click the button below to reset your password.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request this, no further action is required.');
    }
}
