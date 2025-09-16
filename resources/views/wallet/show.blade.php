@extends('layouts.app')

@section('title', 'Minha Carteira')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl mb-4">Minha Carteira</h1>
    <p><strong>Saldo:</strong> R$ {{ number_format($wallet->balance, 2, ',', '.') }}</p>
    <div class="mt-4 space-y-2">
        <a href="{{ route('wallet.deposit') }}" class="block bg-blue-500 text-white p-2 text-center">Depositar</a>
        <a href="{{ route('dashboard') }}" class="block bg-gray-500 text-white p-2 text-center">Voltar ao Dashboard</a>
    </div>
</div>
@endsection