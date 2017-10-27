<?php

/**
 * @Author: jean
 * @Date:   2017-09-21 23:44:34
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 18:00:54
 */

namespace Hetwan\Entity\Game;


/**
 * @Entity 
 * @Table(name="items")
 */
class Item extends AbstractGameEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $itemId;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $playerId;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $templateId;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $position;

    /**
     * @Column(type="text")
     *
     * @var string
     */
    protected $effects;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $quantity;

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
     * Set itemId
     *
     * @param integer $itemId
     *
     * @return Item
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set playerId
     *
     * @param integer $playerId
     *
     * @return Item
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

    /**
     * Get playerId
     *
     * @return integer
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * Set templateId
     *
     * @param integer $templateId
     *
     * @return Item
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Get templateId
     *
     * @return integer
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Item
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set effects
     *
     * @param string $effects
     *
     * @return Item
     */
    public function setEffects($effects)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * Get parsed effects
     *
     * @return string
     */
    public function getParsedEffects()
    {
        return \Hetwan\Helper\ItemEffectHelper::getEffectsFromString($this->effects);
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}