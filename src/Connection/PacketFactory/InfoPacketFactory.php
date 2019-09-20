<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Info;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class InfoPacketFactory implements PacketFactory
{
    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        if (!$buffer->startsWith('INFO ') ||
            !$buffer->canReadUntilAfterNextOccurrence(Packet::MESSAGE_TERMINATOR)
        ) {
            return new Result($buffer, null);
        }

        $infoBuffer = $buffer->readUntilAfterNextOccurrence(Packet::MESSAGE_TERMINATOR);

        $packet = Info::fromJson($infoBuffer->value());

        return new Result(
            $buffer->removeUpToPosition($infoBuffer->length()),
            $packet
        );
    }
}
