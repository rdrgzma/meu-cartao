# Arquitetura

## Padrão
- MVC + Services

## Camadas
- Controllers → entrada
- Services → regras de negócio
- Models → persistência

## Regras
- NÃO colocar regra em Controller
- NÃO colocar regra complexa em Model
- Services são obrigatórios

## Exemplo
Controller → chama → Service → usa Models