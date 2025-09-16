<div>
    <h1 class="text-2xl mb-4">Depositar</h1>
    <form wire:submit.prevent="deposit">
        <input wire:model="amount" type="number" step="0.01" placeholder="Valor do Depósito" class="w-full p-2 border mb-2">
        @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
        <button type="submit" class="w-full bg-blue-500 text-white p-2" wire:loading.attr="disabled">Depositar</button>
    </form>
    <a href="{{ route('wallet.show') }}" class="mt-4 inline-block">Voltar</a>
</div>