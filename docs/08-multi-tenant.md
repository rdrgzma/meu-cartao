# Multi-Tenant

## Estratégia
- tenant_id em todas as tabelas

## Resolução
- Header: X-Tenant
- Subdomínio
- Usuário logado

## Segurança
- Global Scope obrigatório

## Regra
Nunca consultar sem tenant