<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendNotificationJob;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show()
    {
        $user = Auth::user();
        return view('wallet.show', ['wallet' => $user->wallet]);
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ], [
            'amount.required' => 'Informe o valor do depósito.',
            'amount.numeric' => 'O valor deve ser numérico.',
            'amount.min' => 'O valor deve ser maior que 0,01.',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        DB::beginTransaction();
        try {
            // Autorização via serviço externo
            $response = Http::get('https://util.devi.tools/api/v2/authorize');
            if (!isset($response->json()['data']['authorized']) || !$response->json()['data']['authorized']) {
                throw new \Exception('Depósito não autorizado.');
            }

            // Incrementa saldo
            $user->wallet->increment('balance', $amount);

            DB::commit();

            // Dispara notificação assíncrona
            SendNotificationJob::dispatch($user, null, $amount, "Depósito de R$ {$amount} realizado com sucesso.");

            return redirect()->route('dashboard')->with('success', 'Depósito realizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages(['amount' => $e->getMessage()]);
        }
    }
}