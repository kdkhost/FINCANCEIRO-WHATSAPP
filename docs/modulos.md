# Módulos do Projeto

## Módulos principais

### Autenticação e acesso

- login em 2 colunas
- cadastro em 2 colunas
- reset de senha em 2 colunas
- login social
- 2FA
- WebAuthn
- whitelist de IP

### Núcleo multi-tenant

- cadastro e ciclo de vida de tenants
- trial configurável
- bloqueio por vencimento
- feature flags por plano
- isolamento de dados

### Financeiro

- contas a pagar
- contas a receber
- recorrência
- pro-rata
- parcelamentos
- dashboard financeiro

### Cobranças e gateways

- credenciais por tenant
- webhooks dinâmicos
- repasse de taxas
- cobranças avulsas e recorrentes

### Comunicação

- templates de e-mail
- templates de WhatsApp
- preview em tempo real
- filas com delay
- lembretes configuráveis

### Contratos

- upload
- assinatura por token
- trilha de auditoria
- anexos e versões

### CRM e Kanban

- leads
- negociações
- tarefas
- histórico de movimentações

### Utilitários

- cron interno
- limpar cache
- migrate controlado
- backup manual e agendado
- teste SMTP
- manutenção com liberação por IP

### SEO, Analytics e Afiliados

- meta tags dinâmicas
- relatórios
- tracking de afiliados
- comissionamento

## Organização sugerida de código

```text
app/
|-- Actions/
|-- Contracts/
|-- DTOs/
|-- Enums/
|-- Events/
|-- Exceptions/
|-- Http/
|-- Jobs/
|-- Listeners/
|-- Models/
|-- Notifications/
|-- Policies/
|-- Services/
|-- Support/
`-- Tenancy/
```

## Organização sugerida por domínio

- `Saas`
- `Tenant`
- `Billing`
- `Financial`
- `Messaging`
- `Contracts`
- `CRM`
- `AdminOps`
