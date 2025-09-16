@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl mb-4">Usuários</h1>
    @foreach($users as $user)
        <p>{{ $user->name }} ({{ $user->type === 'comum' ? 'Usuário Comum' : 'Lojista' }}) - {{ $user->document }}</p>
    @endforeach
    @if($users->isEmpty())
        <p>Nenhum usuário encontrado.</p>
    @endif
    <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-blue-500 text-white p-2">Voltar ao Dashboard</a>
</div>
@endsection