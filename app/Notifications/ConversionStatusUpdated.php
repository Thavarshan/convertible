<?php

namespace App\Notifications;

use App\Models\Conversion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConversionStatusUpdated extends Notification
{
    use Queueable;

    /**
     * The conversion instance.
     *
     * @var \App\Models\Conversion
     */
    protected $conversion;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Conversion
     *
     * @return void
     */
    public function __construct(Conversion $conversion)
    {
        $this->conversion = $conversion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hello from Convertible!')
            ->line('Your file conversion has completed and is available for download.')
            ->action('Download converted file', $this->conversion->downloadLink())
            ->line('Thank you for using Convertible!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
