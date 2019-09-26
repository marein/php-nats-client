<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Connection\PacketFactory\ErrPacketFactory;
use Marein\Nats\Connection\PacketFactory\Result;
use Marein\Nats\Protocol\Packet\Server\Err;
use PHPUnit\Framework\TestCase;

class ErrPacketFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesFromBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Err('Error Message')
        );

        $packetFactory = new ErrPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("-ERR 'Error Message'\r\n")
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
            new Err('Error Message')
        );

        $packetFactory = new ErrPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("-ERR 'Error Message'\r\n+OK")
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

        $packetFactory = new ErrPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append('+OK')
        );

        $this->assertEquals($expectedResult, $result);
    }
}
