<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Err;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class ErrTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedMessage = 'Error Message';

        $err = new Err($expectedMessage);

        $this->assertSame($expectedMessage, $err->message());
    }

    /**
     * @test
     */
    public function itIsCallingBackVisitor(): void
    {
        $err = new Err('Error Message');

        $packetVisitor = $this->createMock(PacketHandler::class);
        $packetVisitor
            ->expects($this->once())
            ->method('handleErr')
            ->with($err);

        $err->accept($packetVisitor);
    }
}
