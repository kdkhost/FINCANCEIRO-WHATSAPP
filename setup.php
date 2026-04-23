#!/usr/bin/env php
<?php

/**
 * Script de Setup do Sistema
 * Execute: php setup.php
 */

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  SETUP - Financeiro Pro Whats\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

// 1. Verificar se vendor existe
if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "❌ Erro: Pasta vendor não encontrada!\n";
    echo "   Execute: composer install\n";
    exit(1);
}

// 2. Verificar se .env existe
if (!file_exists(__DIR__.'/.env')) {
    echo "⚠️  Arquivo .env não encontrado. Criando...\n";
    copy(__DIR__.'/.env.example', __DIR__.'/.env');
    echo "✅ Arquivo .env criado!\n\n";
}

// 3. Gerar APP_KEY se não existir
$envContent = file_get_contents(__DIR__.'/.env');
if (strpos($envContent, 'APP_KEY=base64:') === false || preg_match('/APP_KEY=$/', $envContent)) {
    echo "🔑 Gerando APP_KEY...\n";
    $key = 'base64:'.base64_encode(random_bytes(32));
    $envContent = preg_replace('/APP_KEY=.*/', 'APP_KEY='.$key, $envContent);
    file_put_contents(__DIR__.'/.env', $envContent);
    echo "✅ APP_KEY gerada: $key\n\n";
}

// 4. Criar pastas necessárias
echo "📁 Criando pastas de cache...\n";
$folders = [
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];

foreach ($folders as $folder) {
    if (!is_dir(__DIR__.'/'.$folder)) {
        mkdir(__DIR__.'/'.$folder, 0775, true);
        echo "   ✅ Criado: $folder\n";
    }
}

// 5. Configurar permissões
echo "\n🔒 Configurando permissões...\n";
chmod(__DIR__.'/storage', 0775);
chmod(__DIR__.'/bootstrap/cache', 0775);
echo "✅ Permissões configuradas!\n\n";

// 6. Verificar configuração do banco
echo "🗄️  Verificando configuração do banco de dados...\n";
$envLines = explode("\n", $envContent);
$dbConfigured = false;
foreach ($envLines as $line) {
    if (strpos($line, 'DB_DATABASE=') === 0 && strpos($line, 'DB_DATABASE=financeiro_pro_whats') === false) {
        $dbConfigured = true;
        break;
    }
}

if (!$dbConfigured) {
    echo "⚠️  ATENÇÃO: Configure o banco de dados no arquivo .env\n";
    echo "   Edite: nano .env\n";
    echo "   Configure: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD\n\n";
} else {
    echo "✅ Banco de dados configurado!\n\n";
}

// 7. Instruções finais
echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  PRÓXIMOS PASSOS:\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

if (!$dbConfigured) {
    echo "1. Configure o banco de dados:\n";
    echo "   nano .env\n\n";
}

echo "2. Importe o schema do banco de dados:\n";
echo "   mysql -u seu_usuario -p seu_banco < database/schema-base.sql\n";
echo "   OU use o phpMyAdmin no cPanel\n\n";

echo "3. Acesse o sistema:\n";
echo "   http://seu-dominio.com\n\n";

echo "4. Login padrão:\n";
echo "   Email: admin@financeiroprowhats.com\n";
echo "   Senha: admin123\n";
echo "   ⚠️  ALTERE A SENHA APÓS O PRIMEIRO LOGIN!\n\n";

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "✅ Setup concluído!\n";
echo "═══════════════════════════════════════════════════════════════════════════\n";
