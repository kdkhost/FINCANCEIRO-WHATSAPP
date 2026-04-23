#!/bin/bash

# Script de Correção de Erros no Servidor
# Execute este script no servidor para corrigir os problemas

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                                                                ║"
echo "║         Correção de Erros - Financeiro Pro Whats              ║"
echo "║                                                                ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Verificar se está no diretório correto
if [ ! -f "artisan" ]; then
    echo "❌ ERRO: Execute este script no diretório raiz do projeto!"
    echo "   cd /caminho/para/public_html"
    exit 1
fi

echo "📍 Diretório atual: $(pwd)"
echo ""

# Problema 1: Collision Service Provider
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔧 Corrigindo problema do Composer..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Limpar cache do Composer
echo "1️⃣  Limpando cache do Composer..."
composer clear-cache

# Remover vendor
echo ""
echo "2️⃣  Removendo pasta vendor..."
rm -rf vendor

# Reinstalar dependências
echo ""
echo "3️⃣  Reinstalando dependências (isso pode demorar)..."
composer install --no-dev --no-scripts --optimize-autoloader \
    --ignore-platform-req=ext-curl \
    --ignore-platform-req=ext-pcntl

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Erro ao instalar dependências!"
    echo "   Tente manualmente:"
    echo "   composer install --no-dev --no-scripts"
    exit 1
fi

# Regenerar autoload
echo ""
echo "4️⃣  Regenerando autoload..."
composer dump-autoload --optimize

echo ""
echo "✅ Dependências do Composer corrigidas!"
echo ""

# Problema 2: Assets do Frontend
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎨 Verificando assets do frontend..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

if [ ! -d "public/build" ]; then
    echo "⚠️  Pasta public/build não encontrada!"
    echo ""
    echo "📦 OPÇÕES:"
    echo ""
    echo "OPÇÃO 1: Enviar assets compilados do seu PC"
    echo "   1. No seu PC: npm run build"
    echo "   2. Comprimir: tar -czf build.tar.gz public/build/"
    echo "   3. Enviar: scp build.tar.gz usuario@servidor:$(pwd)/"
    echo "   4. Descompactar: tar -xzf build.tar.gz && rm build.tar.gz"
    echo ""
    echo "OPÇÃO 2: Instalar Node.js no servidor"
    echo "   curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash"
    echo "   source ~/.bashrc"
    echo "   nvm install 18"
    echo "   npm install && npm run build"
    echo ""
else
    echo "✅ Assets encontrados em public/build/"
fi

# Configurar permissões
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔒 Configurando permissões..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

chmod -R 775 storage bootstrap/cache
echo "✅ Permissões configuradas!"

# Verificar .env
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "⚙️  Verificando configuração..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

if [ ! -f ".env" ]; then
    echo "⚠️  Arquivo .env não encontrado!"
    echo "   Criando a partir do .env.example..."
    cp .env.example .env
    echo "✅ Arquivo .env criado!"
    echo ""
    echo "⚠️  IMPORTANTE: Edite o .env com suas configurações:"
    echo "   nano .env"
    echo ""
else
    echo "✅ Arquivo .env encontrado!"
fi

# Verificar APP_KEY
if ! grep -q "APP_KEY=base64:" .env; then
    echo ""
    echo "⚠️  APP_KEY não configurada!"
    echo "   Gerando chave..."
    php artisan key:generate --force
    echo "✅ Chave gerada!"
fi

# Limpar cache
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🧹 Limpando cache..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "✅ Cache limpo!"

# Resumo final
echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                                                                ║"
echo "║                    ✅ CORREÇÕES CONCLUÍDAS                    ║"
echo "║                                                                ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
echo "📋 PRÓXIMOS PASSOS:"
echo ""
echo "1️⃣  Configure o .env:"
echo "   nano .env"
echo ""
echo "2️⃣  Execute as migrations:"
echo "   php artisan migrate --force"
echo ""
echo "3️⃣  Execute os seeders:"
echo "   php artisan db:seed --force"
echo ""
echo "4️⃣  Otimize para produção:"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo "   php artisan view:cache"
echo ""
echo "5️⃣  Se ainda não tiver os assets, envie do seu PC:"
echo "   No PC: npm run build"
echo "   No PC: tar -czf build.tar.gz public/build/"
echo "   No PC: scp build.tar.gz usuario@servidor:$(pwd)/"
echo "   No servidor: tar -xzf build.tar.gz && rm build.tar.gz"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
