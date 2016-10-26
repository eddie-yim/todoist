<?php
namespace Practice\Repository\Impl;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

class EntityManagerProvider
{
    /**
     * @var EntityManager
     */
    private static $entity_manager;

    /**
     * @return EntityManager
     */
    public static function getEntityManager()
    {
        if (!isset(self::$entity_manager))
        {
            $root = __DIR__.'/../../../..';

            $config = Setup::createAnnotationMetadataConfiguration(array($root.'/src'), true);

            $properties = yaml_parse_file($root.'/ansible/vars/all.yml')['mariadb'];

            $connection_params = [
                'dbname' => $properties['database'],
                'user' => $properties['user'],
                'password' => $properties['password'],
                'host' => $properties['host'],
                'driver' => $properties['driver']
            ];

            $conn = DriverManager::getConnection($connection_params, $config);

            self::$entity_manager = EntityManager::create($conn, $config);
        }

        return self::$entity_manager;
    }
}
