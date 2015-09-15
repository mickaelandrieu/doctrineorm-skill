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
    public static function hydrate(Jarvis $jarvis)
    {
        /* DBAL */
		$jarvis['dbal_config'] = new \Doctrine\DBAL\Configuration();
		$jarvis->lock('dbal_config');

		$jarvis->settings->add(['db' => DOCTRINE_CONFIG['db']]);

		$jarvis['dbal_connection'] = function ($jarvis) {
		    return \Doctrine\DBAL\DriverManager::getConnection($jarvis->settings->get('db'), $jarvis->dbal_config);
		};

		/* Doctrine ORM */
		$jarvis['doctrine_orm.entity_path'] = [DOCTRINE_CONFIG['orm']['entity_path']];
		$jarvis['doctrine_orm.debug'] = DOCTRINE_CONFIG['orm']['debug'];

		$jarvis['doctrine.orm_config'] = function ($jarvis) {
		    return \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($jarvis['doctrine_orm.entity_path'], $jarvis['doctrine_orm.debug']);
		};

		$jarvis['doctrine_orm.entity.manager'] = function ($jarvis) {
		    return \Doctrine\ORM\EntityManager::create($jarvis->settings->get('db'), $jarvis['doctrine.orm_config']);
		};
    }
}
