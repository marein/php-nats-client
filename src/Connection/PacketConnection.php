<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Connection\PacketFactory\PacketFactory;
use Marein\Nats\Exception\ConnectionLostException;
use Marein\Nats\Protocol\Packet\Client\Packet as ClientPacket;
use Marein\Nats\Protocol\Packet\Server\Packet as ServerPacket;
use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;

final class PacketConnection
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var PacketFactory
     */
    private $packetFactory;

    /**
     * @var Buffer
     */
    private $buffer;

    /**
     * PacketConnection constructor.
     *
     * @param Connection $connection
     * @param PacketFactory $packetFactory
     */
    public function __construct(Connection $connection, PacketFactory $packetFactory)
    {
        $this->connection = $connection;
        $this->packetFactory = $packetFactory;
        $this->buffer = Buffer::emptyBuffer();
    }

    /**
     * Send the packet over the wire.
     *
     * @param ClientPacket $packet
     *
     * @throws ConnectionLostException
     */
    public function sendPacket(ClientPacket $packet): void
    {
        $this->connection->send($packet->pack());
    }

    /**
     * Receive a packet.
     *
     * @return ServerPacket
     * @throws ConnectionLostException
     */
    public function receivePacket(): ServerPacket
    {
        // First try to create a packet from the remaining buffer.
        $result = $this->packetFactory->tryToCreateFromBuffer($this->buffer);

        if ($result->packet() !== null) {
            $this->buffer = $result->remainingBuffer();

            return $result->packet();
        }

        // Then try to build until there is a next packet.
        do {
            $this->buffer = $this->buffer->append($this->connection->receive());

            $result = $this->packetFactory->tryToCreateFromBuffer($this->buffer);
        } while ($result->packet() === null);

        $this->buffer = $result->remainingBuffer();

        return $result->packet();
    }
}
