# Financeiro Pro Whats

Sistema completo de gestão financeira, cobrança e automação para WhatsApp. Plataforma multi-tenant SaaS desenvolvida com Laravel 12.

## 🚀 Funcionalidades

### Gestão Financeira
- ✅ Gestão completa de clientes e cobranças
- ✅ Múltiplos gateways de pagamento (Stripe, MercadoPago, Efi)
- ✅ Cálculo automático de proração
- ✅ Dashboard com estatísticas em tempo real
- ✅ Relatórios e exportação de dados

### Automação
- ✅ Lembretes automáticos de cobrança via email e WhatsApp
- ✅ Integração com Evolution GO para WhatsApp
- ✅ Templates personalizáveis de mensagens
- ✅ Sistema de cron jobs automatizado
- ✅ Fila de processamento assíncrono

### Segurança
- ✅ Criptografia automática de credenciais (AES-256)
- ✅ Validação HMAC de webhooks
- ✅ Proteção CSRF e XSS
- ✅ IP whitelist para admin
- ✅ Rate limiting para API
- ✅ Logs de atividades de usuários

### Multi-tenant
- ✅ Isolamento completo de dados por tenant
- ✅ Domínios personalizados
- ✅ Configurações independentes
- ✅ Planos e limites por tenant

## 📋 Requisitos

- PHP 8.4+
- MySQL 5.7+ ou 8.0+
- Composer
- Node.js 18+ (para assets frontend)
- Extensões PHP: curl, pcntl, mbstring, xml, json

## 🔧 Instalação Rápida

### Windows:
```bash
setup.bat
```

### Linux/Mac:
```bash
chmod +x setup.sh
./setup.sh
```

## 🔑 Credenciais Padrão

Após executar os seeders:

- **Email:** admin@financeiroprowhats.com
- **Senha:** admin123

⚠️ **IMPORTANTE:** Altere a senha após o primeiro login!

## ⚙️ Configuração

### Banco de Dados

Edite o `.env`:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=financeiro_pro_whats
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### Gateways de Pagamento

```env
# Stripe
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...

# MercadoPago
MERCADOPAGO_ACCESS_TOKEN=...
MERCADOPAGO_PUBLIC_KEY=...

# Efi (Gerencianet)
EFI_CLIENT_ID=...
EFI_CLIENT_SECRET=...
EFI_WEBHOOK_SECRET=...
```

### WhatsApp

```env
EVOLUTION_API_URL=http://localhost:8080
EVOLUTION_API_KEY=sua_api_key
EVOLUTION_INSTANCE_NAME=sua_instancia
```

**Nota:** Este sistema usa **Evolution GO** (versão em Golang da Evolution API).

## 🔄 Cron Jobs

Adicione ao crontab:

```bash
* * * * * cd /caminho/para/app && php artisan schedule:run >> /dev/null 2>&1
```

## 📊 Queue Worker

```bash
php artisan queue:work database --tries=3 --timeout=90
```

## 🧪 Testes

```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter=ProrationCalculatorTest

# Com cobertura
php artisan test --coverage
```

## 📚 Documentação Completa

- **START_HERE.md** - Guia de início rápido
- **INSTALLATION.md** - Instalação detalhada
- **QUICK_REFERENCE.md** - Referência rápida
- **TROUBLESHOOTING.md** - Solução de problemas
- **FINAL_REPORT.md** - Relatório completo

## 🛠️ Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear

# Limpar logs antigos
php artisan logs:clean --days=30

# Executar cron manualmente
php artisan cron:billing-reminders
php artisan cron:message-dispatch
```

## 📦 Stack Tecnológica

### Backend
- Laravel 12
- PHP 8.4+
- MySQL 8.0

### Frontend
- React 18
- Vite 6
- TailwindCSS 4
- AdminLTE 4

### Integrações
- Stripe SDK
- MercadoPago SDK
- Efi API
- Evolution GO (WhatsApp)

## 🔐 Segurança

- Criptografia AES-256 de credenciais
- Validação HMAC de webhooks
- Proteção CSRF e XSS
- Rate limiting
- IP whitelist
- Logs de auditoria

## 📈 Performance

- Cache de configuração
- Otimização de queries
- Jobs assíncronos
- Assets minificados
- Índices otimizados

## 📞 Suporte

- Email: suporte@financeiroprowhats.com
- WhatsApp: +55 (11) 99999-9999
- Documentação: Arquivos .md na raiz

## 📄 Licença

Proprietário. Todos os direitos reservados.

---

**Desenvolvido com ❤️ usando Laravel 12**
