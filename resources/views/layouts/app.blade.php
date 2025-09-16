<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Runy Transferências Light</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold tracking-wide">
                    Runy Transferências
                </a>

                @auth
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                        <a href="{{ route('transfers.index') }}" class="hover:underline">Transferências</a>
                        <a href="{{ route('users.profile') }}" class="hover:underline">Perfil</a>

                        <!-- Logout dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-1 px-3 py-2 bg-blue-700 rounded hover:bg-blue-800 transition">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-lg py-2 z-50">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 transition">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="px-3 py-2 bg-white text-blue-600 rounded shadow hover:bg-gray-100 transition">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 bg-white text-blue-600 rounded shadow hover:bg-gray-100 transition">Cadastro</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded shadow">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 mb-4 rounded shadow">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Alpine.data('documentMask', () => ({
                mask: '999.999.999-99',
                updateMask(type) {
                    this.mask = type === 'comum' ? '999.999.999-99' : '99.999.999/9999-99';
                }
            }));
        });
    </script>
</body>
</html>
