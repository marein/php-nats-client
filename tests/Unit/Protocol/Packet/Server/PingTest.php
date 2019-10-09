<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Ping;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class PingTest extends TestCase
{
    /**
     * @test
     */
    public function itIsCallingBackVisitor(): void
    {
        $ping = new Ping();

        $packetVisitor = $this->createMock(PacketHandler::class);
        $packetVisitor
            ->expects($this->once())
            ->method('handlePing')
            ->with($ping);

        $ping->accept($packetVisitor);
    }
}
