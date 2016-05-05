# App Example Zend3/Doctrine2

## 1. Dependencias de Instalação
### Composer

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

### Gulp

    npm install -g gulp

## 2. GIT Clone, Baixe o Repositorio

    SSH: git clone git@github.com:jhonmike/StartAppZend3.git
    OR
    HTTP: git clone https://github.com/jhonmike/StartAppZend3.git
    cd StartAppZend3

## 3. Instalação

    composer install
    npm install
    gulp

## 4. Config base de dados

DUPLIQUE o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

## 5. Criando o banco e alimentando as tabelas com os seguintes comandos

    composer orm:create
    composer orm:fixture

## 6. Acesso Pre Cadastrados

Developer

    Login: developer
    Password: 123456

Administrator

    Login: admin
    Password: 123456

## Outros Comandos
### Atualizar banco

    composer orm:update

### Apagar banco

    composer orm:drop
