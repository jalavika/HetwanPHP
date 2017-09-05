<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 21:44:25
 */

namespace Hetwan\Entity;

/**
 * @Entity @Table(name="players")
 **/
class Player
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $serverId;

    /**
     * @ManyToOne(targetEntity="Account", inversedBy="players")
     * @JoinColumn(name="accountId", referencedColumnName="id")
     */
    private $account;

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
     * Set serverId
     *
     * @param integer $serverId
     *
     * @return Player
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get serverId
     *
     * @return integer
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set account
     *
     * @param \Account $account
     *
     * @return Player
     */
    public function setAccount(\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}