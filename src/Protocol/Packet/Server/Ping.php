<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

final class Ping implements Packet
{
    /**
     * @inheritdoc
     */
    public function accept(PacketHandler $packetHandler): void
    {
        $packetHandler->handlePing($this);
    }
}
