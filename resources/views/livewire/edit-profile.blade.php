<div>
    <h1 class="text-2xl mb-4">Editar Perfil</h1>
    <form wire:submit.prevent="submit">
        <input wire:model="name" type="text" placeholder="Nome Completo" class="w-full p-2 border mb-2">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <input wire:model="email" type="email" placeholder="E-mail" class="w-full p-2 border mb-2">
        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

        <input wire:model="password" type="password" placeholder="Nova Senha (opcional)" class="w-full p-2 border mb-2">
        @error('password') <span class="text-red-500">{{ $message }}</span> @enderror

        <input wire:model="password_confirmation" type="password" placeholder="Confirme Nova Senha" class="w-full p-2 border mb-2">
        @error('password_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror

        <button type="submit" class="w-full bg-blue-500 text-white p-2" wire:loading.attr="disabled">Salvar</button>
    </form>
    <a href="{{ route('users.profile') }}" class="mt-4 inline-block">Voltar</a>
</div>