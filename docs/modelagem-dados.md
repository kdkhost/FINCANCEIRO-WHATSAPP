# Modelagem Inicial de Dados

## Tabelas globais

- `users`
- `tenants`
- `tenant_domains`
- `plans`
- `plan_features`
- `subscriptions`
- `subscription_items`
- `affiliates`
- `affiliate_conversions`
- `system_settings`
- `maintenance_windows`
- `cron_logs`
- `backup_logs`

## Tabelas por tenant

- `customers`
- `suppliers`
- `products`
- `services`
- `invoices`
- `invoice_items`
- `payments`
- `payment_gateway_accounts`
- `financial_accounts`
- `accounts_receivable`
- `accounts_payable`
- `contracts`
- `contract_signatures`
- `whatsapp_templates`
- `email_templates`
- `notification_logs`
- `kanban_boards`
- `kanban_columns`
- `kanban_cards`
- `calendar_events`
- `webhook_logs`
- `uploads`

## Regras de modelagem

- tabelas operacionais devem incluir `tenant_id`
- timestamps em UTC
- soft delete nos cadastros importantes
- índices compostos por `tenant_id` e campos de consulta frequente
- logs críticos com IP, user agent e ator responsável

## Observação

A modelagem detalhada base está em [database/schema-base.sql](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/database/schema-base.sql).
