<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $recipient;
    protected $sender;
    protected $amount;
    protected $message;

    public function __construct(User $recipient, ?User $sender, $amount, $message = null)
    {
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->amount = $amount;
        $this->message = $message;
    }

    public function handle()
    {
        $message = $this->message ?? ($this->sender
            ? "Você recebeu uma transferência de R$ {$this->amount} de {$this->sender->name}."
            : "Depósito de R$ {$this->amount} realizado com sucesso.");

        $response = Http::post('https://util.devi.tools/api/v1/notify', [
            'to' => $this->recipient->email,
            'message' => $message,
        ]);

        if ($response->failed()) {
            \Log::warning('Notificação falhou para ' . $this->recipient->email);
        }
    }
}