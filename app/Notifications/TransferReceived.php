<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $fromUser;
    protected $amount;

    public function __construct($fromUser, $amount)
    {
        $this->fromUser = $fromUser;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Você recebeu uma transferência!')
            ->greeting("Olá {$notifiable->name},")
            ->line("Você recebeu R$ {$this->amount} de {$this->fromUser->name}.")
            ->action('Acessar sua conta', url('/dashboard'))
            ->line('Obrigado por usar nosso sistema!');
    }
}
