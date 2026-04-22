# Financeiro Pro Whats

SaaS multi-tenant para gestao financeira, cobrancas, contratos, automacoes de WhatsApp e operacao administrativa em Laravel 12 com backend AdminLTE 4 e frontend React + Tailwind 4.

## Estado atual da base

Esta entrega ja contem uma base real de codigo com separacao clara entre:

- backend administrativo em Blade + AdminLTE 4
- frontend publico em React + Tailwind 4
- API inicial para health check, tenant e webhooks
- models, migrations, services e jobs centrais
- factories e seeders de demonstracao

## Stack prevista

- PHP 8.4
- Laravel 12
- MariaDB / MySQL
- React + Vite + Tailwind 4
- AdminLTE 4
- jQuery + Ajax
- DataTables
- Summernote
- SweetAlert2 + Toastify
- FullCalendar
- Mercado Pago, Efi Pay e Stripe
- Evolution API para WhatsApp

## Estrutura principal

```text
app/
bootstrap/
config/
database/
docs/
public/
resources/
routes/
tests/
artisan
composer.json
package.json
vite.config.js
```

## O que ja foi preparado

- `composer.json` para Laravel 12
- `package.json` com AdminLTE 4, React, Tailwind 4, DataTables e Summernote
- rotas separadas para site publico e administrativo
- landing page publica montada para React em `resources/js/frontend/app.jsx`
- dashboard administrativo em AdminLTE 4 em `resources/views/admin/dashboard.blade.php`
- middleware de identificacao de tenant e restricao por IP
- models de tenants, usuarios, clientes, faturas, planos e gateways
- services base para pro-rata, templates e gateways
- jobs iniciais para lembretes e WhatsApp
- seeders com dados de demonstracao

## Fluxo de instalacao quando voce for hospedar

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
```

## Credenciais demo previstas

Depois de rodar `php artisan db:seed`, o sistema criara:

- usuario SaaS: `admin@financeiroprowhats.test`
- senha base de demonstracao: `password`

## O que ja esta modelado

- tenancy por `slug` e dominio principal
- base de usuarios, planos, clientes, faturas e gateways
- endpoint de health check
- endpoint base para listagem de clientes por tenant
- endpoint base para webhooks dinamicos por gateway
- agendamento interno de cron
- estrutura inicial para filas de WhatsApp e lembretes
- seeders de demonstracao com tenants, usuarios, clientes, gateways e faturas
- PWA com `manifest.webmanifest` e service worker inicial

## O que ainda depende de continuidade

- autenticacao completa com telas finais
- CRUDs Ajax completos no painel
- dashboards com graficos reais
- integracoes reais com Mercado Pago, Efi, Stripe e Evolution
- CRM, Kanban, contratos, afiliados, SEO e analytics
- mascaras dinamicas, ViaCEP e fluxos completos de formularios

## Documentacao complementar

- [Arquitetura](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/arquitetura.md)
- [Modulos](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/modulos.md)
- [Deploy cPanel](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/deploy-cpanel.md)
- [Modelagem de dados](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/modelagem-dados.md)
