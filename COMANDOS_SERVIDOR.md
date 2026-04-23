# 🚀 Comandos para Executar no Servidor

Copie e cole estes comandos no seu servidor SSH.

---

## 🔧 Correção Rápida (Copie tudo de uma vez)

```bash
# Limpar e reinstalar Composer
composer clear-cache
rm -rf vendor
composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl
composer dump-autoload --optimize

# Configurar permissões
chmod -R 775 storage bootstrap/cache

# Criar .env se não existir
[ ! -f .env ] && cp .env.example .env

# Gerar chave
php artisan key:generate --force

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📦 Enviar Assets do seu PC para o Servidor

### No seu PC Windows (PowerShell):

```powershell
# 1. Compilar assets
npm run build

# 2. Comprimir (se tiver tar instalado)
tar -czf build.tar.gz public/build/

# 3. Enviar para servidor (substitua os valores)
scp build.tar.gz financeirowhats@patriota.kdkhost.com.br:/home/financeirowhats/public_html/
```

### No Servidor:

```bash
# Descompactar
cd /home/financeirowhats/public_html
tar -xzf build.tar.gz
rm build.tar.gz
```

---

## 🗄️ Configurar Banco de Dados

```bash
# 1. Editar .env
nano .env

# Configure estas linhas:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=seu_banco
# DB_USERNAME=seu_usuario
# DB_PASSWORD=sua_senha

# Salvar: Ctrl+X, depois Y, depois Enter

# 2. Executar migrations
php artisan migrate --force

# 3. Executar seeders
php artisan db:seed --force
```

---

## ⚡ Otimizar para Produção

```bash
# Cachear configurações
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Otimizar autoload
composer dump-autoload --optimize
```

---

## 🔍 Verificar se Está Funcionando

```bash
# Testar conexão com banco
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit

# Ver logs
tail -f storage/logs/laravel.log

# Testar rota
curl http://seu-dominio.com
```

---

## 🆘 Se Ainda Tiver Erros

### Erro: "Class not found"

```bash
composer dump-autoload --optimize
php artisan cache:clear
php artisan config:clear
```

### Erro: "Permission denied"

```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache
```

### Erro: "Database connection failed"

```bash
# Verificar se MySQL está rodando
mysql -u root -p

# Testar conexão
php artisan tinker
>>> DB::connection()->getPdo()
```

---

## 📋 Checklist Completo

Execute na ordem:

```bash
# 1. Limpar e reinstalar
composer clear-cache
rm -rf vendor
composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl

# 2. Permissões
chmod -R 775 storage bootstrap/cache

# 3. Configuração
cp .env.example .env
nano .env  # Editar configurações
php artisan key:generate --force

# 4. Banco de dados
php artisan migrate --force
php artisan db:seed --force

# 5. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Verificar
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit
```

---

## 🎯 Comando Único (Tudo de Uma Vez)

**⚠️ ATENÇÃO:** Só use se souber o que está fazendo!

```bash
composer clear-cache && \
rm -rf vendor && \
composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl && \
composer dump-autoload --optimize && \
chmod -R 775 storage bootstrap/cache && \
[ ! -f .env ] && cp .env.example .env && \
php artisan key:generate --force && \
php artisan cache:clear && \
php artisan config:clear && \
echo "✅ Correções aplicadas! Configure o .env e execute: php artisan migrate --force"
```

---

## 📞 Precisa de Ajuda?

1. Verifique os logs: `tail -f storage/logs/laravel.log`
2. Consulte: `TROUBLESHOOTING.md`
3. Verifique permissões: `ls -la storage/`

---

**Última atualização:** 22/04/2026
