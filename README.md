# Documentação do Projeto Laravel com Docker

Este é um guia de configuração para um projeto Laravel usando Docker e Autenticação JWT. O projeto utiliza um ambiente Dockerizado para facilitar a configuração e execução.

## Instalação do projeto

Clone o repositório:

```bash
git clone https://github.com/selogerkkk/devpass-backend/.git
```

Copie o arquivo de ambiente:

```bash
cp .env.example .env
```

Instale as dependências do Laravel com o Composer:

```bash
composer install
```

Gere a chave de aplicação:

```bash
php artisan key:generate
```

Gere a chave JWT:

```bash
php artisan jwt:secret -f
```

## Configuração do Docker

Construa os contêineres Docker:

```bash
./vendor/bin/sail build
# ou
sail build
```

Execute os contêineres Docker:

```bash
./vendor/bin/sail up
# ou
sail up
```

## Configuração do Banco de Dados

Rode as migrações para configurar o banco de dados:

```bash
sail artisan migrate:fresh
```

## Semeando o Banco de Dados

Rode esse comando para semear o banco de dados:

```bash
sail artisan db:seed DatabaseSeeder
```

## Problema de Permissão

Se encontrar o erro "Failed to open stream: Permission denied", execute:

```bash
chmod -R guo+w storage
```

## Documentação da API

A documentação da API é feita usando o Scramble. Para visualizar a documentação usando a ScrambleUI, acesse [Scramble Documentation](http://localhost:3000/docs/api).

## Usuário de Teste

Um usuário de teste foi criado para fins de teste. As informações do usuário são as seguintes:

- Email: `admin@gmail.com`
- Senha: `password`
