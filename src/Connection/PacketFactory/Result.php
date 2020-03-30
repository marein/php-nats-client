<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class Result
{
    /**
     * @var Buffer
     */
    private Buffer $remainingBuffer;

    /**
     * @var Packet|null
     */
    private ?Packet $packet;

    public function __construct(Buffer $remainingBuffer, ?Packet $packet)
    {
        $this->remainingBuffer = $remainingBuffer;
        $this->packet = $packet;
    }

    /**
     * Returns the remaining buffer.
     *
     * @return Buffer
     */
    public function remainingBuffer(): Buffer
    {
        return $this->remainingBuffer;
    }

    /**
     * Returns the packet.
     *
     * @return Packet|null
     */
    public function packet(): ?Packet
    {
        return $this->packet;
    }
}
