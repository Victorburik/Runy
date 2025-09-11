Plataforma de Transferências Simplificada
Esta é uma implementação do desafio técnico para a plataforma Runy transferências light. A aplicação permite o cadastro de usuários comuns e lojistas, depósitos e transferências de dinheiro entre usuários, seguindo as regras de negócio especificadas.

Tecnologias Utilizadas:
Backend: Laravel 11.x
Frontend: Livewire 3.x + AlpineJS 3.x
Banco de Dados: MySQL (ou SQLite para desenvolvimento)
Outros: GuzzleHttp para chamadas externas (pacote oficial do Laravel via Illuminate\Http)

Evitei packages não oficiais, focando em código Laravel puro. Usei migrations, models, controllers e Livewire components para o fluxo principal.

Requisitos para Rodar a Aplicação:
PHP 8.2+
Composer 2.x
Node.js 18+
MySQL 8+ ou SQLite

Instruções para Instalação e Execução

Clone o repositório:
git clone https://github.com/Victorburik/Runy.git
cd Runy

Instale as dependências do Composer:
composer install

Copie o arquivo de ambiente e configure:
cp .env.example .env
Edite .env com suas credenciais de banco de dados (ex: DB_DATABASE=runy).
Gere a chave da aplicação:
php artisan key:generate

Rode as migrations para criar as tabelas:
php artisan migrate

Instale as dependências do NPM e compile assets:
npm install
npm run dev

Inicie o servidor:
php artisan serve
Acesse em http://127.0.0.1:8000

Funcionalidades Implementadas

Cadastro de usuários (comuns e lojistas) com validação de unicidade de CPF/CNPJ e email.
Autenticação básica (login/logout) usando Laravel Auth.
Depósito simulado (via interface para adicionar saldo).
Transferência de dinheiro: valida saldo, tipo de usuário, consulta autorizador externo, transação atômica, e notificação ao receptor.
Telas simples com Livewire para cadastro, login, dashboard e transferência.

Notas
Para testes, crie usuários via /register.
O depósito é simulado em /deposit (após login).
Transferências em /transfer.
Implementei tratamento básico de erros.
Cobertura de testes: Adicionei testes de unidade básicos para o serviço de transferência (rode com php artisan test).
