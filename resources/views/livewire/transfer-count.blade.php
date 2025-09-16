<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Nova Transferência</h2>

    @if (session()->has('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-3 mb-4 rounded shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @error('amount')
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-3 mb-4 rounded shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            {{ $message }}
        </div>
    @enderror

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">Destinatário</label>
            <select wire:model="to_user_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Selecione o destinatário</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->type === 'comum' ? 'Usuário Comum' : 'Lojista' }})
                    </option>
                @endforeach
            </select>
            @error('to_user_id') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Valor</label>
            <input type="number" wire:model="amount" step="0.01" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="R$ 0,00">
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded shadow hover:bg-blue-600 transition">
                Enviar Transferência
            </button>
        </div>
    </form>
</div>
