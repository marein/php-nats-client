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

        $information = json_decode(
            $infoBuffer
                ->readUpToPosition($infoBuffer->length() - 2)
                ->removeUpToPosition(5)
                ->value(),
            true
        );

        return new Result(
            $buffer->removeUpToPosition($infoBuffer->length()),
            new Info(
                $information['server_id'],
                $information['version'],
                (int)$information['proto'],
                (int)$information['max_payload'],
                $information['auth_required'] ?? false,
                $information['tls_required'] ?? false,
                $information['tls_verify'] ?? false
            )
        );
    }
}
