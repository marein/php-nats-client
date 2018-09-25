<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

final class Pong implements Packet
{
    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        return 'PONG' . Packet::MESSAGE_TERMINATOR;
    }
}
