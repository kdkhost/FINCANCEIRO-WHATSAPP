# Changelog

Todas as alterações relevantes deste projeto devem ser registradas aqui.

## [0.1.0] - 2026-04-22

### Adicionado

- Estrutura inicial do repositório
- Padronização para UTF-8 sem BOM
- Documentação de arquitetura do Financeiro Pro Whats
- Planejamento modular do SaaS multi-tenant
- Modelagem inicial de banco de dados
- Guia de deploy para cPanel
- Exemplo de `.htaccess` para ocultar a pasta `public`

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
