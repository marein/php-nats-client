<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Ok;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class OkTest extends TestCase
{
    /**
     * @test
     */
    public function itIsCallingBackPacketHandler(): void
    {
        $ok = new Ok();

        $packetHandler = $this->createMock(PacketHandler::class);
        $packetHandler
            ->expects($this->once())
            ->method('handleOk')
            ->with($ok);

        $ok->accept($packetHandler);
    }
}
