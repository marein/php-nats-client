<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Connection\PacketFactory\MsgPacketFactory;
use Marein\Nats\Connection\PacketFactory\Result;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;
use Marein\Nats\Protocol\Packet\Server\Msg;
use PHPUnit\Framework\TestCase;

class MsgPacketFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesFromBufferWithoutReplyTo(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Msg(
                new Subject('sub'),
                new SubscriptionId('sid'),
                null,
                'payload'
            )
        );

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("MSG sub sid 7\r\npayload\r\n")
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itCreatesFromBufferWithReplyTo(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Msg(
                new Subject('sub'),
                new SubscriptionId('sid'),
                new Subject('reply'),
                'payload'
            )
        );

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("MSG sub sid reply 7\r\npayload\r\n")
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
            new Msg(
                new Subject('sub'),
                new SubscriptionId('sid'),
                null,
                'payload'
            )
        );

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("MSG sub sid 7\r\npayload\r\n+OK")
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

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append('+OK')
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itExpectsTheFullPacket(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer()->append("MSG sub sid 7\r\npayload"),
            null
        );

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("MSG sub sid 7\r\npayload")
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itOnlyAcceptsFourOrFiveHeaders(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer()->append("MSG sub sid malformed reply 7\r\npayload\r\n"),
            null
        );

        $packetFactory = new MsgPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("MSG sub sid malformed reply 7\r\npayload\r\n")
        );

        $this->assertEquals($expectedResult, $result);
    }
}
