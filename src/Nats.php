<?php
declare(strict_types=1);

namespace Marein\Nats;

use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\PacketConnection;
use Marein\Nats\Connection\Socket;
use Marein\Nats\Exception\ConnectionLostException;
use Marein\Nats\Exception\NatsException;
use Marein\Nats\Exception\SocketException;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Pub;

final class Nats
{
    /**
     * @var Socket
     */
    private $socket;

    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * Nats constructor.
     *
     * @param Socket            $socket
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(Socket $socket, ConnectionFactory $connectionFactory)
    {
        $this->socket = $socket;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Publish the payload on the given subject.
     *
     * @param string $subject
     * @param string $payload
     *
     * @throws ConnectionLostException
     */
    public function publish(string $subject, string $payload): void
    {
        $connection = $this->connectionFactory->establish($this->socket);
        $packetConnection = new PacketConnection($connection);

        $packetConnection->sendPacket(
            new Pub(
                new Subject($subject),
                $payload
            )
        );
    }
}
