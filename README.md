transfer system é um sistema completo de gerenciamento de usuários e transações financeiras. Desenvolvido com Laravel e Livewire, ele oferece uma solução robusta para cadastro, autenticação e gerenciamento de perfis, além de funcionalidades essenciais como depósitos e transferências entre usuários.

Requisitos
Para rodar este projeto, você precisa ter o seguinte ambiente configurado:

PHP >= 8.1

Laravel >= 10

MySQL

Composer

Node.js e npm

Além disso, as seguintes extensões PHP são necessárias:
OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath.

Instalação
Siga os passos abaixo para instalar e executar o projeto localmente:

Clone o repositório:

git clone https://github.com/Victorburik/runy.git
cd runy

Instale as dependências:
composer install
npm install
npm run dev

Configure o ambiente:
cp .env.example .env
php artisan key:generate
Edite o arquivo .env com suas credenciais do banco de dados MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=runy
DB_USERNAME=root
DB_PASSWORD=

Execute as migrations:
php artisan migrate --seed

Inicie o servidor:
php artisan serve
O sistema estará disponível em http://localhost:8000.

Funcionalidades
Autenticação: Cadastro (usuário comum e lojista), login, recuperação e atualização de senha.

Gerenciamento de Perfil: Atualização de informações e exclusão de conta com confirmação.

Transações Financeiras:
Transferências: Realizadas entre usuários. Lojistas não podem enviar transferências e não é permitido transferir para si mesmo.
Depósitos: Exigem autorização via API externa e acionam notificações por e-mail e API.

Validação: CPF e CNPJ são validados no cadastro.
