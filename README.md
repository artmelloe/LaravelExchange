# Laravel Api

Aplicação desenvolvida em PHP com o framework Laravel para conversão de moedas. Esse projeto conta com duas vias para manipulação dos dados, através de uma API própria ou através do navegador do usuário.

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
  - **(opcional)** Agora resta configurar o SMTP para disparo de emails. Esse projeto utiliza do Gmail como SMTP padrão, logo será necessário um email e senha do mesmo para disparar os emails, além de uma configuração extra de segurança para permitir esses disparos. Você pode verificar essa configuração clicando [aqui](https://myaccount.google.com/lesssecureapps). Com tudo pronto, acesse o arquivo **EmailService** e preencha os campos **username** e **password** com suas respectivas informações.

# Requisições na API

Exemplo de **Login**:

- **URL:** http://localhost/api/login
- **Método:** _POST
- **Headers:** Accept: application/json | Content-Type: application/json
- **Body:**
```json
{
    "email": "admin@admin.com",
    "password": "admin"
}
```
- **Retorno:**
```json
{
    "user": {
        "id": 1,
        "name": "Admin",
        "email": "admin@admin.com",
        "email_verified_at": null,
        "created_at": "2022-05-13T01:53:08.000000Z",
        "updated_at": "2022-05-13T01:53:08.000000Z"
    },
    "authorisation": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9sb2dpbiIsImlhdCI6MTY1MjQwODU3OSwiZXhwIjoxNjUyNDEyMTc5LCJuYmYiOjE2NTI0MDg1NzksImp0aSI6InNrYk9CWGo5T3IwazBUekYiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.SLMiJJUDat8z_RzD5wXyYe_BdsAHr4yk0CTa7adgvTo",
        "type": "bearer"
    }
}
```

Exemplo de **Logout**:

- **URL:** http://localhost/api/logout
- **Método:** _POST
- **Headers:** Accept: application/json | Content-Type: application/json | Authorization: Bearer + token
- **Retorno:**
```json
{
    "message": "Successfully logged out"
}
```

Exemplo de **Configuração de Taxas**:

- **URL:** http://localhost/api/configuration
- **Método:** _POST
- **Headers:** Accept: application/json | Content-Type: application/json | Authorization: Bearer + token
- **Body:**
```json
{
	"boleto_fee": 1.45,
	"credit_card_fee": 7.63,
	"fee_amount_less": 2,
	"fee_amount_less_value": 3000,
	"fee_amount_greater": 1,
	"fee_amount_greater_value": 3000
}
```
- **Retorno:**
```json
{
    "id": "9d84f078-b8e7-42a8-b3db-f7f0016cc7c3",
    "boleto_fee": 0.014499999999999999,
    "credit_card_fee": 0.07629999999999999,
    "fee_amount_less": 0.02,
    "fee_amount_less_value": 3000,
    "fee_amount_greater": 0.01,
    "fee_amount_greater_value": 3000,
    "created_at": "2022-05-13T01:53:08.000000Z",
    "updated_at": "2022-05-13T01:53:08.000000Z"
}
```

Exemplo de **Conversão de Moedas**:

- **URL:** http://localhost/api/exchange
- **Método:** _POST
- **Headers:** Accept: application/json | Content-Type: application/json | Authorization: Bearer + token
- **Body:**
```json
{
	"income_currency": "USD",
	"amount_exchange": "5000",
	"payment_method": "boleto"
}
```
- **Retorno:**
```json
{
    "originCurrency": "BRL",
    "incomeCurrency": "USD",
    "amountExchange": "5000.00",
    "paymentMethod": "boleto",
    "currentCurrency": "5.14",
    "exchangeTotal": "948.93",
    "paymentFee": "72.50",
    "exchangeFee": "50.00",
    "exchangeWithoutFees": "4877.50"
}
```
