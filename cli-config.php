<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 18:56:21
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 19:00:39
 */

require __DIR__.'/app/AppKernel.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$appKernel = new AppKernel;
$container = $appKernel->getContainerBuilder()->build();
$container->get('Database')->create($appKernel->getRootDir().'/src/Entity');

return ConsoleRunner::createHelperSet($container->get('Database')->getEntityManager());