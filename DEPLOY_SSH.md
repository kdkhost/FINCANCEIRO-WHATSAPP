# 🚀 Guia de Deploy via SSH

Este guia mostra como fazer deploy do Financeiro Pro Whats em um servidor via SSH.

---

## 📋 Pré-requisitos no Servidor

Antes de começar, certifique-se que o servidor tem:

- ✅ PHP 8.4+
- ✅ MySQL 5.7+ ou 8.0+
- ✅ Composer
- ✅ Node.js 18+ e npm
- ✅ Git
- ✅ Acesso SSH

---

## 🔑 Passo 1: Conectar ao Servidor via SSH

```bash
ssh usuario@seu-servidor.com
# ou
ssh usuario@123.456.789.0
```

Se usar porta customizada:
```bash
ssh -p 2222 usuario@seu-servidor.com
```

---

## 📦 Passo 2: Clonar o Repositório

```bash
# Navegue até o diretório web
cd /home/usuario/public_html
# ou
cd /var/www/html

# Clone o repositório
git clone https://github.com/kdkhost/FINCANCEIRO-WHATSAPP.git
cd FINCANCEIRO-WHATSAPP

# Ou se já tiver clonado, apenas atualize
git pull origin master
```

---

## ⚙️ Passo 3: Instalar Dependências do Composer

### Opção A: Composer já instalado no servidor

```bash
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl
```

### Opção B: Enviar vendor/ do seu computador (NÃO RECOMENDADO)

Se o servidor não tiver Composer, você pode enviar a pasta `vendor/` do seu computador:

```bash
# No seu computador local (PowerShell/CMD)
# Comprimir a pasta vendor
tar -czf vendor.tar.gz vendor/

# Enviar para o servidor via SCP
scp vendor.tar.gz usuario@seu-servidor.com:/caminho/para/app/

# No servidor, descompactar
ssh usuario@seu-servidor.com
cd /caminho/para/app
tar -xzf vendor.tar.gz
rm vendor.tar.gz
```

⚠️ **ATENÇÃO:** Esta opção pode causar problemas de compatibilidade!

---

## 🎨 Passo 4: Instalar Dependências do Node.js

### Opção A: Node.js instalado no servidor

```bash
npm install
npm run build
```

### Opção B: Enviar node_modules/ e build/ (RECOMENDADO)

Se o servidor não tiver Node.js ou for muito lento:

```bash
# No seu computador local, compile os assets
npm run build

# Comprimir apenas o build (assets compilados)
tar -czf build.tar.gz public/build/

# Enviar para o servidor
scp build.tar.gz usuario@seu-servidor.com:/caminho/para/app/

# No servidor, descompactar
ssh usuario@seu-servidor.com
cd /caminho/para/app
tar -xzf build.tar.gz
rm build.tar.gz
```

---

## 🔧 Passo 5: Configurar o Ambiente

```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Editar o .env
nano .env
# ou
vi .env
```

Configure as variáveis essenciais:

```env
APP_NAME="Financeiro Pro Whats"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

# Gateways de pagamento
STRIPE_PUBLIC_KEY=pk_live_...
STRIPE_SECRET_KEY=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...

MERCADOPAGO_ACCESS_TOKEN=...
MERCADOPAGO_PUBLIC_KEY=...

EFI_CLIENT_ID=...
EFI_CLIENT_SECRET=...
EFI_WEBHOOK_SECRET=...

# WhatsApp
EVOLUTION_API_URL=https://sua-evolution-api.com
EVOLUTION_API_KEY=...
EVOLUTION_INSTANCE_NAME=...

# Admin
ADMIN_ALLOWED_IPS=seu_ip,outro_ip
```

Salvar e sair:
- **nano**: `Ctrl+X`, depois `Y`, depois `Enter`
- **vi**: `ESC`, depois `:wq`, depois `Enter`

---

## 🔑 Passo 6: Gerar Chave da Aplicação

```bash
php artisan key:generate
```

---

## 🗄️ Passo 7: Configurar o Banco de Dados

### Criar o banco de dados

```bash
# Conectar ao MySQL
mysql -u root -p

# Criar banco
CREATE DATABASE financeiro_pro_whats CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Criar usuário (opcional)
CREATE USER 'financeiro_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON financeiro_pro_whats.* TO 'financeiro_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Executar migrations

```bash
php artisan migrate --force
```

### Executar seeders

```bash
php artisan db:seed --force
```

---

## 🔒 Passo 8: Configurar Permissões

```bash
# Dar permissão de escrita para storage e cache
chmod -R 775 storage bootstrap/cache

# Se necessário, ajustar o proprietário
chown -R www-data:www-data storage bootstrap/cache
# ou
chown -R usuario:usuario storage bootstrap/cache
```

---

## ⚡ Passo 9: Otimizar para Produção

```bash
# Cachear configurações
php artisan config:cache

# Cachear rotas
php artisan route:cache

# Cachear views
php artisan view:cache

# Otimizar autoloader
composer dump-autoload --optimize
```

---

## 🔄 Passo 10: Configurar Cron Jobs

```bash
# Editar crontab
crontab -e

# Adicionar esta linha
* * * * * cd /caminho/completo/para/app && php artisan schedule:run >> /dev/null 2>&1
```

Exemplo completo:
```bash
* * * * * cd /home/usuario/public_html/FINCANCEIRO-WHATSAPP && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Passo 11: Configurar Queue Worker

### Opção A: Usando Supervisor (Recomendado)

```bash
# Instalar supervisor
sudo apt-get install supervisor

# Criar arquivo de configuração
sudo nano /etc/supervisor/conf.d/financeiro-queue.conf
```

