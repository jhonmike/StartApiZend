Zf2SkeletonApp
==============

Instalação
----------
Parte 01

    SSH: git clone git@github.com:jhonmike/Zf2SkeletonApp.git
    HTTP: git clone https://github.com/jhonmike/Zf2SkeletonApp.git
    cd zf2skeletonapp
    php composer.phar self-update
    php composer.phar install

Parte 02 - Alterar o repository do projeto (Porque se vc da commit em algo que nao é do skeleton vc pode morrer hehe)

    SSH: git remote set-url origin git@10.0.0.2:namespace/repository.git
    HTTP: git remote set-url origin http://10.0.0.2/gitlab/namespace/repository.git

Config base de dados
--------------------

DUPLIQUE, não renomei o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

Zera o banco
------------
linux

    php vendor/bin/doctrine-module orm:schema-tool:create
    php vendor/bin/doctrine-module data-fixture:import

windows

    vendor\bin\doctrine-module orm:schema-tool:create
    vendor\bin\doctrine-module data-fixture:import


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
