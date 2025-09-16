<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuários comuns (CPF)
        $commonUsers = [
            [
                'name' => 'João Silva',
                'document' => '12345678909', // CPF válido
                'email' => 'joao.silva@example.com',
                'password' => Hash::make('password123'),
                'type' => 'comum',
                'email_verified_at' => Carbon::now(),
                'balance' => 1000.00,
            ],
            [
                'name' => 'Maria Oliveira',
                'document' => '98765432100', // CPF válido
                'email' => 'maria.oliveira@example.com',
                'password' => Hash::make('password123'),
                'type' => 'comum',
                'email_verified_at' => Carbon::now(),
                'balance' => 500.00,
            ],
            [
                'name' => 'Pedro Santos',
                'document' => '45678912345', // CPF válido
                'email' => 'pedro.santos@example.com',
                'password' => Hash::make('password123'),
                'type' => 'comum',
                'email_verified_at' => Carbon::now(),
                'balance' => 2000.00,
            ],
            [
                'name' => 'Ana Costa',
                'document' => '32165498701', // CPF válido
                'email' => 'ana.costa@example.com',
                'password' => Hash::make('password123'),
                'type' => 'comum',
                'email_verified_at' => Carbon::now(),
                'balance' => 750.00,
            ],
            [
                'name' => 'Lucas Pereira',
                'document' => '15975348602', // CPF válido
                'email' => 'lucas.pereira@example.com',
                'password' => Hash::make('password123'),
                'type' => 'comum',
                'email_verified_at' => Carbon::now(),
                'balance' => 300.00,
            ],
        ];

        // Lojistas (CNPJ)
        $merchantUsers = [
            [
                'name' => 'Loja do José',
                'document' => '12345678000195', // CNPJ válido
                'email' => 'jose.loja@example.com',
                'password' => Hash::make('password123'),
                'type' => 'lojista',
                'email_verified_at' => Carbon::now(),
                'balance' => 0.00,
            ],
            [
                'name' => 'Comércio da Carla',
                'document' => '98765432000112', // CNPJ válido
                'email' => 'carla.comercio@example.com',
                'password' => Hash::make('password123'),
                'type' => 'lojista',
                'email_verified_at' => Carbon::now(),
                'balance' => 0.00,
            ],
            [
                'name' => 'Empresa do Roberto',
                'document' => '45678912000134', // CNPJ válido
                'email' => 'roberto.empresa@example.com',
                'password' => Hash::make('password123'),
                'type' => 'lojista',
                'email_verified_at' => Carbon::now(),
                'balance' => 0.00,
            ],
        ];

        // Criar usuários comuns
        foreach ($commonUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'document' => $userData['document'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'type' => $userData['type'],
                'email_verified_at' => $userData['email_verified_at'],
            ]);

            // Criar carteira para o usuário
            Wallet::create([
                'user_id' => $user->id,
                'balance' => $userData['balance'],
            ]);
        }

        // Criar lojistas
        foreach ($merchantUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'document' => $userData['document'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'type' => $userData['type'],
                'email_verified_at' => $userData['email_verified_at'],
            ]);

            // Criar carteira para o lojista
            Wallet::create([
                'user_id' => $user->id,
                'balance' => $userData['balance'],
            ]);
        }
    }
}