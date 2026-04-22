@extends('layouts.frontend')

@section('title', 'Financeiro Pro Whats - Sistema de Gestão Financeira e Automação')

@section('content')
<!-- Hero Section -->
<section class="hero bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">
                Gestão Financeira e Automação para WhatsApp
            </h1>
            <p class="text-xl mb-8 text-blue-100">
                Sistema completo de cobrança, faturamento e automação de mensagens para seu negócio
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('admin.login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Acessar Sistema
                </a>
                <a href="{{ route('home.features') }}" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition">
                    Conhecer Recursos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Overview -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Principais Recursos</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-blue-600 text-4xl mb-4">💳</div>
                <h3 class="text-xl font-semibold mb-3">Múltiplos Gateways</h3>
                <p class="text-gray-600">
                    Integração com Stripe, MercadoPago e Efi. Aceite pagamentos de diversas formas.
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-green-600 text-4xl mb-4">💬</div>
                <h3 class="text-xl font-semibold mb-3">WhatsApp Automático</h3>
                <p class="text-gray-600">
                    Envie lembretes de cobrança e notificações automaticamente via WhatsApp.
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-purple-600 text-4xl mb-4">🏢</div>
                <h3 class="text-xl font-semibold mb-3">Multi-tenant</h3>
                <p class="text-gray-600">
                    Gerencie múltiplos clientes com isolamento completo de dados.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">99.9%</div>
                <div class="text-gray-600">Uptime</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">3</div>
                <div class="text-gray-600">Gateways de Pagamento</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">24/7</div>
                <div class="text-gray-600">Automação</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">100%</div>
                <div class="text-gray-600">Seguro</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Pronto para começar?</h2>
        <p class="text-xl mb-8 text-blue-100">
            Simplifique sua gestão financeira e automação de cobranças
        </p>
        <a href="{{ route('admin.login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">
            Acessar Agora
        </a>
    </div>
</section>
@endsection
