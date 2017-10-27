<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-20 18:23:03
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:13:28
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Handler\{AbstractHandlerContainer, GameHandlerTrait};

use Hetwan\Helper\MapDataHelper;

use Hetwan\Network\Game\Protocol\Formatter\FactionMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ChannelMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\BasicMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\InformationMessageFormatter;


class GameHandlerContainer extends AbstractHandlerContainer
{
	use GameHandlerTrait;

	public function __construct($client)
	{
		$this->client = $client;

		$this->addHandler('B', BasicHandler::class)
			 ->addHandler('G', GameHandler::class);
	}

	public function initialize()
	{
		$this->send(FactionMessageFormatter::subAreasFactionsMessage(\Hetwan\Loader\SubAreaDataLoader::getSubAreasData()));
		$this->send(ChannelMessageFormatter::addChannelsMessage($this->getPlayer()->getChannels()));
		$this->send(ChannelMessageFormatter::enabledEmotesMessage());
		$this->send(InformationMessageFormatter::welcomeMessage());

		if (($lastConnectionDate = $this->getAccount()->getLastConnectionDate()) != null && ($lastConnectionIpAddress = $this->getAccount()->getLastConnectionIpAddress()) != null)
			$this->send(InformationMessageFormatter::lastConnectionInformationMessage($lastConnectionDate, $lastConnectionIpAddress));

		$this->send(InformationMessageFormatter::currentIpAddressInformationMessage(($ipAddress = \Hetwan\Network\Helper\NetworkHelper::getCleanIpAddress($this->getClient()->getConnection()->remoteAddress))));

		$this->send(GameMessageFormatter::queueMessage(1, 0, 0, 1));

		$this->getAccount()
			 ->setLastConnectionDate(new \DateTime('NOW'))
			 ->setLastConnectionIpAddress($ipAddress);
	}

	public function handle($data)
	{
		if (isset($this->handlers[($prefix = substr($data, 0, 1))]))
			$this->handlers[$prefix]->handle(substr($data, 1));
	}

	public function onClose()
	{
		MapDataHelper::removePlayerInMap((int) $this->getPlayer()->getMapId(), $this->getPlayer());

        $this->getPlayer()->save();
	}
}