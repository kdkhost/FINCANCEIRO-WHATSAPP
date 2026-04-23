<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN (temporário até assets funcionarem) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Scripts -->
    @vite(['resources/css/frontend.css', 'resources/js/frontend/app.jsx'])
</head>
<body class="font-sans antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        Financeiro Pro Whats
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Início
                    </a>
                    <a href="{{ route('home.features') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Funcionalidades
                    </a>
                    <a href="{{ route('home.pricing') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Preços
                    </a>
                    <a href="{{ route('home.about') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Sobre
                    </a>
                    <a href="{{ route('home.contact') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Contato
                    </a>
                    <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Acessar
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                        Início
                    </a>
                    <a href="{{ route('home.features') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                        Funcionalidades
                    </a>
                    <a href="{{ route('home.pricing') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                        Preços
                    </a>
                    <a href="{{ route('home.about') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                        Sobre
                    </a>
                    <a href="{{ route('home.contact') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                        Contato
                    </a>
                    <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                        Acessar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Financeiro Pro Whats</h3>
                    <p class="text-gray-400 mb-4">
                        Sistema completo de gestão financeira e automação para WhatsApp.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="font-semibold mb-4">Produto</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home.features') }}" class="text-gray-400 hover:text-white transition">Funcionalidades</a></li>
                        <li><a href="{{ route('home.pricing') }}" class="text-gray-400 hover:text-white transition">Preços</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Integrações</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">API</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-semibold mb-4">Empresa</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home.about') }}" class="text-gray-400 hover:text-white transition">Sobre</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Carreiras</a></li>
                        <li><a href="{{ route('home.contact') }}" class="text-gray-400 hover:text-white transition">Contato</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-4">Suporte</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Central de Ajuda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Documentação</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Status</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Termos de Uso</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Financeiro Pro Whats. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
