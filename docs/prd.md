# 📘 PRD – Product Requirements Document  
## Sistema Cartão Mais Saúde (CMS)

---

# 1. Visão Geral

## 1.1 Nome do Produto
Cartão Mais Saúde (CMS)

## 1.2 Descrição
Plataforma web para gestão de clientes assinantes de um cartão de benefícios em saúde, com controle financeiro, validação de elegibilidade em tempo real e gestão de planos com especialidades e carência.

## 1.3 Problema
- Falta de controle da inadimplência  
- Validação manual e lenta de clientes  
- Falta de padronização nos benefícios por plano  
- Dificuldade de escalar a operação  

## 1.4 Objetivo
- Automatizar gestão de clientes e cobranças  
- Permitir validação instantânea por parceiros  
- Estruturar planos com especialidades e regras claras  
- Reduzir inadimplência  

---

# 2. Metas (KPIs)

- Redução de inadimplência em 30%  
- Tempo de validação < 3 segundos  
- 80% das cobranças automatizadas  
- Retenção > 85%  

---

# 3. Personas

## 3.1 Administrador
- Gerencia clientes, planos, parceiros e financeiro  

## 3.2 Cliente
- Consulta carteira virtual  
- Acompanha status e pagamentos  

## 3.3 Parceiro
- Valida cliente rapidamente no atendimento  

---

# 4. Entidades Principais

- clientes  
- planos  
- especialidades  
- plano_especialidades  
- carencias  
- parceiros  
- parceiro_especialidades  
- mensalidades  
- pagamentos  

---

# 5. Módulos e Funcionalidades

---

# 5.1 Módulo: Especialidades

## Funcionalidades
- Criar especialidade  
- Editar especialidade  
- Ativar/Desativar  

## Critérios de Aceitação
- [ ] Nome obrigatório  
- [ ] Nome único  
- [ ] Permitir ativar/desativar  
- [ ] Especialidades inativas não podem ser vinculadas  

---

# 5.2 Módulo: Planos

## Funcionalidades
- Criar plano  
- Definir valor  
- Vincular especialidades  
- Configurar carência por especialidade  

---

## 5.2.1 Especialidades do Plano

### Regras
- Plano pode ter múltiplas especialidades  
- Sem duplicidade  

### Critérios de Aceitação
- [ ] Adicionar múltiplas especialidades  
- [ ] Remover especialidades  
- [ ] Persistência correta  
- [ ] Não permitir duplicidade  
- [ ] Listagem clara  

---

## 5.2.2 Carência por Especialidade

### Regras
- Definida em dias  
- Pode variar por especialidade  
- Base: data de adesão do cliente  

### Critérios de Aceitação
- [ ] Permitir configurar carência  
- [ ] Aceitar 0 dias  
- [ ] Calcular automaticamente  
- [ ] Bloquear uso antes da carência  
- [ ] Exibir status na validação  

---

# 5.3 Módulo: Clientes

## Funcionalidades
- Cadastro  
- Edição  
- Listagem  
- Alteração de status  

## Regras
- CPF único  
- Data de adesão obrigatória  

## Critérios de Aceitação
- [ ] CPF obrigatório e único  
- [ ] Nome e telefone obrigatórios  
- [ ] Armazenar data de adesão  
- [ ] Status automático baseado no financeiro  
- [ ] Busca por CPF, nome ou número  

---

# 5.4 Módulo: Financeiro

## Funcionalidades
- Gerar mensalidades  
- Registrar pagamento  
- Controle de atraso  

## Regras
- Cliente inadimplente após X dias  
- Pagamento reativa cliente  

## Critérios de Aceitação
- [ ] Geração automática de mensalidades  
- [ ] Baixa manual  
- [ ] Marcar atraso automaticamente  
- [ ] Atualizar status do cliente  
- [ ] Bloquear cliente inadimplente  

---

# 5.5 Módulo: Parceiros

## Funcionalidades
- Cadastro  
- Associação de especialidades  

