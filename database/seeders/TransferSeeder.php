<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transfer;
use Carbon\Carbon;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        // Usuários comuns (enviadores)
        $commonUsers = User::where('type', 'comum')->get();
        // Lojistas (destinatários)
        $merchants = User::where('type', 'lojista')->get();

        $transfers = [
            [
                'from_user_id' => $commonUsers[0]->id, // João Silva
                'to_user_id' => $merchants[0]->id, // Loja do José
                'amount' => 100.00,
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'from_user_id' => $commonUsers[1]->id, // Maria Oliveira
                'to_user_id' => $merchants[1]->id, // Comércio da Carla
                'amount' => 200.00,
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'from_user_id' => $commonUsers[2]->id, // Pedro Santos
                'to_user_id' => $commonUsers[3]->id, // Ana Costa
                'amount' => 50.00,
                'status' => 'completed',
                'created_at' => Carbon::now(),
            ],
            [
                'from_user_id' => $commonUsers[4]->id, // Lucas Pereira
                'to_user_id' => $merchants[2]->id, // Empresa do Roberto
                'amount' => 300.00,
                'status' => 'completed',
                'created_at' => Carbon::now(),
            ],
        ];

        foreach ($transfers as $transferData) {
            // Criar transferência
            Transfer::create([
                'from_user_id' => $transferData['from_user_id'],
                'to_user_id' => $transferData['to_user_id'],
                'amount' => $transferData['amount'],
                'status' => $transferData['status'],
                'created_at' => $transferData['created_at'],
                'updated_at' => $transferData['created_at'],
            ]);

            // Atualizar saldos (simulando transação já concluída)
            $fromWallet = User::find($transferData['from_user_id'])->wallet;
            $toWallet = User::find($transferData['to_user_id'])->wallet;

            $fromWallet->decrement('balance', $transferData['amount']);
            $toWallet->increment('balance', $transferData['amount']);
        }
    }
}