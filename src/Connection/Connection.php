<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\SocketException;
use Marein\Nats\Protocol\Packet\Packet;

final class Connection
{
    /**
     * @var Socket
     */
    private $socket;

    /**
     * Connection constructor.
     *
     * @param Socket $socket
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * Send the packet over the wire.
     *
     * @param Packet $packet
     *
     * @throws SocketException
     */
    public function sendPacket(Packet $packet): void
    {
        $this->socket->send($packet->pack());
    }
}
