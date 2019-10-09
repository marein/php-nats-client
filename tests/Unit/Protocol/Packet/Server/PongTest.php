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
    public function itIsCallingBackVisitor(): void
    {
        $pong = new Pong();

        $packetVisitor = $this->createMock(PacketHandler::class);
        $packetVisitor
            ->expects($this->once())
            ->method('handlePong')
            ->with($pong);

        $pong->accept($packetVisitor);
    }
}
