<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-03 22:40:48
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 12:30:54
 */

namespace Hetwan\Core;

use Symfony\Component\Yaml\Yaml;

class Configuration
{	
	private $attrs;

	public function __construct($configFilePath)
	{
		$this->attrs = Yaml::parse(file_get_contents($configFilePath));
	}

	public function get($attrPath)
	{
		$el = $this->attrs;

		foreach (explode('.', $attrPath) as $attr)
		{
			if (!isset($el[$attr]))
				throw new ConfigurationException("Unable to get '{$attrPath}'.\n");

			$el = $el[$attr];
		}

		return $el;
	}
}

class ConfigurationException extends \Exception {}