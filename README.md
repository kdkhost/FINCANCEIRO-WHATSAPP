# Financeiro Pro Whats

Base documental e estrutural inicial para o SaaS multi-tenant "Financeiro Pro Whats", projetado para Laravel 12 + PHP 8.4, MariaDB, React SPA, AdminLTE 4 e integração com WhatsApp via Evolution API.

## Status atual

O diretório original estava vazio e o ambiente desta sessão não possui `PHP` nem `Composer`. Por isso, esta entrega organiza a fundação técnica do projeto, a arquitetura, a modelagem base, o plano de módulos e os artefatos de deploy para cPanel, todos em UTF-8 sem BOM.

## Escopo desta entrega

- Padronização do repositório para texto sem BOM
- Estrutura documental do SaaS
- Modelagem inicial de banco de dados
- Diretrizes multi-tenant e integração com gateways
- Guia de deploy em hospedagem compartilhada cPanel
- Exemplo de `.htaccess` para ocultar `public`
- Roadmap técnico de implementação por fases
- `CHANGELOG.md` inicial

## Stack-alvo

- Backend: Laravel 12, PHP 8.4, MariaDB/MySQL, Redis opcional
- Frontend: React SPA, Vite, AdminLTE 4, jQuery, Ajax, SweetAlert2, Toastr, FullCalendar 4, Summernote
- Comunicação: Evolution API / Evolution GO
- Pagamentos: Mercado Pago, Efí Pay, Stripe
- Infra alvo: hospedagem compartilhada cPanel com CloudLinux opcional

## Estrutura criada

```text
.
|-- .editorconfig
|-- .gitattributes
|-- .gitignore
|-- CHANGELOG.md
|-- README.md
|-- database/
|   `-- schema-base.sql
|-- docs/
|   |-- arquitetura.md
|   |-- deploy-cpanel.md
|   |-- modelagem-dados.md
|   |-- modulos.md
|   `-- roadmap-implementacao.md
`-- infra/
    `-- apache/
        `-- .htaccess.example
```

## Próximos passos recomendados

1. Instalar `PHP 8.4+`, `Composer` e extensões necessárias.
2. Criar a base Laravel 12 no mesmo diretório.
3. Integrar React SPA com Vite.
4. Aplicar a arquitetura modular descrita em `docs/modulos.md`.
5. Implementar o multi-tenant com isolamento por `tenant_id` e camadas separadas de SaaS e tenant.

## Comandos sugeridos quando o ambiente estiver pronto

```bash
composer create-project laravel/laravel .
composer require filament/filament laravel/sanctum spatie/laravel-permission
npm install
```

## Deploy e cPanel

As diretrizes estão em [docs/deploy-cpanel.md](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/docs/deploy-cpanel.md).

## Observações

- Não foi possível gerar um sistema Laravel executável nesta sessão por ausência de `PHP` e `Composer`.
- O material entregue serve como base concreta para continuidade da implementação sem retrabalho estrutural.
