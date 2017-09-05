<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 11:32:57
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 19:26:13
 */

namespace Hetwan\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Database
{
	/**
	 * @Inject("Configuration")
	 */
	private $configuration;

	private $entityManager;

	public function create($entitiesPath)
	{
		$dbParameters = [
			'driver' => 'pdo_mysql',
			'user' => $this->configuration->get('database.user'),
			'password' => $this->configuration->get('database.password'),
			'dbname' => $this->configuration->get('database.name')
		];

		$this->entityManager = EntityManager::create($dbParameters, Setup::createAnnotationMetadataConfiguration([$entitiesPath], DEBUG));
	}

	public function getEntityManager()
	{
		return $this->entityManager;
	}
}