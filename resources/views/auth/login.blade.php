@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bem-vindo de volta</h1>
            <p class="text-gray-500">Entre com suas credenciais para continuar</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-gray-700 mb-1">E-mail</label>
                <input type="email" name="email" id="email" placeholder="seu@email.com" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" 
                       required>
                @error('email') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <div x-data="{ showPassword: false }">
                <label for="password" class="block text-gray-700 mb-1">Senha</label>
                <div class="relative">
                    <input type="password" name="password" id="password" 
                           x-bind:type="showPassword ? 'text' : 'password'" 
                           placeholder="Sua senha" 
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    <button type="button" 
                            x-on:click="showPassword = !showPassword" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-500 text-sm font-semibold hover:underline">
                        <span x-text="showPassword ? 'Ocultar' : 'Mostrar'"></span>
                    </button>
                </div>
                @error('password') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-600 transition">
                Entrar
            </button>
        </form>

        <div class="text-center text-gray-500">
            <a href="{{ route('register') }}" class="font-medium text-blue-500 hover:underline">Não tem conta? Cadastre-se</a>
        </div>
    </div>
</div>
@endsection
