@extends('layouts.frontend')

@section('title', 'Preços - Financeiro Pro Whats')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-4">Planos e Preços</h1>
        <p class="text-xl text-center text-blue-100">
            Escolha o plano ideal para o seu negócio
        </p>
    </div>
</section>

<!-- Pricing Cards -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Starter Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold mb-2">Starter</h3>
                    <p class="text-gray-600 mb-4">Para pequenos negócios</p>
                    <div class="text-4xl font-bold text-blue-600 mb-2">
                        R$ 97
                        <span class="text-lg text-gray-500 font-normal">/mês</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Até 100 clientes</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>500 cobranças/mês</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>1 gateway de pagamento</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>WhatsApp automático</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Suporte por email</span>
                    </li>
                </ul>
                <a href="{{ route('admin.login') }}" class="block w-full bg-gray-200 text-gray-700 text-center py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Começar Agora
                </a>
            </div>

            <!-- Professional Plan (Featured) -->
            <div class="bg-white rounded-lg shadow-xl p-8 border-4 border-blue-600 relative hover:shadow-2xl transition">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Mais Popular
                    </span>
                </div>
                <div class="text-center mb-6 mt-4">
                    <h3 class="text-2xl font-bold mb-2">Professional</h3>
                    <p class="text-gray-600 mb-4">Para negócios em crescimento</p>
                    <div class="text-4xl font-bold text-blue-600 mb-2">
                        R$ 197
                        <span class="text-lg text-gray-500 font-normal">/mês</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Até 500 clientes</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>2.000 cobranças/mês</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>3 gateways de pagamento</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>WhatsApp automático</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Templates personalizados</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Suporte prioritário</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>API access</span>
                    </li>
                </ul>
                <a href="{{ route('admin.login') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Começar Agora
                </a>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                    <p class="text-gray-600 mb-4">Para grandes empresas</p>
                    <div class="text-4xl font-bold text-blue-600 mb-2">
                        Customizado
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Clientes ilimitados</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Cobranças ilimitadas</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Todos os gateways</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>WhatsApp dedicado</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Customizações</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Suporte 24/7</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>SLA garantido</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 mr-2">✓</span>
                        <span>Gerente dedicado</span>
                    </li>
                </ul>
                <a href="{{ route('home.contact') }}" class="block w-full bg-gray-200 text-gray-700 text-center py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Falar com Vendas
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Comparison -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Comparação de Recursos</h2>
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Recurso</th>
                        <th class="px-6 py-4 text-center">Starter</th>
                        <th class="px-6 py-4 text-center">Professional</th>
                        <th class="px-6 py-4 text-center">Enterprise</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="px-6 py-4">Clientes</td>
                        <td class="px-6 py-4 text-center">100</td>
                        <td class="px-6 py-4 text-center">500</td>
                        <td class="px-6 py-4 text-center">Ilimitado</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">Cobranças/mês</td>
                        <td class="px-6 py-4 text-center">500</td>
                        <td class="px-6 py-4 text-center">2.000</td>
                        <td class="px-6 py-4 text-center">Ilimitado</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">Gateways de Pagamento</td>
                        <td class="px-6 py-4 text-center">1</td>
                        <td class="px-6 py-4 text-center">3</td>
                        <td class="px-6 py-4 text-center">Todos</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">WhatsApp Automático</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">Templates Personalizados</td>
                        <td class="px-6 py-4 text-center text-gray-300">-</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">API Access</td>
                        <td class="px-6 py-4 text-center text-gray-300">-</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                        <td class="px-6 py-4 text-center text-green-500">✓</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">Suporte</td>
                        <td class="px-6 py-4 text-center">Email</td>
                        <td class="px-6 py-4 text-center">Prioritário</td>
                        <td class="px-6 py-4 text-center">24/7</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Perguntas Frequentes</h2>
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg mb-2">Posso mudar de plano depois?</h3>
                <p class="text-gray-600">
                    Sim! Você pode fazer upgrade ou downgrade do seu plano a qualquer momento.
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg mb-2">Há taxa de setup?</h3>
                <p class="text-gray-600">
                    Não, não cobramos taxa de setup. Você paga apenas a mensalidade do plano escolhido.
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg mb-2">Posso cancelar a qualquer momento?</h3>
                <p class="text-gray-600">
                    Sim, você pode cancelar sua assinatura a qualquer momento sem multas ou taxas adicionais.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Pronto para começar?</h2>
        <p class="text-xl mb-8 text-blue-100">
            Escolha seu plano e comece a gerenciar suas cobranças hoje mesmo
        </p>
        <a href="{{ route('admin.login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">
            Acessar Sistema
        </a>
    </div>
</section>
@endsection