## Campos
- Nome fantasia  
- CNPJ/CPF  
- Telefone  
- Endereço  
- Status  

## Critérios de Aceitação
- [ ] Cadastro completo  
- [ ] Vincular múltiplas especialidades  
- [ ] Não permitir especialidade inativa  
- [ ] Permitir edição  
- [ ] Status ativo/inativo funcional  

---

# 5.6 Módulo: Validação de Cliente

## Funcionalidades
- Consulta por CPF ou número  
- Retorno por especialidade  

## Regras
Cliente só pode usar se:
- Está ativo  
- Está adimplente  
- Plano cobre a especialidade  
- Carência cumprida  

## Retorno
- Nome  
- Status  
- Lista de especialidades com:
  - Coberto  
  - Em carência  
  - Liberado  

## Critérios de Aceitação
- [ ] Consulta por CPF/número  
- [ ] Resposta < 3 segundos  
- [ ] Validar cobertura  
- [ ] Validar carência  
- [ ] Bloquear corretamente  
- [ ] Mensagens claras:
  - Liberado  
  - Em carência  
  - Não coberto  
  - Inadimplente  

---

# 5.7 Módulo: Carteira Virtual

## Funcionalidades
- Exibir dados do cliente  
- QR Code  
- Status  

## Critérios de Aceitação
- [ ] Exibir número do cliente  
- [ ] QR Code funcional  
- [ ] Status em tempo real  
- [ ] Dados consistentes  

---

# 5.8 Módulo: Notificações

## Funcionalidades
- Lembretes de pagamento  
- Avisos de atraso  
- Confirmação de pagamento  

## Critérios de Aceitação
- [ ] Envio automático  
- [ ] Templates configuráveis  
- [ ] Registro de envio  
- [ ] Integração com WhatsApp  

---

# 5.9 Módulo: Relatórios

## Funcionalidades
- Receita mensal  
- Inadimplência  
- Uso por especialidade  

## Critérios de Aceitação
- [ ] Filtro por período  
- [ ] Agrupamento por especialidade  
- [ ] Consistência com financeiro  
- [ ] Exportação (CSV/PDF)  

---

# 6. Requisitos Não Funcionais

- Tempo de resposta < 2s  
- Mobile-first  
- LGPD compliance  
- Segurança de dados  
- Disponibilidade ≥ 99%  

---

# 7. Sprints

---

## Sprint 1 – Base
- CRUD clientes  
- CRUD especialidades  
- CRUD planos  

### Critérios
- [ ] Cadastro funcionando  
- [ ] Especialidades vinculadas ao plano  

---

## Sprint 2 – Financeiro + Carência
- Mensalidades  
- Carência  

### Critérios
- [ ] Carência calculada  
- [ ] Bloqueio funcionando  

---

## Sprint 3 – Parceiros + Validação
- Cadastro parceiros  
- API validação  

### Critérios
- [ ] Validação completa  
- [ ] Tempo < 3s  

---

## Sprint 4 – Carteira
- QR Code  
- Layout responsivo  

### Critérios
- [ ] QR Code válido  
- [ ] Mobile ok  

---

## Sprint 5 – Notificações
- Envio automático  

### Critérios
- [ ] Mensagens enviadas  
- [ ] Logs persistidos  

---

## Sprint 6 – Relatórios + Deploy
- Relatórios  
- Ajustes finais  

### Critérios
- [ ] Dados corretos  
- [ ] Sistema estável  

---

# 8. Definição de Pronto (DoD)

- Código implementado  
- Testado  
- Sem bugs críticos  
- Regras validadas  
- Performance adequada  

---

# 9. Riscos

- Falha na validação  
- Integração com WhatsApp  
- Erros na lógica de carência  
- Performance  

---

# 10. Evoluções Futuras

- App mobile  
- Pagamento automático  
- Geolocalização  
- White-label SaaS  

---

# 11. Conclusão

O CMS é um sistema escalável e estruturado, com regras robustas de elegibilidade (especialidades + carência), pronto para evoluir para um produto SaaS no mercado de benefícios em saúde.

---