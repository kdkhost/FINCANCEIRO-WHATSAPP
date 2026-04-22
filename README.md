# Financeiro Pro Whats

SaaS multi-tenant para gestao financeira, cobrancas, contratos, automacoes de WhatsApp e operacao administrativa em Laravel 12 + React com AdminLTE 4.

## Estado atual da base

Esta entrega ja nao e apenas documental. O repositório agora contem a estrutura real do projeto com:

- `composer.json` preparado para Laravel 12
- `package.json` com React, Vite, AdminLTE 4, DataTables e Summernote
- bootstrap inicial do Laravel
- rotas web, api e console
- middleware de identificacao de tenant e restricao por IP
- modelos base de tenancy, planos, clientes, faturas e gateways
- servicos iniciais para pro-rata, templates e gateways
- migrations iniciais
- frontend base com Vite, React e PWA
- documentacao tecnica complementar

## Stack prevista

- PHP 8.4
- Laravel 12
- MariaDB / MySQL
- React + Vite
- AdminLTE 4
- jQuery + Ajax
- SweetAlert2 + Toastify
- Summernote
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

## Fluxo de instalacao quando voce for hospedar

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

## O que ja esta modelado

- tenancy por `slug` e dominio principal
- base de usuarios, planos, clientes, faturas e gateways
- endpoint de health check
- endpoint base para listagem de clientes por tenant
- endpoint base para webhooks dinamicos por gateway
- agendamento interno de cron
- estrutura inicial para filas de WhatsApp e lembretes
- PWA com `manifest.webmanifest` e service worker inicial

## O que ainda depende da instalacao de dependencias e continuidade de implementacao

- autenticação completa com telas finais
- painel administrativo completo com AdminLTE 4 e CRUDs finais
- integracoes reais com Mercado Pago, Efi, Stripe e Evolution
- CRUDs completos via Ajax
- dashboards com graficos
- CRM/Kanban, contratos, afiliados, SEO e analytics

## Documentacao complementar

- [Arquitetura](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/arquitetura.md)
- [Modulos](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/modulos.md)
- [Deploy cPanel](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/deploy-cpanel.md)
- [Modelagem de dados](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/modelagem-dados.md)
