<?php

namespace Api\Doctrine;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Migration;
use Interop\Container\ContainerInterface;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class MigrationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        // Doctrine Migration
        $migrationConfig = $config['doctrine']['migrations_configuration'];
        $configuration = new Configuration();
        $configuration->setMigrationsTableName($migrationConfig['table']);
        $configuration->setMigrationsDirectory($migrationConfig['directory']);
        $configuration->setMigrationsNamespace($migrationConfig['namespace']);
        $configuration->registerMigrationsFromDirectory($migrationConfig['']);
        
        /* @var $command \Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand */
        $command = new Migration($configuration);

        return $command;
    }
}
