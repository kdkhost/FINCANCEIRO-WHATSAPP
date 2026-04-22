CREATE TABLE tenants (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  primary_domain VARCHAR(255) NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'trial',
  trial_ends_at DATETIME NULL,
  subscription_ends_at DATETIME NULL,
  suspended_at DATETIME NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_tenants_slug (slug),
  INDEX idx_tenants_primary_domain (primary_domain)
);

CREATE TABLE plans (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  billing_cycle VARCHAR(30) NOT NULL DEFAULT 'monthly',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NULL,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(25) NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'owner',
  two_factor_enabled TINYINT(1) NOT NULL DEFAULT 0,
  two_factor_secret VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_users_email (email),
  CONSTRAINT fk_users_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE customers (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NULL,
  phone VARCHAR(25) NULL,
  document_type VARCHAR(20) NULL,
  document_number VARCHAR(30) NULL,
  notes LONGTEXT NULL,
  zipcode VARCHAR(10) NULL,
  address_line VARCHAR(180) NULL,
  address_number VARCHAR(20) NULL,
  address_extra VARCHAR(120) NULL,
  district VARCHAR(120) NULL,
  city VARCHAR(120) NULL,
  state VARCHAR(2) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_customers_tenant_name (tenant_id, name),
  CONSTRAINT fk_customers_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE invoices (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NOT NULL,
  customer_id BIGINT UNSIGNED NOT NULL,
  code VARCHAR(40) NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'draft',
  due_date DATE NOT NULL,
  total DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  paid_at DATETIME NULL,
  payment_method VARCHAR(50) NULL,
  payment_reference VARCHAR(255) NULL,
  reminder_sent_at DATETIME NULL,
  reminder_count INT NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uk_invoices_tenant_code (tenant_id, code),
  INDEX idx_invoices_status (status),
  INDEX idx_invoices_due_date (due_date),
  CONSTRAINT fk_invoices_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id),
  CONSTRAINT fk_invoices_customer FOREIGN KEY (customer_id) REFERENCES customers(id)
);

CREATE TABLE payment_gateway_accounts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NOT NULL,
  gateway VARCHAR(30) NOT NULL,
  label VARCHAR(100) NOT NULL,
  public_key VARCHAR(255) NULL,
  secret_key TEXT NULL,
  webhook_secret VARCHAR(255) NULL,
  settings JSON NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  keys_encrypted TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_gateway_accounts_tenant_gateway (tenant_id, gateway),
  CONSTRAINT fk_gateway_accounts_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE whatsapp_templates (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NOT NULL,
  type VARCHAR(50) NOT NULL,
  name VARCHAR(120) NOT NULL,
  message LONGTEXT NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_whatsapp_templates_tenant_type (tenant_id, type),
  CONSTRAINT fk_whatsapp_templates_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE email_templates (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NOT NULL,
  type VARCHAR(50) NOT NULL,
  name VARCHAR(120) NOT NULL,
  subject VARCHAR(180) NOT NULL,
  body LONGTEXT NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_email_templates_tenant_type (tenant_id, type),
  CONSTRAINT fk_email_templates_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE cron_executions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'pending',
  started_at DATETIME NULL,
  finished_at DATETIME NULL,
  output LONGTEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_cron_executions_name (name),
  INDEX idx_cron_executions_status (status)
);

CREATE TABLE webhook_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id BIGINT UNSIGNED NULL,
  type VARCHAR(50) NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'pending',
  request_data JSON NULL,
  response_data JSON NULL,
  response_code INT NULL,
  retry_count INT NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  INDEX idx_webhook_logs_tenant_type (tenant_id, type),
  INDEX idx_webhook_logs_status (status),
  CONSTRAINT fk_webhook_logs_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);
