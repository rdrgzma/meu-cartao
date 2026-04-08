# Regras de Negócio

## Cliente
- Deve ter CPF único por tenant
- CNS é opcional
- Status: ativo, inadimplente, cancelado

## Plano
- Possui especialidades
- Pode ter carência por especialidade

## Elegibilidade
Cliente pode usar serviço se:
- Status = ativo
- Plano cobre especialidade
- Não está em carência

## Financeiro
- Mensalidade vencida → atraso
- Cliente com atraso → inadimplente

## Token
- Expira em 30 dias
- Deve ser único