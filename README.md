# Sistema de Gestão de Produtos

Sistema web para gerenciamento de produtos desenvolvido com Laravel 12. Cada usuário pode criar, visualizar, editar e excluir seus próprios produtos. As categorias são compartilhadas entre todos os usuários.

## 🚀 Tecnologias

- **Laravel 12** - Framework PHP
- **Laravel Breeze** - Autenticação (Blade stack)
- **PostgreSQL 18** - Banco de dados
- **Laravel Sail** - Ambiente Docker para desenvolvimento
- **Mailpit** - Servidor de email local para testes
- **Blade** - Template engine
- **Tailwind CSS** - Framework CSS
- **Vite** - Build tool para assets frontend

## 📋 Requisitos

- Docker Desktop instalado
- Git
- Composer (apenas para primeira instalação)

## 🔧 Instalação e Configuração

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd GestaoProdutos
```

### 2. Configure o ambiente

```bash
# Copie o arquivo de ambiente
cp .env.example .env

# Ou se o .env já existe, certifique-se que tem as configurações corretas:
# DB_CONNECTION=pgsql
# DB_HOST=pgsql
# DB_PORT=5432
# DB_DATABASE=gestao_produtos_app
# DB_USERNAME=sail
# DB_PASSWORD=password
```

### 3. Instale as dependências (primeira vez)

```bash
# Se você ainda não instalou o Sail
composer install
```

### 4. Inicie os containers Docker

```bash

# Configura o alias do sail
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc && source ~/.bashrc

# Inicia os containers em modo background
./vendor/bin/sail up -d

# Ou use o alias (após configurar)
sail up -d
```

### 5. Configure a aplicação

```bash
# Gere a chave da aplicação
./vendor/bin/sail artisan key:generate

# Execute as migrations e seeders
./vendor/bin/sail artisan migrate --seed

# Instale dependências do PHP
./vendor/bin/sail composer install

# Instale dependências do Node.js
./vendor/bin/sail npm install

# Compile os assets
  ./vendor/bin/sail npm run dev
```

## 👤 Usuários de Teste

Após executar o seed, os seguintes usuários estarão disponíveis:

- **Usuário 1:**
  - Email: `usuario1@example.com`
  - Senha: `12345678`

- **Usuário 2:**
  - Email: `usuario2@example.com`
  - Senha: `12345678`

## 🎯 Acessando a Aplicação

- **URL da aplicação:** http://localhost:8080
- **Mailpit (visualizar emails):** http://localhost:8025
- **Vite Dev Server:** http://localhost:5173
- **PostgreSQL:** localhost:5432
  - Database: `gestao_produtos_app`
  - Usuário: `sail`
  - Senha: `password`

## 🛠️ Comandos Úteis

```bash
# Iniciar containers
./vendor/bin/sail up -d

# Parar containers
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs

# Executar migrations
./vendor/bin/sail artisan migrate

# Executar seeders
./vendor/bin/sail artisan db:seed

# Executar comando personalizado (atualizar status dos produtos)
./vendor/bin/sail artisan atualizar-produtos

# Acessar o container
./vendor/bin/sail shell

# Executar testes
./vendor/bin/sail test

# Limpar cache
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan view:clear
```

## 📦 Estrutura do Projeto

```
gestao-produtos-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controllers da aplicação
│   │   └── Requests/         # FormRequests para validação
│   └── Models/               # Models Eloquent
├── database/
│   ├── migrations/           # Migrations do banco de dados
│   └── seeders/              # Seeders para dados iniciais
├── resources/
│   ├── views/                # Views Blade
│   └── css/                  # Arquivos CSS
├── routes/
│   ├── web.php               # Rotas web
│   └── api.php               # Rotas da API
└── docker-compose.yml        # Configuração Docker
```

## 🔐 Funcionalidades

### Autenticação
- Login de usuários
- Cadastro de novos usuários
- Recuperação de senha via email (usando Mailpit em desenvolvimento)
- Proteção de rotas com middleware `auth`
- Verificação de email

### Produtos
- CRUD completo de produtos
- Cada usuário visualiza apenas seus produtos
- Campos: nome, valor, quantidade, categoria, status (ativo/inativo)
- Validações via FormRequest

### Categorias
- CRUD completo de categorias
- Categorias compartilhadas entre todos os usuários
- Proteção contra exclusão de categorias com produtos vinculados
- Contador de produtos por categoria
- Validações via FormRequest

### API REST
- `GET /api/produtos` - Lista todos os produtos ativos
- `GET /api/usuarios/{usuario}/produtos` - Lista produtos de um usuário
- `PATCH /api/produtos/{produto}/remover` - Remove quantidade do estoque

#### Exemplos de Uso da API

**1. Listar todos os produtos ativos:**
```bash
curl http://localhost/api/produtos
```

**2. Listar produtos de um usuário específico:**
```bash
curl http://localhost/api/usuarios/1/produtos
```

**3. Remover quantidade do estoque:**
```bash
curl -X PATCH http://localhost/api/produtos/1/remover \
  -H "Content-Type: application/json" \
  -d '{"quantidade": 2}'
```

### Comando Artisan
- `./vendor/bin/sail artisan atualizar-produtos` - Atualiza status dos produtos baseado na quantidade

## 🧪 Testes

```bash
# Executar todos os testes
./vendor/bin/sail test

# Executar testes específicos
./vendor/bin/sail test --filter NomeDoTeste
```

## 📝 Configuração do Alias (Opcional)

Para facilitar o uso do Sail, adicione um alias ao seu shell:

```bash
# Para Bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc

# Para Zsh
echo "alias sail='./vendor/bin/sail'" >> ~/.zshrc
source ~/.zshrc
```

Após isso, você pode usar apenas `sail` ao invés de `./vendor/bin/sail`:

```bash
sail up -d
sail artisan migrate
sail npm run dev
```� Testando Envio de Emails

O projeto usa **Mailpit** para capturar emails em desenvolvimento. Nenhum email é enviado de verdade!

### Como testar recuperação de senha:

1. Acesse http://localhost/forgot-password
2. Digite o email de um usuário cadastrado
3. Clique em enviar
4. Abra o Mailpit em http://localhost:8025
5. O email aparecerá lá com o link de redefinição de senha

### Configuração de Email

As configurações já estão corretas no `.env.example`:
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL� Recursos Adicionais

### Docker Services

O projeto utiliza 3 containers Docker:

- **laravel.test**: Aplicação Laravel (PHP 8.5)
- **pgsql**: Banco de dados PostgreSQL 18
- **mailpit**: Servidor de email para desenvolvimento

### Pacotes Principais

- **Laravel Breeze**: Sistema de autenticação completo
- **Laravel Pint**: Code style (PSR-12)
- **PHPUnit**: Testes automatizados
- **Laravel Pail**: Visualização de logs em tempo real
- **Faker**: Geração de dados fake para testes

### Comandos Artisan Personalizados

```bash
# Atualizar status dos produtos (ativo/inativo baseado na quantidade)
sail artisan atualizar-produtos
```

### Reset do banco de dados
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

### Ver logs de erro
```bash
# Logs da aplicação
./vendor/bin/sail logs laravel.test -f

# Logs do Mailpit
./vendor/bin/sail logs mailpit -f

# Logs do PostgreSQL
./vendor/bin/sail logs pgsql -f
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```
