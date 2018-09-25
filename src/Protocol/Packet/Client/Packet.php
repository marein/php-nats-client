<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

interface Packet
{
    /**
     * The nats message terminator.
     */
    public const MESSAGE_TERMINATOR = "\r\n";

    /**
     * Return the string representation of the packet. Ready for sending over the wire.
     *
     * @return string
     */
    public function pack(): string;
}
