@extends('layouts.frontend')

@section('title', 'Sobre - Financeiro Pro Whats')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-4">Sobre o Financeiro Pro Whats</h1>
        <p class="text-xl text-center text-blue-100">
            Solução completa para gestão financeira e automação
        </p>
    </div>
</section>

<!-- About Content -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Nossa Missão</h2>
                <p class="text-lg text-gray-700 mb-4">
                    O Financeiro Pro Whats foi desenvolvido para simplificar a gestão financeira de empresas,
                    oferecendo uma plataforma completa de cobrança, faturamento e automação de comunicação.
                </p>
                <p class="text-lg text-gray-700">
                    Nossa missão é proporcionar ferramentas poderosas e fáceis de usar que permitam aos
                    negócios focarem no que realmente importa: crescer e atender seus clientes.
                </p>
            </div>

            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">O que oferecemos</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">✓</div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2">Gestão Completa de Cobranças</h3>
                            <p class="text-gray-600">
                                Crie, gerencie e acompanhe todas as suas cobranças em um único lugar.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">✓</div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2">Integração com Múltiplos Gateways</h3>
                            <p class="text-gray-600">
                                Aceite pagamentos via Stripe, MercadoPago e Efi com total segurança.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">✓</div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2">Automação via WhatsApp</h3>
                            <p class="text-gray-600">
                                Envie lembretes automáticos de cobrança e notificações via WhatsApp.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">✓</div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2">Arquitetura Multi-tenant</h3>
                            <p class="text-gray-600">
                                Gerencie múltiplos clientes com total isolamento e segurança de dados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Tecnologia</h2>
                <p class="text-lg text-gray-700 mb-4">
                    Desenvolvido com as mais modernas tecnologias do mercado:
                </p>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Backend</h4>
                        <p class="text-gray-600">Laravel 12, PHP 8.4+, MySQL</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Frontend</h4>
                        <p class="text-gray-600">React, Vite, TailwindCSS</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Integrações</h4>
                        <p class="text-gray-600">Stripe, MercadoPago, Efi, Evolution API</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Segurança</h4>
                        <p class="text-gray-600">Criptografia, HMAC, SSL/TLS</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-8 rounded-lg text-center">
                <h3 class="text-2xl font-bold mb-4">Pronto para começar?</h3>
                <p class="text-gray-700 mb-6">
                    Acesse o sistema e comece a gerenciar suas cobranças agora mesmo.
                </p>
                <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block">
                    Acessar Sistema
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
