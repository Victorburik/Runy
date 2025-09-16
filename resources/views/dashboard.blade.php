@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8 space-y-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Olá, {{ auth()->user()->name }}</h1>
                <p class="text-gray-500">Bem-vindo ao seu painel de controle</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <a href="{{ route('users.profile') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg shadow hover:from-blue-600 hover:to-indigo-600 transition">
                    Perfil
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition">
                        Sair
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-gray-50 rounded-lg p-6 shadow hover:shadow-lg transition">
                <h2 class="text-gray-600 font-semibold mb-2">Saldo</h2>
                <p class="text-2xl font-bold text-gray-800">R$ {{ number_format(auth()->user()->wallet->balance, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-6 shadow hover:shadow-lg transition">
                <h2 class="text-gray-600 font-semibold mb-2">Tipo</h2>
                <p class="text-xl font-medium text-gray-800">
                    {{ auth()->user()->type === 'comum' ? 'Usuário Comum' : 'Lojista' }}
                </p>
            </div>
            <div class="bg-gray-50 rounded-lg p-6 shadow hover:shadow-lg transition">
                <h2 class="text-gray-600 font-semibold mb-2">Ações Rápidas</h2>
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('transfers.create') }}" 
                       class="block px-3 py-2 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition">
                        Nova Transferência
                    </a>
                    <a href="{{ route('wallet.show') }}" 
                       class="block px-3 py-2 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition">
                        Minha Carteira
                    </a>
                    <a href="{{ route('wallet.deposit') }}" 
                       class="block px-3 py-2 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition">
                        Depositar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
