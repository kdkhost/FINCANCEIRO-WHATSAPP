# 📱 Configuração Evolution GO (WhatsApp)

Este sistema utiliza **Evolution GO**, a versão em Golang da Evolution API para integração com WhatsApp.

---

## 🔍 O que é Evolution GO?

Evolution GO é uma reimplementação em Golang da Evolution API, oferecendo:

- ✅ **Melhor performance** - Golang é mais rápido que Node.js
- ✅ **Menor consumo de memória** - Mais eficiente
- ✅ **Compatibilidade total** - Mesma API da versão original
- ✅ **Mais estável** - Menos crashes e problemas
- ✅ **Fácil deploy** - Binário único, sem dependências

---

## 📦 Instalação do Evolution GO

### Opção 1: Docker (Recomendado)

```bash
docker run -d \
  --name evolution-go \
  -p 8080:8080 \
  -e AUTHENTICATION_API_KEY=sua_chave_secreta \
  -e DATABASE_ENABLED=true \
  -e DATABASE_CONNECTION_URI=mongodb://localhost:27017/evolution \
  atendai/evolution-api:latest
```

### Opção 2: Docker Compose

Crie um arquivo `docker-compose.yml`:

```yaml
version: '3.8'

services:
  evolution-go:
    image: atendai/evolution-api:latest
    container_name: evolution-go
    ports:
      - "8080:8080"
    environment:
      - AUTHENTICATION_API_KEY=sua_chave_secreta_aqui
      - DATABASE_ENABLED=true
      - DATABASE_CONNECTION_URI=mongodb://mongodb:27017/evolution
      - DATABASE_SAVE_DATA_INSTANCE=true
      - DATABASE_SAVE_DATA_NEW_MESSAGE=true
      - DATABASE_SAVE_MESSAGE_UPDATE=true
      - DATABASE_SAVE_DATA_CONTACTS=true
      - DATABASE_SAVE_DATA_CHATS=true
    volumes:
      - evolution_instances:/evolution/instances
    networks:
      - evolution_network
    depends_on:
      - mongodb

  mongodb:
    image: mongo:latest
    container_name: evolution-mongodb
    ports:
      - "27017:27017"
    environment:
      - MONGO_INITDB_ROOT_USERNAME=root
      - MONGO_INITDB_ROOT_PASSWORD=root
    volumes:
      - mongodb_data:/data/db
    networks:
      - evolution_network

volumes:
  evolution_instances:
  mongodb_data:

networks:
  evolution_network:
    driver: bridge
```

Execute:
```bash
docker-compose up -d
```

### Opção 3: Binário (Linux/Mac)

```bash
# Baixar o binário
wget https://github.com/EvolutionAPI/evolution-api/releases/latest/download/evolution-api-linux-amd64

# Dar permissão de execução
chmod +x evolution-api-linux-amd64

# Executar
./evolution-api-linux-amd64
```

---

## ⚙️ Configuração no Sistema

### 1. Editar o arquivo `.env`

```env
# Evolution GO Configuration
EVOLUTION_API_URL=http://localhost:8080
EVOLUTION_API_KEY=sua_chave_secreta_aqui
EVOLUTION_INSTANCE_NAME=financeiro_whatsapp
```

### 2. Criar uma Instância

Após iniciar o Evolution GO, crie uma instância via API:

```bash
curl -X POST http://localhost:8080/instance/create \
  -H "apikey: sua_chave_secreta_aqui" \
  -H "Content-Type: application/json" \
  -d '{
    "instanceName": "financeiro_whatsapp",
    "qrcode": true,
    "integration": "WHATSAPP-BAILEYS"
  }'
```

### 3. Conectar o WhatsApp

Acesse o QR Code:

```bash
curl http://localhost:8080/instance/connect/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui"
```

Ou acesse via navegador:
```
http://localhost:8080/instance/qrcode/financeiro_whatsapp
```

Escaneie o QR Code com seu WhatsApp.

---

## 🧪 Testar a Integração

### Via cURL

```bash
curl -X POST http://localhost:8080/message/sendText/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui" \
  -H "Content-Type: application/json" \
  -d '{
    "number": "5511999999999",
    "text": "Teste de mensagem do Financeiro Pro Whats!"
  }'
```

### Via Tinker (Laravel)

```bash
php artisan tinker

>>> use Illuminate\Support\Facades\Http;
>>> $response = Http::withHeaders(['apikey' => env('EVOLUTION_API_KEY')])
...     ->post(env('EVOLUTION_API_URL') . '/message/sendText/' . env('EVOLUTION_INSTANCE_NAME'), [
...         'number' => '5511999999999',
...         'text' => 'Teste!'
...     ]);
>>> $response->json();
```

---

