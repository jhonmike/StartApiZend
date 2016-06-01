# Api Example Zend3/Doctrine2

## 1. GIT Clone, Baixe o Repositorio

    SSH: git clone git@github.com:jhonmike/StartApiZend3.git
    OR
    HTTP: git clone https://github.com/jhonmike/StartApiZend3.git
    cd StartApiZend3

## 2. Instalação local

Para executar local basta instalar o composer e executalo!

```bash
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
$ composer install
$ composer start
```

## 2. Instalação docker

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

## 3. Config base de dados

DUPLIQUE o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

## 4. Criando o banco e alimentando as tabelas com os seguintes comandos

```bash
$ composer orm:create
$ composer orm:fixture
```

## 5. Acesso Pre Cadastrados http://localhost:8080

Developer

    Login: developer
    Password: 123456

Administrator

    Login: admin
    Password: 123456

## Outros Comandos
### Atualizar banco

```bash
$ composer orm:update
```

### Apagar banco

```bash
$ composer orm:drop
```