Adicionar:
```ini
[program:financeiro-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /caminho/completo/para/app/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/caminho/completo/para/app/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Recarregar supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start financeiro-queue:*
```

### Opção B: Usando nohup (Simples)

```bash
nohup php artisan queue:work database --sleep=3 --tries=3 > /dev/null 2>&1 &
```

---

## 🌐 Passo 12: Configurar o Servidor Web

### Apache (.htaccess)

O Laravel já vem com `.htaccess` configurado em `public/.htaccess`.

Configure o VirtualHost:

```bash
sudo nano /etc/apache2/sites-available/financeiro.conf
```

```apache
<VirtualHost *:80>
    ServerName seu-dominio.com
    ServerAlias www.seu-dominio.com
    DocumentRoot /caminho/para/app/public

    <Directory /caminho/para/app/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/financeiro-error.log
    CustomLog ${APACHE_LOG_DIR}/financeiro-access.log combined
</VirtualHost>
```

```bash
# Ativar site
sudo a2ensite financeiro.conf
sudo systemctl reload apache2
```

### Nginx

```bash
sudo nano /etc/nginx/sites-available/financeiro
```

```nginx
server {
    listen 80;
    server_name seu-dominio.com www.seu-dominio.com;
    root /caminho/para/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Ativar site
sudo ln -s /etc/nginx/sites-available/financeiro /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔐 Passo 13: Configurar SSL (HTTPS)

### Usando Certbot (Let's Encrypt - Gratuito)

```bash
# Instalar certbot
sudo apt-get install certbot python3-certbot-apache
# ou para nginx
sudo apt-get install certbot python3-certbot-nginx

# Obter certificado
sudo certbot --apache -d seu-dominio.com -d www.seu-dominio.com
# ou para nginx
sudo certbot --nginx -d seu-dominio.com -d www.seu-dominio.com

# Renovação automática já está configurada
```

---

## 📤 Método Alternativo: Enviar Arquivos via SCP/SFTP

Se preferir enviar os arquivos do seu computador:

### Usando SCP (Command Line)

```bash
# Comprimir o projeto (excluindo node_modules e vendor)
tar --exclude='node_modules' --exclude='vendor' --exclude='.git' -czf projeto.tar.gz .

# Enviar para o servidor
scp projeto.tar.gz usuario@servidor.com:/caminho/destino/

# No servidor, descompactar
ssh usuario@servidor.com
cd /caminho/destino
tar -xzf projeto.tar.gz
rm projeto.tar.gz
```

### Usando FileZilla (GUI)

1. Abra o FileZilla
2. Configure a conexão SFTP:
   - Host: `sftp://seu-servidor.com`
   - Usuário: `seu_usuario`
   - Senha: `sua_senha`
   - Porta: `22` (ou sua porta SSH)
3. Conecte e arraste os arquivos

**Arquivos para enviar:**
- ✅ `app/`
- ✅ `bootstrap/`
- ✅ `config/`
- ✅ `database/`
- ✅ `public/` (incluindo `public/build/`)
- ✅ `resources/`
- ✅ `routes/`
- ✅ `storage/` (estrutura, não logs)
- ✅ `vendor/` (se compilado localmente)
- ✅ `.env.example`
- ✅ `artisan`
- ✅ `composer.json`
- ✅ `composer.lock`
- ✅ `package.json`

**NÃO enviar:**
- ❌ `node_modules/`
- ❌ `.git/`
- ❌ `.env` (criar no servidor)
- ❌ `storage/logs/*`
- ❌ `storage/framework/cache/*`

---

## ✅ Passo 14: Verificar a Instalação

```bash
# Verificar se o site está acessível
curl https://seu-dominio.com

# Verificar logs
tail -f storage/logs/laravel.log

# Verificar queue worker
ps aux | grep queue

# Verificar cron
crontab -l
```

---

## 🔄 Atualizações Futuras

Para atualizar o sistema:

```bash
# Conectar ao servidor
ssh usuario@servidor.com
cd /caminho/para/app

# Modo manutenção
php artisan down

# Atualizar código
git pull origin master

# Atualizar dependências
composer install --no-dev --optimize-autoloader
npm run build

# Executar migrations
php artisan migrate --force

# Limpar e cachear
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reiniciar queue worker
sudo supervisorctl restart financeiro-queue:*

# Sair do modo manutenção
php artisan up
```

---

## 🆘 Troubleshooting

### Erro de permissão

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Erro 500

```bash
# Ver logs
tail -f storage/logs/laravel.log

# Verificar permissões
ls -la storage/

# Limpar cache
php artisan cache:clear
php artisan config:clear
```

### Queue não processa

```bash
# Verificar se está rodando
ps aux | grep queue

# Reiniciar
sudo supervisorctl restart financeiro-queue:*
```

### Cron não executa

```bash
# Verificar crontab
crontab -l

# Testar manualmente
php artisan schedule:run

# Ver logs do cron
grep CRON /var/log/syslog
```

---

## 📞 Suporte

Se precisar de ajuda:

1. Verifique os logs: `storage/logs/laravel.log`
2. Consulte: `TROUBLESHOOTING.md`
3. Entre em contato: suporte@financeiroprowhats.com

---

## 🎯 Checklist Final

- [ ] Código clonado/enviado para o servidor
- [ ] Dependências instaladas (composer e npm)
- [ ] `.env` configurado
- [ ] Chave da aplicação gerada
- [ ] Banco de dados criado e migrado
- [ ] Seeders executados
- [ ] Permissões configuradas
- [ ] Cache otimizado
- [ ] Cron job configurado
- [ ] Queue worker rodando
- [ ] Servidor web configurado
- [ ] SSL instalado
- [ ] Site acessível e funcionando
- [ ] Login admin testado

---

**Parabéns! Seu sistema está no ar! 🎉**
