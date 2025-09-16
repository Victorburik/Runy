@extends('layouts.app')

@section('title', 'Oops! Algo deu errado')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-6xl font-bold text-red-500 mb-4">:(</h1>
        <h2 class="text-2xl font-semibold mb-2">Ops! Algo deu errado.</h2>
        <p class="text-gray-600 mb-6">Não conseguimos processar sua solicitação no momento.</p>
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" 
           class="inline-block bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-600 transition">
           Voltar
        </a>
    </div>
</div>
@endsection