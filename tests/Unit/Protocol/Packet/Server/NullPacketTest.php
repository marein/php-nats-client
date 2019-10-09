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
    public function itIsCallingBackVisitor(): void
    {
        $nullPacket = new NullPacket();

        $packetVisitor = $this->createMock(PacketHandler::class);
        $packetVisitor
            ->expects($this->once())
            ->method('handleNullPacket')
            ->with($nullPacket);

        $nullPacket->accept($packetVisitor);
    }
}
