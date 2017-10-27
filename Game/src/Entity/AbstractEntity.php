<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:29:33
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-24 18:59:49
 */

namespace Hetwan\Entity;

abstract class AbstractEntity implements EntityInterface
{
	public function save()
	{
		$this->getEntityManager()->persist($this);
		$this->getEntityManager()->flush();

		return $this;
	}

	public function remove()
	{
		$this->getEntityManager()->remove($this);
		$this->getEntityManager()->flush();

		return $this;
	}

	public function refresh()
	{
		$this->getEntityManager()->refresh($this);

		return $this;
	}

	/*
	public function __toString()
	{
		return '<' . \get_class($this) . ' ' . \method_exists($this, 'getId') ? $this->getId() : '?' . '>';
	}
	*/
}