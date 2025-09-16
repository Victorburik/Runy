<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendNotificationJob;

class Deposit extends Component
{
    public $amount;

    protected $rules = [
        'amount' => 'required|numeric|min:0.01',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function deposit()
    {
        $this->validate();

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $response = Http::get('https://util.devi.tools/api/v2/authorize');
            $data = $response->json();

            if ($data['data']['authorization'] != true) {
                throw new \Exception('Depósito não autorizado.');
            }

            $user->wallet->increment('balance', $this->amount);

            DB::commit();
            SendNotificationJob::dispatch($user, null, $this->amount, "Depósito de R$ {$this->amount} realizado com sucesso.");

            session()->flash('success', 'Depósito realizado com sucesso!');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('amount', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.deposit');
    }
}
