<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Ok;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class OkPacketFactory implements PacketFactory
{
    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        if (!$buffer->startsWith('+OK' . Packet::MESSAGE_TERMINATOR)) {
            return new Result($buffer, null);
        }

        return new Result(
            $buffer->removeUpToPosition(5),
            new Ok()
        );
    }
}
