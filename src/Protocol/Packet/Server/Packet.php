<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

interface Packet
{
    /**
     * The nats message terminator.
     */
    public const MESSAGE_TERMINATOR = "\r\n";

    /**
     * Calling back the specified handler.
     *
     * @param PacketHandler $packetHandler
     */
    public function accept(PacketHandler $packetHandler): void;
}
