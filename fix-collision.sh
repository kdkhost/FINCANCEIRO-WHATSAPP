#!/bin/bash

echo "═══════════════════════════════════════════════════════════════════════════"
echo "  CORREÇÃO DEFINITIVA DO ERRO COLLISION"
echo "═══════════════════════════════════════════════════════════════════════════"
echo ""

# 1. Atualizar código
echo "1. Atualizando código do Git..."
git pull origin master

# 2. Limpar cache do Composer
echo ""
echo "2. Limpando cache do Composer..."
composer clear-cache

# 3. Remover arquivos de cache do Laravel
echo ""
echo "3. Removendo cache de packages descobertos..."
rm -f bootstrap/cache/packages.php
rm -f bootstrap/cache/services.php

# 4. Regenerar autoload
echo ""
echo "4. Regenerando autoload..."
composer dump-autoload --optimize

# 5. Criar pastas necessárias
echo ""
echo "5. Criando pastas de cache..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# 6. Configurar permissões
echo ""
echo "6. Configurando permissões..."
chmod -R 775 storage bootstrap/cache

# 7. Testar
echo ""
echo "7. Testando artisan..."
php artisan --version

echo ""
echo "═══════════════════════════════════════════════════════════════════════════"
echo "✅ Correção concluída!"
echo "═══════════════════════════════════════════════════════════════════════════"
echo ""
echo "Agora execute:"
echo "  php artisan key:generate --force"
echo "  php artisan migrate --force"
echo "  php artisan db:seed --force"
echo ""
