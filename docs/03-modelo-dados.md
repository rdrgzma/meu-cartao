# Modelo de Dados

## Entidades principais

### Cliente
- id
- tenant_id
- nome
- cpf
- cns (opcional)
- status
- plano_id

### Plano
- id
- tenant_id
- nome
- valor

### Especialidade
- id
- tenant_id
- nome

### Parceiro
- id
- tenant_id
- nome
- status

### Mensalidade
- cliente_id
- valor
- vencimento
- status

### ClienteToken
- cliente_id
- token
- expires_at