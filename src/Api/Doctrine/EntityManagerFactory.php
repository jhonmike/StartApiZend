<?php

namespace Api\Doctrine;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Interop\Container\ContainerInterface;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class EntityManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config')['doctrine'] : [];
        $proxyDir = (isset($config['orm']['proxy_dir'])) ?
            $config['orm']['proxy_dir'] : 'data/cache/EntityProxy';
        $proxyNamespace = (isset($config['orm']['proxy_namespace'])) ?
            $config['orm']['proxy_namespace'] : 'EntityProxy';
        $autoGenerateProxyClasses = (isset($config['orm']['auto_generate_proxy_classes'])) ?
            $config['orm']['auto_generate_proxy_classes'] : false;
        $underscoreNamingStrategy = (isset($config['orm']['underscore_naming_strategy'])) ?
            $config['orm']['underscore_naming_strategy'] : false;
        // Doctrine ORM
        $doctrine = new Configuration();
        $doctrine->setProxyDir($proxyDir);
        $doctrine->setProxyNamespace($proxyNamespace);
        $doctrine->setAutoGenerateProxyClasses($autoGenerateProxyClasses);
        if ($underscoreNamingStrategy) {
            $doctrine->setNamingStrategy(new UnderscoreNamingStrategy());
        }
        // ORM mapping by Annotation
        AnnotationRegistry::registerFile(
            'vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );
        $driver = new AnnotationDriver(
            new AnnotationReader(),
            $config['annotation']['metadata']
        );
        $doctrine->setMetadataDriverImpl($driver);
        // Cache
        $cache = $container->get(Cache::class);
        $doctrine->setQueryCacheImpl($cache);
        $doctrine->setResultCacheImpl($cache);
        $doctrine->setMetadataCacheImpl($cache);

        // // Migrations
        // $migrations = $container->get(\Doctrine\DBAL\Migrations\Migration::class);
        // $doctrine->setMigration($migrations);

        // EntityManager
        return EntityManager::create($config['connection'], $doctrine);
    }
}