## 📋 Endpoints Principais

### Gerenciar Instância

```bash
# Criar instância
POST /instance/create

# Conectar (obter QR Code)
GET /instance/connect/{instanceName}

# Status da instância
GET /instance/connectionState/{instanceName}

# Desconectar
DELETE /instance/logout/{instanceName}

# Deletar instância
DELETE /instance/delete/{instanceName}
```

### Enviar Mensagens

```bash
# Texto simples
POST /message/sendText/{instanceName}
{
  "number": "5511999999999",
  "text": "Sua mensagem aqui"
}

# Texto com mídia
POST /message/sendMedia/{instanceName}
{
  "number": "5511999999999",
  "mediatype": "image",
  "media": "https://url-da-imagem.jpg",
  "caption": "Legenda da imagem"
}

# Botões
POST /message/sendButtons/{instanceName}
{
  "number": "5511999999999",
  "title": "Título",
  "description": "Descrição",
  "buttons": [
    {"buttonId": "1", "buttonText": {"displayText": "Opção 1"}},
    {"buttonId": "2", "buttonText": {"displayText": "Opção 2"}}
  ]
}
```

---

## 🔒 Segurança

### Proteger a API

1. **Use HTTPS em produção**
```bash
# Com Nginx como proxy reverso
server {
    listen 443 ssl;
    server_name evolution.seu-dominio.com;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

2. **Use chave API forte**
```env
EVOLUTION_API_KEY=$(openssl rand -base64 32)
```

3. **Restrinja acesso por IP** (se possível)

---

## 🔄 Webhooks

Configure webhooks para receber eventos do WhatsApp:

```bash
curl -X POST http://localhost:8080/webhook/set/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui" \
  -H "Content-Type: application/json" \
  -d '{
    "url": "https://seu-dominio.com/api/v1/webhooks/whatsapp",
    "webhook_by_events": true,
    "events": [
      "QRCODE_UPDATED",
      "MESSAGES_UPSERT",
      "MESSAGES_UPDATE",
      "CONNECTION_UPDATE"
    ]
  }'
```

---

## 📊 Monitoramento

### Verificar Status

```bash
# Health check
curl http://localhost:8080/

# Status da instância
curl http://localhost:8080/instance/connectionState/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui"
```

### Logs

```bash
# Docker
docker logs -f evolution-go

# Binário
tail -f evolution.log
```

---

## 🆘 Troubleshooting

### Instância não conecta

1. Verifique se o Evolution GO está rodando:
```bash
curl http://localhost:8080/
```

2. Verifique os logs:
```bash
docker logs evolution-go
```

3. Recrie a instância:
```bash
# Deletar
curl -X DELETE http://localhost:8080/instance/delete/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui"

# Criar novamente
curl -X POST http://localhost:8080/instance/create \
  -H "apikey: sua_chave_secreta_aqui" \
  -H "Content-Type: application/json" \
  -d '{"instanceName": "financeiro_whatsapp", "qrcode": true}'
```

### Mensagens não são enviadas

1. Verifique se a instância está conectada:
```bash
curl http://localhost:8080/instance/connectionState/financeiro_whatsapp \
  -H "apikey: sua_chave_secreta_aqui"
```

2. Verifique o formato do número (deve incluir DDI + DDD):
```
Correto: 5511999999999
Errado: 11999999999
```

3. Verifique os logs do Laravel:
```bash
tail -f storage/logs/laravel.log
```

---

## 📚 Documentação Oficial

- **GitHub**: https://github.com/EvolutionAPI/evolution-api
- **Documentação**: https://doc.evolution-api.com/
- **Swagger**: http://localhost:8080/docs (após iniciar)

---

## 🔄 Diferenças da Evolution API Original

Evolution GO mantém **100% de compatibilidade** com a Evolution API original (Node.js), mas oferece:

| Recurso | Evolution API (Node.js) | Evolution GO |
|---------|------------------------|--------------|
| Performance | Boa | Excelente |
| Memória | ~200-500MB | ~50-100MB |
| CPU | Médio | Baixo |
| Startup | ~5-10s | ~1-2s |
| Estabilidade | Boa | Excelente |
| Deploy | npm/yarn | Binário único |

---

## ✅ Checklist de Configuração

- [ ] Evolution GO instalado e rodando
- [ ] MongoDB configurado (se usar persistência)
- [ ] Instância criada
- [ ] QR Code escaneado
- [ ] WhatsApp conectado
- [ ] Variáveis no `.env` configuradas
- [ ] Teste de envio realizado
- [ ] Webhooks configurados (opcional)
- [ ] HTTPS configurado (produção)
- [ ] Monitoramento ativo

---

**Pronto! Seu WhatsApp está integrado ao sistema!** 🎉
