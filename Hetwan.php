<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:24:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 19:25:43
 */

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/app/AppKernel.php';

class Hetwan extends AppKernel
{
	private $container;
	private $core;

	public function __construct()
	{
		parent::__construct();

		$this->container = $this->containerBuilder->build();
		$this->core = new \Hetwan\Core\Core($this);
	}

	public function run()
	{
		$this->core->run();
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function getCore()
	{
		return $this->core;
	}
}

$hetwan = new Hetwan;

$hetwan->run();