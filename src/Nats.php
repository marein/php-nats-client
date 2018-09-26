<?php
declare(strict_types=1);

namespace Marein\Nats;

use Marein\Nats\Connection\Connection;
use Marein\Nats\Connection\Socket;
use Marein\Nats\Exception\SocketException;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Pub;

final class Nats
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * Nats constructor.
     *
     * @param Socket $socket
     */
    public function __construct(Socket $socket)
    {
        $this->connection = new Connection($socket);
    }

    /**
     * Publish the payload on the given subject.
     *
     * @param string $subject
     * @param string $payload
     *
     * @throws SocketException
     */
    public function publish(string $subject, string $payload): void
    {
        $this->connection->sendPacket(
            new Pub(
                new Subject($subject),
                $payload
            )
        );
    }
}
