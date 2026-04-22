@extends('layouts.frontend')

@section('title', 'Funcionalidades - Financeiro Pro Whats')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-4">Funcionalidades</h1>
        <p class="text-xl text-center text-blue-100">
            Tudo que você precisa para gerenciar suas cobranças
        </p>
    </div>
</section>

<!-- Features Grid -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-600 text-4xl mb-4">💳</div>
                <h3 class="text-xl font-semibold mb-3">Múltiplos Gateways de Pagamento</h3>
                <p class="text-gray-600 mb-4">
                    Integração completa com Stripe, MercadoPago e Efi. Aceite cartões de crédito, boletos, PIX e mais.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Stripe Payment Gateway</li>
                    <li>✓ MercadoPago SDK</li>
                    <li>✓ Efi (Gerencianet)</li>
                </ul>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-green-600 text-4xl mb-4">💬</div>
                <h3 class="text-xl font-semibold mb-3">Automação via WhatsApp</h3>
                <p class="text-gray-600 mb-4">
                    Envie lembretes de cobrança, notificações de pagamento e mensagens personalizadas automaticamente.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Evolution API Integration</li>
                    <li>✓ Templates personalizáveis</li>
                    <li>✓ Envio automático</li>
                </ul>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-purple-600 text-4xl mb-4">🏢</div>
                <h3 class="text-xl font-semibold mb-3">Multi-tenant SaaS</h3>
                <p class="text-gray-600 mb-4">
                    Gerencie múltiplos clientes (tenants) com total isolamento de dados e configurações independentes.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Isolamento completo</li>
                    <li>✓ Domínios personalizados</li>
                    <li>✓ Configurações por tenant</li>
                </ul>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-red-600 text-4xl mb-4">📊</div>
                <h3 class="text-xl font-semibold mb-3">Dashboard Completo</h3>
                <p class="text-gray-600 mb-4">
                    Visualize estatísticas, receitas, cobranças pendentes e muito mais em tempo real.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Estatísticas em tempo real</li>
                    <li>✓ Gráficos e relatórios</li>
                    <li>✓ Exportação de dados</li>
                </ul>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-yellow-600 text-4xl mb-4">🔔</div>
                <h3 class="text-xl font-semibold mb-3">Lembretes Automáticos</h3>
                <p class="text-gray-600 mb-4">
                    Sistema de cron jobs que envia lembretes automáticos para cobranças vencidas ou próximas do vencimento.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Agendamento automático</li>
                    <li>✓ Email e WhatsApp</li>
                    <li>✓ Configurável por tenant</li>
                </ul>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-indigo-600 text-4xl mb-4">🔐</div>
                <h3 class="text-xl font-semibold mb-3">Segurança Avançada</h3>
                <p class="text-gray-600 mb-4">
                    Criptografia de credenciais, validação HMAC de webhooks, proteção CSRF e muito mais.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Criptografia AES-256</li>
                    <li>✓ Validação HMAC</li>
                    <li>✓ IP Whitelist</li>
                </ul>
            </div>

            <!-- Feature 7 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-pink-600 text-4xl mb-4">📧</div>
                <h3 class="text-xl font-semibold mb-3">Templates Personalizáveis</h3>
                <p class="text-gray-600 mb-4">
                    Crie templates de email e WhatsApp com variáveis dinâmicas para personalizar suas mensagens.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Editor visual</li>
                    <li>✓ Variáveis dinâmicas</li>
                    <li>✓ Preview em tempo real</li>
                </ul>
            </div>

            <!-- Feature 8 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-teal-600 text-4xl mb-4">🔄</div>
                <h3 class="text-xl font-semibold mb-3">Webhooks Inteligentes</h3>
                <p class="text-gray-600 mb-4">
                    Receba notificações em tempo real de todos os eventos de pagamento dos gateways.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Processamento assíncrono</li>
                    <li>✓ Logs detalhados</li>
                    <li>✓ Retry automático</li>
                </ul>
            </div>

            <!-- Feature 9 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-orange-600 text-4xl mb-4">👥</div>
                <h3 class="text-xl font-semibold mb-3">Gestão de Clientes</h3>
                <p class="text-gray-600 mb-4">
                    Cadastre e gerencie seus clientes com informações completas e histórico de cobranças.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Cadastro completo</li>
                    <li>✓ Histórico de pagamentos</li>
                    <li>✓ Notas e observações</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Experimente todas essas funcionalidades</h2>
        <p class="text-xl text-gray-600 mb-8">
            Acesse o sistema e descubra como podemos ajudar seu negócio
        </p>
        <div class="flex gap-4 justify-center">
            <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Acessar Sistema
            </a>
            <a href="{{ route('home.pricing') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                Ver Preços
            </a>
        </div>
    </div>
</section>
@endsection
