<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Packet;
use Marein\Nats\Protocol\Packet\Server\Info;
use Marein\Nats\Protocol\Packet\Server\Ok;

interface PacketFactory
{
    /**
     * Tries to create a packet from a buffer.
     *
     * @param Buffer $buffer
     *
     * @return Result
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result;
}
