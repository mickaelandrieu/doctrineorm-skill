<?php
namespace Jarvis\Skill\DoctrineORM;

use Jarvis\Jarvis;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;

/**
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
class ContainerProvider implements ContainerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $jarvis)
    {
        $doctrineConfig = $jarvis->settings->get('doctrine', []);

        if (empty($doctrineConfig)) {
            throw new \LogicException('You need to configure DoctrineORM Skill.');
        }
        /* DBAL */
    		$jarvis['dbal_config'] = new \Doctrine\DBAL\Configuration();
    		$jarvis->lock('dbal_config');

    		$jarvis['dbal_connection'] = function ($jarvis) {
    		    return \Doctrine\DBAL\DriverManager::getConnection($doctrineConfig['db'], $jarvis->dbal_config);
    		};

    		/* Doctrine ORM */
    		$jarvis['doctrine_orm.entity_path'] = [$doctrineConfig['orm']['entity_path']];
    		$jarvis['doctrine_orm.debug'] = $doctrineConfig['orm']['debug'];

    		$jarvis['doctrine.orm_config'] = function ($jarvis) {
    		    return \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($jarvis['doctrine_orm.entity_path'], $jarvis['doctrine_orm.debug']);
    		};

    		$jarvis['doctrine_orm.entity.manager'] = function ($jarvis) {
    		    return \Doctrine\ORM\EntityManager::create($doctrineConfig['db'], $jarvis['doctrine.orm_config']);
    		};
    }
}
