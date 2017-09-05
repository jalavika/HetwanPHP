<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 21:44:25
 */

namespace Hetwan\Entity;

/**
 * @Entity @Table(name="servers")
 **/
class Server
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $key;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $state;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $population;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $requireSubscription;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return Server
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Server
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Server
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set requireSubscription
     *
     * @param integer $requireSubscription
     *
     * @return Server
     */
    public function setRequireSubscription($requireSubscription)
    {
        $this->requireSubscription = $requireSubscription;

        return $this;
    }

    /**
     * Get requireSubscription
     *
     * @return integer
     */
    public function getRequireSubscription()
    {
        return $this->requireSubscription;
    }
}