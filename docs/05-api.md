# API

## Cliente
GET /api/clientes
POST /api/clientes

## Carteira
GET /api/carteira/{cliente_id}

## Validação
GET /api/validacao?token=xxx

## Resposta padrão
{
  "status": "ok|erro",
  "data": {}
}