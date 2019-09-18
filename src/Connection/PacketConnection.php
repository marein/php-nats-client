<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\ConnectionLostException;
use Marein\Nats\Protocol\Packet\Packet;

final class PacketConnection
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * PacketConnection constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Send the packet over the wire.
     *
     * @param Packet $packet
     *
     * @throws ConnectionLostException
     */
    public function sendPacket(Packet $packet): void
    {
        $this->connection->send($packet->pack());
    }
}
