<?php

namespace Hetwan\Network\Login;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class LoginServer implements MessageComponentInterface 
{
    private $container;

	public function __construct(\DI\Container $container)
	{
        $this->container = $container;
	}

    public function onOpen(ConnectionInterface $conn)
    {
        $this->container->get('ClientPool')->addClient($conn->resourceId, $this->container->make('Hetwan\Network\Login\LoginClient', ['conn' => $conn]));
        $this->container->get('Logger')->debug("({$conn->resourceId}) Client connected\n");
    }

    public function onMessage(ConnectionInterface $conn, $message) 
    {
        $packets = array_filter(
            explode("\n", 
                str_replace(chr(0), "\n", 
                    str_replace("\n", '', $message)
                )
            )
        );

        foreach ($packets as $packet)
        {
            if ($packet == 'Af')
                continue;

            $this->container->get('Logger')->debug("({$conn->resourceId}) Received packet: {$packet}\n");
            $this->container->get('ClientPool')->getClient($conn->resourceId)->handle($packet);
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        $account = $this->container->get('ClientPool')->getClient($conn->resourceId)->getAccount();

        if (null != $account)
        {
            echo "do save";

            $this->container->get('ClientPool')->removeAccount($account->getId());
        }

        $this->container->get('ClientPool')->removeClient($conn->resourceId);
        $this->container->get('Logger')->debug("({$conn->resourceId}) Client disconnected\n");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
    	$conn->close();

        $this->container->get('Logger')->debug("({$conn->resourceId}) Error: {$e}\n");
    }
}