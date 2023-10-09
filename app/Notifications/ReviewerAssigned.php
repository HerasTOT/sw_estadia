<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerAssigned extends Notification
{
    use Queueable;

    protected $user;
    protected $proposal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $proposal)
    {
        $this->user = $user;
        $this->proposal = $proposal;
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
            ->subject('Se le ha asignado una propuesta!')
            ->greeting("Hola {$this->user->name},")
            ->line("Tiene una nueva propuesta que revisar")
            ->action('Vea la propuesta que le fue asignada', url("proposals/{proposal}/review", $this->proposal->id))
            ->line('Gracias por usar nuestra plataforma!');
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
