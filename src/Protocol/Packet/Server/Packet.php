<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

interface Packet
{
    /**
     * The nats message terminator.
     */
    public const MESSAGE_TERMINATOR = "\r\n";
}
