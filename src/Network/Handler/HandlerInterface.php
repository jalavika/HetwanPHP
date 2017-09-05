<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 14:01:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 21:06:32
 */

namespace Hetwan\Network\Handler;


interface HandlerInterface
{
	const UNEXECUTED = 0;
	const CONTINUE = 1;
	const EXECUTED = 2;
	const FAILED = 3;

	public function handle($data);
}