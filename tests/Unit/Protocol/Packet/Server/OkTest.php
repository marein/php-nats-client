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
    public function itIsCallingBackVisitor(): void
    {
        $ok = new Ok();

        $packetVisitor = $this->createMock(PacketHandler::class);
        $packetVisitor
            ->expects($this->once())
            ->method('handleOk')
            ->with($ok);

        $ok->accept($packetVisitor);
    }
}
