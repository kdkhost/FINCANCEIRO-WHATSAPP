# Deploy em cPanel

## Objetivo

Preparar o sistema para hospedagem compartilhada com cPanel, mantendo a URL sem `/public`.

## Requisitos mínimos

- PHP 8.4
- MariaDB ou MySQL compatível
- acesso ao Terminal do cPanel ou SSH
- Composer disponível no servidor ou build local
- Node.js opcional para gerar assets antes do upload

## Estratégia recomendada

1. Gerar o build localmente.
2. Enviar o projeto para uma pasta fora de `public_html`.
3. Apontar `public_html` para os arquivos públicos ou usar `.htaccess` de redirecionamento.
4. Configurar `.env`, permissões e storage link.

## Estrutura sugerida

```text
/home/usuario/financeiro-pro-whats
/home/usuario/public_html
```

## Fluxo de implantação

1. Subir código para `/home/usuario/financeiro-pro-whats`
2. Manter a pasta pública espelhada em `public_html` ou usar apontamento do domínio
3. Ajustar `index.php` para os caminhos reais do projeto
4. Configurar tarefas cron no cPanel
5. Configurar filas por database ou redis, conforme disponibilidade

## Cron sugerido

```bash
* * * * * /usr/local/bin/php /home/usuario/financeiro-pro-whats/artisan schedule:run >> /dev/null 2>&1
```

## Ocultar `public`

Usar o arquivo de exemplo em [infra/apache/.htaccess.example](/g:/Tudo/MEU-SISTEMA/FINCANCEIRO%20WHATSAPP/infra/apache/.htaccess.example).

## Cuidados

- não executar comandos administrativos sem autenticação reforçada
- validar se o hosting permite filas longas e processos persistentes
- preferir build local para assets do React
