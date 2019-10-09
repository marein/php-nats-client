<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Pong;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class PongTest extends TestCase
{
    /**
     * @test
     */
    public function itIsCallingBackPacketHandler(): void
    {
        $pong = new Pong();

        $packetHandler = $this->createMock(PacketHandler::class);
        $packetHandler
            ->expects($this->once())
            ->method('handlePong')
            ->with($pong);

        $pong->accept($packetHandler);
    }
}
