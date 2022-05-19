# Laravel Api

Aplicação desenvolvida em PHP com o framework Laravel para conversão de moedas. Esse projeto conta com duas vias para manipulação dos dados, através de uma API própria ou através do navegador do usuário.

Video explicativo: https://www.loom.com/share/e10c0c732df84960b9f1d4d871cacbc3

# Tecnologias

  - Laravel 9
  - PHP 8
  - MySQL
  - Nginx
  - Docker

# Preparação

Certifique-se de ter instalados em sua máquina o **[Docker](https://docs.docker.com/engine/install/)** e o **[Docker Compose](https://docs.docker.com/compose/install/)**.

# Configuração

  - Clone este repositório para sua máquina;
  - Acesse seu terminal e vá para o diretório do projeto;
  - No terminal execute **docker-compose build**;
  - Em seguida ainda no terminal execute **docker-compose up**;
  - Nos arquivos (root) do projeto, copie e renomeie **.env.example** para **.env**;
  - No terminal, acesse o container app com o comando **docker-compose exec app bash**;
  - No container, instale as dependências do composer com o comando **composer install**;
  - Em seguida instale as dependências de js com o comando **npm install**;
  - Gere a chave do Laravel com o comando **php artisan key:generate**;
  - Agora utilize qualquer database tool de sua preferência para criar o banco de dados. Esse projeto já vem com o PHPMyAdmin e você pode acessa-lo em **http://localhost:8080/** com as credênciais **root**/**root**. Com tudo pronto, crie um banco de dados chamado **laravel_exchange**;
  - De volta ao container no terminal, gere as tabelas do banco com o comando **php artisan migrate**;
  - Por fim, insira algumas configurações padrão com o comando **php artisan db:seed**. As credênciais para acessar o projeto são: email **admin@admin.com** e senha **admin**;
  - Agora você pode acessar o projeto através do endereço **http://localhost/login**;
  - **(opcional)** Configurar SMTP para disparo de emails no **.env**.

# Requisições na API

A documentação da API pode ser acessada em **http://localhost/api/docs**.
