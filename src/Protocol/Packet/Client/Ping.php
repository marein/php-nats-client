<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

final class Ping implements Packet
{
    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        return 'PING' . Packet::MESSAGE_TERMINATOR;
    }
}
