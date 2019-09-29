<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Connection\PacketFactory\PongPacketFactory;
use Marein\Nats\Connection\PacketFactory\Result;
use Marein\Nats\Protocol\Packet\Server\Pong;
use PHPUnit\Framework\TestCase;

class PongPacketFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesFromBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Pong()
        );

        $packetFactory = new PongPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("PONG\r\n")
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itCreatesFromBufferAndReturnsRemainingBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer()->append('+OK'),
            new Pong()
        );

        $packetFactory = new PongPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("PONG\r\n+OK")
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itJustReturnsRemainingBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer()->append('+OK'),
            null
        );

        $packetFactory = new PongPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append('+OK')
        );

        $this->assertEquals($expectedResult, $result);
    }
}
