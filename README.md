# Full-Stack Zend2/Doctrine2

## 1. Dependencias de Instalação
### Composer

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

### Gulp

    npm install -g gulp

## 2. GIT Clone, Baixe o Repositorio

    SSH: git clone git@github.com:jhonmike/StartZend2.git
    OR
    HTTP: git clone https://github.com/jhonmike/StartZend2.git
    cd StartZend2

## 3. Instalação

    composer install
    npm install
    gulp

## 4. Config base de dados

DUPLIQUE o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

## 5. Criando o banco e alimentando as tabelas com os seguintes comandos

linux/osx

    php vendor/bin/doctrine-module orm:schema-tool:create
    php vendor/bin/doctrine-module data-fixture:import

windows

    vendor\bin\doctrine-module orm:schema-tool:create
    vendor\bin\doctrine-module data-fixture:import

## 6. Acesso Pre Cadastrados

Developer

    Login: developer
    Senha: 123456

Administrator

    Login: admin
    Senha: 123456

## Outros Comandos
### Atualizar banco

linux/osx

    php vendor/bin/doctrine-module orm:schema-tool:update --force

windows

    vendor\bin\doctrine-module orm:schema-tool:update --force

### Apagar banco

linux/osx

    php vendor/bin/doctrine-module orm:schema-tool:drop --force

windows

    vendor\bin\doctrine-module orm:schema-tool:drop --force
