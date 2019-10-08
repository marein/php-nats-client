<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Clock\Timer;
use Marein\Nats\Connection\PacketFactory\PacketFactory;
use Marein\Nats\Exception\ConnectionException;
use Marein\Nats\Protocol\Packet\Client\Packet as ClientPacket;
use Marein\Nats\Protocol\Packet\Server\NullPacket;
use Marein\Nats\Protocol\Packet\Server\Packet as ServerPacket;

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
     * @var Clock
     */
    private $clock;

    /**
     * @var Buffer
     */
    private $buffer;

    /**
     * PacketConnection constructor.
     *
     * @param Connection    $connection
     * @param PacketFactory $packetFactory
     * @param Clock         $clock
     */
    public function __construct(Connection $connection, PacketFactory $packetFactory, Clock $clock)
    {
        $this->connection = $connection;
        $this->packetFactory = $packetFactory;
        $this->clock = $clock;
        $this->buffer = Buffer::emptyBuffer();
    }

    /**
     * Send the packet over the wire.
     *
     * @param ClientPacket $packet
     *
     * @throws ConnectionException
     */
    public function sendPacket(ClientPacket $packet): void
    {
        $this->connection->send($packet->pack());
    }

    /**
     * Receive a packet.
     *
     * @param int $timeoutInSeconds
     *
     * @return ServerPacket
     * @throws ConnectionException
     */
    public function receivePacket(int $timeoutInSeconds): ServerPacket
    {
        // First try to create a packet from the remaining buffer.
        $result = $this->packetFactory->tryToCreateFromBuffer($this->buffer);

        if ($result->packet() !== null) {
            $this->buffer = $result->remainingBuffer();

            return $result->packet();
        }

        $timer = new Timer($this->clock, $timeoutInSeconds);

        // Then try to build until there is a next packet.
        do {
            $this->buffer = $this->buffer->append(
                $this->connection->receive(
                    $timer->remaining()
                )
            );

            $result = $this->packetFactory->tryToCreateFromBuffer($this->buffer);
        } while ($timer->remaining() !== 0 && $result->packet() === null);

        $this->buffer = $result->remainingBuffer();

        return $result->packet() ?? new NullPacket();
    }
}
