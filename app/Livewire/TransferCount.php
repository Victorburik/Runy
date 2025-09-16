<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\TransferReceived;
use Illuminate\Support\Facades\Http;

class TransferCount extends Component
{
    public $to_user_id, $amount, $users;

    protected $rules = [
        'to_user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0.01',
    ];

    public function mount()
    {
        $this->users = User::where('id', '!=', Auth::id())->get(['id', 'name', 'type']);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'amount') {
            $this->validateAmount();
        }
    }

    public function validateAmount()
    {
        $fromUser = Auth::user();
        if ($this->amount > $fromUser->wallet->balance) {
            $this->addError('amount', 'Saldo insuficiente.');
        }
    }

    public function submit()
    {
        $this->validate();

        $fromUser = Auth::user();
        $toUser = User::findOrFail($this->to_user_id);

        if ($fromUser->type === 'lojista') {
            $this->addError('to_user_id', 'Lojistas não podem enviar transferências.');
            return;
        }

        if ($fromUser->id === $toUser->id) {
            $this->addError('to_user_id', 'Não é possível transferir para si mesmo.');
            return;
        }

        if ($this->amount > $fromUser->wallet->balance) {
            $this->addError('amount', 'Saldo insuficiente para realizar a transferência.');
            return;
        }

        DB::beginTransaction();
        try {
            $response = Http::get('https://util.devi.tools/api/v2/authorize');
            $data = $response->json();

            if (!isset($data['data']['authorization']) || !$data['data']['authorization']) {
                throw new \Exception('Transferência não autorizada.');
            }

            $fromUser->wallet->decrement('balance', $this->amount);
            $toUser->wallet->increment('balance', $this->amount);

            Transfer::create([
                'from_user_id' => $fromUser->id,
                'to_user_id' => $toUser->id,
                'amount' => $this->amount,
                'status' => 'completed',
            ]);

            DB::commit();

            try {
                Http::post('https://util.devi.tools/api/v1/notify', [
                    'to_user_id' => $toUser->id,
                    'from_user_id' => $fromUser->id,
                    'amount' => $this->amount,
                ]);
            } catch (\Exception $notifyException) {
                \Log::warning('Falha ao enviar notificação HTTP: ' . $notifyException->getMessage());
            }

            try {
                $toUser->notify(new TransferReceived($fromUser, $this->amount));
            } catch (\Exception $mailException) {
                \Log::warning('Falha ao enviar e-mail: ' . $mailException->getMessage());
            }

            session()->flash('success', 'Transferência realizada com sucesso!');
            return redirect()->route('transfers.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('amount', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transfer-count', [
            'users' => $this->users,
        ]);
    }
}
