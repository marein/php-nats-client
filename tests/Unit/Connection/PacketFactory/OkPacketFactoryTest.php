<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Connection\PacketFactory\OkPacketFactory;
use Marein\Nats\Connection\PacketFactory\Result;
use Marein\Nats\Protocol\Packet\Server\Ok;
use PHPUnit\Framework\TestCase;

class OkPacketFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesFromBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Ok()
        );

        $packetFactory = new OkPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("+OK\r\n")
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
            new Ok()
        );

        $packetFactory = new OkPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("+OK\r\n+OK")
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

        $packetFactory = new OkPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append('+OK')
        );

        $this->assertEquals($expectedResult, $result);
    }
}
