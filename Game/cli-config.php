<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 18:56:21
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 15:30:58
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$appKernel = new \App\AppKernel;
$container = \App\AppKernel::getContainer();

$em = $container->get('database')->getLoginEntityManager();
//$em = $container->get('database')->getGameEntityManager();

return ConsoleRunner::createHelperSet($em);