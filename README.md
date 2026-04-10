# Cartão Mais Saúde (CMS)

Sistema completo para gestão de cartões de benefícios, rede credenciada e controle financeiro. Desenvolvido com foco em alta performance, multi-tenancy e uma interface premium utilizando Livewire 4 e Flux UI.

## 🚀 Tecnologias e Arquitetura

- **Framework**: Laravel 13 (PHP 8.4+)
- **Frontend**: Livewire 4, Alpine.js, TailwindCSS 4
- **UI Components**: Flux UI (Premium)
- **Banco de Dados**: SQLite (Padrão) / PostgreSQL / MySQL
- **Arquitetura**: Service Layer Pattern, Multi-tenancy (Isolated Scope)

---

## 🛠 Instalação Local

### Requisitos
- PHP 8.4+
- Composer
- Node.js & NPM

### Passo a Passo
1. **Clone o repositório**:
   ```bash
   git clone <repo-url>
   cd meu-cartao
   ```

2. **Instale as dependências**:
   ```bash
   composer install
   npm install
   ```

3. **Configure o Ambiente**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Banco de Dados (SQLite)**:
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Compilação e Execução**:
   ```bash
   npm run dev
   php artisan serve
   ```

---

## 🐳 Docker Deployment (Laravel Sail)

O projeto já está configurado para o Laravel Sail.

1. **Subir os containers**:
   ```bash
   ./vendor/bin/sail up -d
   ```

2. **Rodar Migrações e Seeds**:
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

3. **Acessar**: `http://localhost`

---

## ☁️ Deploy em VPS (Ubuntu / NGINX)

Para deploy manual em VPS:

1. **Instale a stack**:
   ```bash
   sudo apt install nginx php8.4-fpm php8.4-sqlite3 php8.4-curl php8.4-xml php8.4-mbstring unzip
   ```

2. **Clone e Setup**:
   Siga os passos de **Instalação Local**, mas use:
   ```bash
   php artisan migrate --force
   npm run build
   ```

3. **Permissões**:
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache database
   ```

4. **Configuração NGINX**:
   Crie um arquivo em `/etc/nginx/sites-available/meu-cartao` apontando para a pasta `public/`.

---

## 🔑 Credenciais de Teste

Utilize as credenciais abaixo após rodar `php artisan db:seed`:

**Senha Padrão**: `password`

| Perfil | E-mail | Função |
| :--- | :--- | :--- |
| **Super Admin** | `sistema@cartaomaisaude.com.br` | Gestão Global do Sistema |
| **Admin Unidade**| `admin@matriz.com.br` | Gestão da Unidade Matriz |
| **Parceiro** | `clinica@parceiro.com.br` | Painel de Validação e Atendimento |
| **Cliente** | `cliente@teste.com.br` | Carteira Virtual e Mensalidades |

---

## 📦 Módulos Implementados (Roadmap)

- **Sprint 1**: Base (Planos, Especialidades, Clientes).
- **Sprint 2**: Financeiro (Mensalidades, Baixa Automática, Inadimplência).
- **Sprint 3**: Parceiros & Painel de Validação de Rede.
- **Sprint 4**: Carteira Virtual (QR Code Dinâmico, Tokens de Acesso).
- **Sprint 5**: Notificações WhatsApp (Templates, Histórico/Logs).
- **Sprint 6**: Relatórios & Dashboards Estratégicos.

## 📄 Licença
Distribuído sob a licença MIT.
