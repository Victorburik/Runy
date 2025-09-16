@extends('layouts.app')

@section('title', 'Verificar E-mail')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl mb-4">Verificar E-mail</h1>
    <p>Um link de verificação foi enviado para {{ auth()->user()->email }}.</p>
    <p>Por favor, verifique seu e-mail para continuar.</p>
    @if (session('status'))
        <p class="text-green-500">{{ session('status') }}</p>
    @endif
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="mt-4 bg-blue-500 text-white p-2">Reenviar E-mail</button>
    </form>
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit">Sair</button>
    </form>
</div>
@endsection