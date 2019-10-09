<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\NullPacket;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class NullPacketTest extends TestCase
{
    /**
     * @test
     */
    public function itIsCallingBackPacketHandler(): void
    {
        $nullPacket = new NullPacket();

        $packetHandler = $this->createMock(PacketHandler::class);
        $packetHandler
            ->expects($this->once())
            ->method('handleNullPacket')
            ->with($nullPacket);

        $nullPacket->accept($packetHandler);
    }
}
