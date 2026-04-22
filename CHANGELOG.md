# Changelog

Todas as alteracoes relevantes deste projeto devem ser registradas aqui.

## [0.3.0] - 2026-04-22

### Alterado

- Separacao da arquitetura visual entre backend AdminLTE 4 e frontend React + Tailwind 4
- Home publica convertida para shell React moderna e orientada a marketing
- Dashboard administrativo reformulado para estilo AdminLTE 4 com foco em demonstracao

### Adicionado

- Entrypoints Vite separados para admin e frontend
- Tailwind CSS 4 no frontend publico
- DataTables e Summernote inicializados no backend administrativo
- Layouts Blade independentes para frontend e admin
- Factories para planos, tenants, usuarios, clientes, gateways e faturas
- Seeders de demonstracao para popular automaticamente o banco

## [0.2.0] - 2026-04-22

### Adicionado

- Estrutura inicial real do projeto Laravel 12 + React
- `composer.json`, `package.json`, `vite.config.js` e `.env.example`
- Bootstrap base, rotas web/api/console e arquivos publicos principais
- Middleware de tenant e restricao administrativa por IP
- Modelos iniciais de tenants, usuarios, planos, clientes, faturas e gateways
- Servicos base para pro-rata, templates e resolucao de gateways
- Endpoints iniciais de health check, clientes por tenant e webhooks dinamicos
- Migrations iniciais do nucleo multi-tenant e financeiro
- Frontend base com CSS inicial, React e PWA

## [0.1.0] - 2026-04-22

### Adicionado

- Estrutura inicial do repositorio
- Padronizacao para UTF-8 sem BOM
- Documentacao de arquitetura do Financeiro Pro Whats
- Planejamento modular do SaaS multi-tenant
- Modelagem inicial de banco de dados
- Guia de deploy para cPanel
- Exemplo de `.htaccess` para ocultar a pasta `public`
