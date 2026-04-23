#!/bin/bash

# Script de Deploy para Financeiro Pro Whats
# Este script facilita o envio dos arquivos para o servidor via SSH

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                                                                ║"
echo "║         Deploy Financeiro Pro Whats via SSH                   ║"
echo "║                                                                ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Configurações (edite conforme necessário)
read -p "Digite o usuário SSH: " SSH_USER
read -p "Digite o host/IP do servidor: " SSH_HOST
read -p "Digite a porta SSH (padrão 22): " SSH_PORT
SSH_PORT=${SSH_PORT:-22}
read -p "Digite o caminho no servidor (ex: /home/usuario/public_html): " REMOTE_PATH

echo ""
echo "📋 Configuração:"
echo "   Usuário: $SSH_USER"
echo "   Host: $SSH_HOST"
echo "   Porta: $SSH_PORT"
echo "   Caminho: $REMOTE_PATH"
echo ""
read -p "Confirma? (s/n): " CONFIRM

if [ "$CONFIRM" != "s" ]; then
    echo "❌ Deploy cancelado."
    exit 1
fi

echo ""
echo "🔨 Preparando arquivos..."

# Compilar assets
echo "📦 Compilando assets..."
npm run build

# Instalar dependências de produção
echo "📦 Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl

# Criar arquivo temporário com exclusões
echo "📝 Criando lista de exclusões..."
cat > .rsync-exclude << EOF
.git
.gitignore
.env
.env.example
node_modules
storage/logs/*
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
tests
.editorconfig
.phpunit.cache
phpunit.xml
README.md
*.md
setup.bat
setup.sh
deploy-to-server.sh
.rsync-exclude
EOF

echo ""
echo "🚀 Enviando arquivos para o servidor..."
echo "   Isso pode levar alguns minutos..."
echo ""

# Usar rsync para enviar arquivos (mais eficiente que scp)
rsync -avz --progress \
    --exclude-from='.rsync-exclude' \
    -e "ssh -p $SSH_PORT" \
    ./ "$SSH_USER@$SSH_HOST:$REMOTE_PATH/"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Arquivos enviados com sucesso!"
    echo ""
    echo "📋 Próximos passos no servidor:"
    echo ""
    echo "1. Conecte ao servidor:"
    echo "   ssh -p $SSH_PORT $SSH_USER@$SSH_HOST"
    echo ""
    echo "2. Navegue até o diretório:"
    echo "   cd $REMOTE_PATH"
    echo ""
    echo "3. Configure o .env:"
    echo "   cp .env.example .env"
    echo "   nano .env"
    echo ""
    echo "4. Gere a chave da aplicação:"
    echo "   php artisan key:generate"
    echo ""
    echo "5. Execute as migrations:"
    echo "   php artisan migrate --force"
    echo "   php artisan db:seed --force"
    echo ""
    echo "6. Configure permissões:"
    echo "   chmod -R 775 storage bootstrap/cache"
    echo ""
    echo "7. Otimize para produção:"
    echo "   php artisan config:cache"
    echo "   php artisan route:cache"
    echo "   php artisan view:cache"
    echo ""
    echo "📚 Consulte DEPLOY_SSH.md para mais detalhes!"
else
    echo ""
    echo "❌ Erro ao enviar arquivos!"
    echo "   Verifique suas credenciais SSH e tente novamente."
    exit 1
fi

# Limpar arquivo temporário
rm -f .rsync-exclude

echo ""
echo "🎉 Deploy concluído!"
