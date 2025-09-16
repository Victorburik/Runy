@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl mb-4">Meu Perfil</h1>
    <p><strong>Nome:</strong> {{ $user->name }}</p>
    <p><strong>Documento:</strong> {{ $user->document }}</p>
    <p><strong>E-mail:</strong> {{ $user->email }}</p>
    <p><strong>Tipo:</strong> {{ $user->type === 'comum' ? 'Usuário Comum' : 'Lojista' }}</p>
    <p><strong>Saldo:</strong> R$ {{ number_format($user->wallet->balance, 2, ',', '.') }}</p>
    <p><strong>E-mail Verificado:</strong> {{ $user->hasVerifiedEmail() ? 'Sim' : 'Não' }}</p>
    <div class="mt-4 space-y-2">
        <a href="{{ route('users.edit') }}" class="block bg-blue-500 text-white p-2 text-center">Editar Perfil</a>
        <form action="{{ route('users.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="password" name="password" placeholder="Confirme sua senha" class="w-full p-2 border mb-2" required>
            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            <button type="submit" class="w-full bg-red-500 text-white p-2" onclick="return confirm('Tem certeza que deseja excluir sua conta?')">Excluir Conta</button>
        </form>
    </div>
</div>
@endsection