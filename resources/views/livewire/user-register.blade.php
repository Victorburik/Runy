<div>
    <h1 class="text-2xl mb-4">Cadastro</h1>
    <form wire:submit.prevent="register">
        <input wire:model="name" type="text" placeholder="Nome Completo" class="w-full p-2 border mb-2">
        @error('name')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <select wire:model="type" class="w-full p-2 border mb-2"
            x-on:change="$dispatch('update-mask', { type: $event.target.value })">
            <option value="comum">Usuário Comum</option>
            <option value="lojista">Lojista</option>
        </select>
        @error('type')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="document" type="text" placeholder="CPF ou CNPJ" class="w-full p-2 border mb-2"
            x-data="documentMask" x-bind:x-mask="mask"
            x-on:update-mask.window="updateMask($event.detail.type)">
        @error('document')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="email" type="email" placeholder="E-mail" class="w-full p-2 border mb-2">
        @error('email')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="password" type="password" placeholder="Senha" class="w-full p-2 border mb-2">
        @error('password')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="password_confirmation" type="password" placeholder="Confirme Senha"
            class="w-full p-2 border mb-2">
        @error('password_confirmation')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <button type="submit" class="w-full bg-blue-500 text-white p-2" wire:loading.attr="disabled">Cadastrar</button>
    </form>
    <a href="{{ route('login') }}" class="mt-4 inline-block">Já tem conta? Login</a>
</div>
