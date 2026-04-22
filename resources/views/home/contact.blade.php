@extends('layouts.frontend')

@section('title', 'Contato - Financeiro Pro Whats')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-4">Entre em Contato</h1>
        <p class="text-xl text-center text-blue-100">
            Estamos aqui para ajudar você
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-2xl font-bold mb-6">Envie uma Mensagem</h2>
                    <form class="space-y-4" action="#" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nome Completo
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Seu nome"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="seu@email.com"
                            >
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Telefone
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="(00) 00000-0000"
                            >
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                                Assunto
                            </label>
                            <select 
                                id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Selecione um assunto</option>
                                <option value="sales">Vendas</option>
                                <option value="support">Suporte Técnico</option>
                                <option value="billing">Financeiro</option>
                                <option value="partnership">Parcerias</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                Mensagem
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Como podemos ajudar?"
                            ></textarea>
                        </div>

                        <button 
                            type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
                        >
                            Enviar Mensagem
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div>
                    <h2 class="text-2xl font-bold mb-6">Informações de Contato</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="text-blue-600 text-2xl mr-4">📧</div>
                            <div>
                                <h3 class="font-semibold mb-1">Email</h3>
                                <p class="text-gray-600">contato@financeiroprowhats.com</p>
                                <p class="text-gray-600">suporte@financeiroprowhats.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="text-blue-600 text-2xl mr-4">💬</div>
                            <div>
                                <h3 class="font-semibold mb-1">WhatsApp</h3>
                                <p class="text-gray-600">+55 (11) 99999-9999</p>
                                <p class="text-sm text-gray-500">Seg-Sex: 9h às 18h</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="text-blue-600 text-2xl mr-4">🕐</div>
                            <div>
                                <h3 class="font-semibold mb-1">Horário de Atendimento</h3>
                                <p class="text-gray-600">Segunda a Sexta: 9h às 18h</p>
                                <p class="text-gray-600">Sábado: 9h às 13h</p>
                                <p class="text-gray-600">Domingo: Fechado</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="text-blue-600 text-2xl mr-4">📍</div>
                            <div>
                                <h3 class="font-semibold mb-1">Endereço</h3>
                                <p class="text-gray-600">
                                    Av. Paulista, 1000<br>
                                    São Paulo - SP<br>
                                    CEP: 01310-100
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-8">
                        <h3 class="font-semibold mb-4">Redes Sociais</h3>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                <span class="text-xl">f</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition">
                                <span class="text-xl">t</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                                <span class="text-xl">in</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition">
                                <span class="text-xl">yt</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Perguntas Frequentes</h2>
        <div class="max-w-3xl mx-auto space-y-4">
            <details class="bg-white p-6 rounded-lg shadow">
                <summary class="font-semibold cursor-pointer">
                    Qual o tempo de resposta do suporte?
                </summary>
                <p class="text-gray-600 mt-3">
                    Nosso tempo médio de resposta é de 2 horas em dias úteis. Para clientes Enterprise, 
                    oferecemos suporte 24/7 com SLA garantido.
                </p>
            </details>

            <details class="bg-white p-6 rounded-lg shadow">
                <summary class="font-semibold cursor-pointer">
                    Como funciona o período de teste?
                </summary>
                <p class="text-gray-600 mt-3">
                    Oferecemos 14 dias de teste gratuito em todos os planos, sem necessidade de cartão de crédito.
                </p>
            </details>

            <details class="bg-white p-6 rounded-lg shadow">
                <summary class="font-semibold cursor-pointer">
                    Vocês oferecem treinamento?
                </summary>
                <p class="text-gray-600 mt-3">
                    Sim! Oferecemos treinamento completo para todos os clientes, incluindo documentação, 
                    vídeos tutoriais e sessões ao vivo para planos Professional e Enterprise.
                </p>
            </details>

            <details class="bg-white p-6 rounded-lg shadow">
                <summary class="font-semibold cursor-pointer">
                    É possível integrar com outros sistemas?
                </summary>
                <p class="text-gray-600 mt-3">
                    Sim! Oferecemos API REST completa para integração com ERPs, CRMs e outros sistemas. 
                    Também podemos desenvolver integrações customizadas para clientes Enterprise.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Prefere começar agora?</h2>
        <p class="text-xl mb-8 text-blue-100">
            Acesse o sistema e comece a usar imediatamente
        </p>
        <a href="{{ route('admin.login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">
            Acessar Sistema
        </a>
    </div>
</section>
@endsection
