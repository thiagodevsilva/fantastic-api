# API Doc

## Sobre

Laravel 9 com JWT-Auth e documentação de API com Swagger.

## Require

- php: "^8.0.2"
- tymon/jwt-auth: "^2.0"
- phpunit/phpunit: "^9.6"
- darkaonline/l5-swagger: "^8.5"
- composer: 2.4

## Executando o projeto

> Faça o clone do repositorio ou baixe o projeto.

> Crie o banco de dados `CREATE DATABASE api_test`.

> Configure o arquivo `.env` para conexão com o banco de dados.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_test
DB_USERNAME=root
DB_PASSWORD=
```

> No terminal acesse o diretório do projeto e execute os seguintes comandos um por vez com atenção aos avisos e alertas.

$ composer update
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan l5-swagger:generate
$ php artisan migrate
$ php artisan serve //rodar o projeto

> Acesse via localhost:<port>/api/documentation

## Usando a API

> Na tela principal do swagger, acesse o metodo `login` e clique no botão **Try it out**.
> Será habilitada a edição do JSON, preencha conforme o exemplo:
```
{
  "email": "admin@devthiago.com",
  "password": "1234"
}
``` 

> Clique em execute, copie da resposta recebida o token de acesso.

> Suba até o topo da tela e clique em **Authorize**, e cole o token, e clique novamente em **Authorize**.

> Agora logado pode usar os métodos **/api/produtos** e **/api/produtos/{id}**.

> Para encerrar a sessão invalidando o token basta executar o método **logout** passando o token como parâmetro.