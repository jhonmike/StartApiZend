Zf2SkeletonApp
==============

1) Instalação
-------------

    SSH: git clone git@github.com:jhonmike/Zf2SkeletonApp.git
    OR
    HTTP: git clone https://github.com/jhonmike/Zf2SkeletonApp.git
    cd zf2skeletonapp
    php composer.phar self-update
    php composer.phar install

2) Config base de dados
-----------------------

DUPLIQUE, não renomeie o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

3) Criando o banco e alimentando as tabelas
-------------------------------------------
linux

    php vendor/bin/doctrine-module orm:schema-tool:create
    php vendor/bin/doctrine-module data-fixture:import

windows

    vendor\bin\doctrine-module orm:schema-tool:create
    vendor\bin\doctrine-module data-fixture:import

4) Primeiro Acesso
------------------
Developer (You)

    Login: developer
    Senha: 123456

Administrator (Your client)

    Login: admin
    Senha: 123456

Outros Comandos
---------------
Atualizar banco
---------------
linux

    php vendor/bin/doctrine-module orm:schema-tool:update --force

windows

    vendor\bin\doctrine-module orm:schema-tool:update --force

Apagar banco
------------
linux

    php vendor/bin/doctrine-module orm:schema-tool:drop --force

windows

    vendor\bin\doctrine-module orm:schema-tool:drop --force
