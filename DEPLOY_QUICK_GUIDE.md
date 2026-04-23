# 🚀 Guia Rápido de Deploy via SSH

## Método 1: Git Clone (Mais Simples) ⭐

```bash
# No servidor
ssh usuario@servidor.com
cd /var/www/html
git clone https://github.com/kdkhost/FINCANCEIRO-WHATSAPP.git
cd FINCANCEIRO-WHATSAPP

# Instalar dependências
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Configurar
cp .env.example .env
nano .env  # Editar configurações
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

# Permissões
chmod -R 775 storage bootstrap/cache

# Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Método 2: Script Automático

### Windows:
```bash
deploy-to-server.bat
```

### Linux/Mac:
```bash
chmod +x deploy-to-server.sh
./deploy-to-server.sh
```

---

## Método 3: SCP Manual

```bash
# Comprimir projeto
tar --exclude='node_modules' --exclude='vendor' --exclude='.git' -czf projeto.tar.gz .

# Enviar
scp projeto.tar.gz usuario@servidor.com:/caminho/

# No servidor
ssh usuario@servidor.com
cd /caminho
tar -xzf projeto.tar.gz
composer install --no-dev
npm install && npm run build
```

---

## Método 4: FileZilla (GUI)

1. Abra FileZilla
2. Conecte via SFTP: `sftp://servidor.com`
3. Arraste os arquivos (exceto node_modules, vendor, .git)
4. No servidor via SSH, execute:
   ```bash
   composer install --no-dev
   npm install && npm run build
   ```

---

## ⚙️ Configuração Essencial no Servidor

```bash
# 1. Editar .env
nano .env

# 2. Banco de dados
mysql -u root -p
CREATE DATABASE financeiro_pro_whats;
EXIT;

# 3. Migrations
php artisan migrate --force
php artisan db:seed --force

# 4. Cron (adicionar ao crontab)
* * * * * cd /caminho/app && php artisan schedule:run >> /dev/null 2>&1

# 5. Queue Worker (supervisor)
sudo nano /etc/supervisor/conf.d/financeiro-queue.conf
```

---

## 🔄 Atualizar Sistema

```bash
ssh usuario@servidor.com
cd /caminho/app
php artisan down
git pull origin master
composer install --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan up
```

---

## ✅ Verificar se Está Funcionando

```bash
# Testar site
curl https://seu-dominio.com

# Ver logs
tail -f storage/logs/laravel.log

# Testar banco
php artisan tinker
>>> DB::connection()->getPdo()

# Testar queue
ps aux | grep queue

# Testar cron
php artisan schedule:run
```

---

## 🆘 Problemas Comuns

### Erro 500
```bash
chmod -R 775 storage bootstrap/cache
php artisan cache:clear
tail -f storage/logs/laravel.log
```

### Composer lento
```bash
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-curl
```

### Node.js não disponível
```bash
# No seu PC: npm run build
# Envie apenas: public/build/
```

---

## 📞 Precisa de Ajuda?

Consulte: **DEPLOY_SSH.md** (guia completo)

---

**Tempo estimado: 15-30 minutos** ⏱️
