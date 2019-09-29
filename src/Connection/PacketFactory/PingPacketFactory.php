<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Packet;
use Marein\Nats\Protocol\Packet\Server\Ping;

final class PingPacketFactory implements PacketFactory
{
    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        if (!$buffer->startsWith('PING' . Packet::MESSAGE_TERMINATOR)) {
            return new Result($buffer, null);
        }

        return new Result(
            $buffer->removeUpToPosition(6),
            new Ping()
        );
    }
}
