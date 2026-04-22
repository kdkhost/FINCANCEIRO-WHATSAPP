# Arquitetura do Sistema

## Objetivo

Construir um SaaS multi-tenant para gestão financeira, cobranças, automações e disparos via WhatsApp, com separação clara entre:

- camada do dono do SaaS
- camada do tenant
- serviços compartilhados
- integrações externas

## Macroestrutura

### 1. Camada SaaS

Responsável por:

- gestão de tenants
- planos, pacotes e testes gratuitos
- billing do próprio SaaS
- afiliados
- monitoração de jobs, cron e saúde do sistema
- configuração global de manutenção, SEO institucional e templates padrão

### 2. Camada Tenant

Responsável por:

- financeiro do cliente
- clientes, vendas, contratos e produtos
- dashboards financeiros
- lembretes de cobrança
- gateways próprios do tenant
- filas de WhatsApp e e-mail
- CRM/Kanban
- agenda financeira

### 3. Serviços compartilhados

- autenticação
- autorização granular
- auditoria
- notificações
- upload e mídia
- templates
- PWA
- webhooks
- cache e filas

## Estratégia multi-tenant

Modelo recomendado:

- banco compartilhado com coluna `tenant_id` na maioria das tabelas operacionais
- tabelas globais sem `tenant_id` apenas para administração do SaaS
- escopo obrigatório por tenant em repositórios, policies, jobs e webhooks

## Núcleos técnicos

### Backend

- Laravel 12
- jobs para filas de disparo e webhooks
- policies e middlewares por papel, plano e tenant
- eventos internos para faturamento, lembretes e assinatura de contratos

### Frontend

- React SPA para experiência dinâmica
- componentes híbridos com AdminLTE 4
- Ajax como padrão operacional em CRUDs
- máscaras, validações inline, skeletons e notificações Toast

### Integrações

- Mercado Pago
- Efí Pay
- Stripe
- Evolution API
- ViaCEP
- OAuth social login
- SMTP e notificações push web

## Segurança

- 2FA via e-mail ou TOTP
- WebAuthn para biometria/facial compatível com navegador/dispositivo
- whitelist de IP por contexto administrativo
- rate limit
- auditoria por ação crítica
- assinatura e validação de webhooks

## Operação

- cron central com painel de status
- execução manual de tarefas críticas
- fila com retentativas e backoff
- backups agendados
- limpeza de cache via interface controlada
