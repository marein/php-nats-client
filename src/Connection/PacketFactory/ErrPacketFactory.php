<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Err;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class ErrPacketFactory implements PacketFactory
{
    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        if (!$buffer->startsWith('-ERR \'') ||
            !$buffer->canReadUntilAfterNextOccurrence('\'' . Packet::MESSAGE_TERMINATOR)
        ) {
            return new Result($buffer, null);
        }

        $errBuffer = $buffer->readUntilAfterNextOccurrence(Packet::MESSAGE_TERMINATOR);

        return new Result(
            $buffer->removeUpToPosition($errBuffer->length()),
            new Err(
                $errBuffer
                    ->readUpToPosition($errBuffer->length() - 3)
                    ->removeUpToPosition(6)
                    ->value()
            )
        );
    }
}
