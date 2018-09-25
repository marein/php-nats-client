<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Packet;

final class Ok implements Packet
{
    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        return '+OK' . Packet::MESSAGE_TERMINATOR;
    }
}
