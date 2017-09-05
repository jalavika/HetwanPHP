<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 14:02:13
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 16:06:44
 */

namespace Hetwan\Network\Handler;


interface HandlerPartInterface
{
	public function condition();
	public function execute($data);
}