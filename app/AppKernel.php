<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:18:58
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 21:33:14
 */

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

define('DEBUG', false);

class AppKernel
{
	protected $containerBuilder;

	public function __construct()
	{
		$this->makeContainerBuilder();
		$this->buildDependencies();
	}

	private function makeContainerBuilder()
	{
		$containerBuilder = new \DI\ContainerBuilder();
		$containerBuilder->useAutowiring(true);
		$containerBuilder->useAnnotations(true);
		//$containerBuilder->setDefinitionCache(new \Doctrine\Common\Cache\ApcCache());

		$this->containerBuilder = $containerBuilder;
	}

	private function buildDependencies()
	{
		return $this->containerBuilder->addDefinitions([
			'Configuration' => DI\Object('Hetwan\Core\Configuration')->constructor($this->getRootDir().'/app/config/config.yml'),
			'Database' => DI\object('Hetwan\Core\Database'),
			'ClientPool' => DI\object('Hetwan\Network\Login\ClientPool'),
			'Logger' => DI\factory(function () {
		    	$logger = new Logger('HetwanPHP');

		    	//$fileHandler = new StreamHandler($this->getLogDir().'/'.date('d-m-Y'), Logger::DEBUG);
		    	//$fileHandler->setFormatter(new LineFormatter());
		    	//$logger->pushHandler($fileHandler);

		    	return $logger;
			}),
		]);
	}

	public function getContainerBuilder()
	{
		return $this->containerBuilder;
	}

	public function getRootDir()
    {
		return dirname(__DIR__);
    }
    
    public function getLogDir()
    {
		return dirname(__DIR__).'/var/logs';
    }
}