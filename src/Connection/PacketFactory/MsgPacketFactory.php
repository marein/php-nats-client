<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;
use Marein\Nats\Protocol\Packet\Server\Msg;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class MsgPacketFactory implements PacketFactory
{
    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        if (!$buffer->startsWith('MSG ') ||
            !$buffer->canReadUntilAfterNextOccurrence(Packet::MESSAGE_TERMINATOR)
        ) {
            return new Result($buffer, null);
        }

        $msgHeaderBuffer = $buffer->readUntilAfterNextOccurrence(Packet::MESSAGE_TERMINATOR);
        $headers = explode(' ', $msgHeaderBuffer->value());

        if (count($headers) === 4) {
            [, $subject, $subscriptionId, $bytes] = $headers;
            $replyTo = null;
        } elseif (count($headers) === 5) {
            [, $subject, $subscriptionId, $replyTo, $bytes] = $headers;
        } else {
            return new Result($buffer, null);
        }

        $bytes = (int)$bytes;

        $payloadBuffer = $buffer->removeUpToPosition($msgHeaderBuffer->length());

        if (!$payloadBuffer->canReadUpToPosition($bytes + 2)) {
            return new Result($buffer, null);
        }

        $payload = $payloadBuffer->readUpToPosition($bytes)->value();

        return new Result(
            $payloadBuffer->removeUpToPosition($bytes + 2),
            new Msg(
                new Subject($subject),
                new SubscriptionId($subscriptionId),
                $replyTo !== null ? new Subject($replyTo) : null,
                $payload
            )
        );
    }
}
