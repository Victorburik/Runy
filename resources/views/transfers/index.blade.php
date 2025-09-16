@extends('layouts.app')

@section('title', 'Histórico de Transferências')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Histórico de Transferências</h1>

    @if($transfers->isEmpty())
        <p class="text-gray-500">Nenhuma transferência encontrada.</p>
    @else
        <div class="space-y-4">
            @foreach($transfers as $transfer)
                @php
                    $isSent = $transfer->from_user_id == auth()->id();
                    $statusColor = $transfer->status === 'completed' ? 'green' : ($transfer->status === 'pending' ? 'yellow' : 'red');
                @endphp

                <div class="flex justify-between items-center p-4 border rounded shadow-sm bg-{{ $statusColor }}-50">
                    <div>
                        <p class="font-medium">
                            {{ $isSent ? 'Enviado para' : 'Recebido de' }} 
                            {{ $isSent ? $transfer->toUser->name : $transfer->fromUser->name }}
                        </p>
                        <p class="text-gray-600 text-sm">
                            R$ {{ number_format($transfer->amount, 2, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <span class="px-2 py-1 text-sm font-semibold rounded bg-{{ $statusColor }}-200 text-{{ $statusColor }}-800">
                            {{ ucfirst($transfer->status) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('transfers.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
            Nova Transferência
        </a>
    </div>
</div>
@endsection
