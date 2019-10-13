<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Connection\PacketFactory\InfoPacketFactory;
use Marein\Nats\Connection\PacketFactory\Result;
use Marein\Nats\Protocol\Packet\Server\Info;
use PHPUnit\Framework\TestCase;

class InfoPacketFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesFromBuffer(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Info(
                'ABC',
                '2.0.4',
                1,
                123,
                true,
                true,
                true
            )
        );
        $infoPacketInformation = json_encode(
            [
                'server_id' => 'ABC',
                'version' => '2.0.4',
                'proto' => 1,
                'max_payload' => 123,
                'auth_required' => true,
                'tls_required' => true,
                'tls_verify' => true
            ]
        );

        $packetFactory = new InfoPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("INFO {$infoPacketInformation}\r\n")
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
            new Info(
                'ABC',
                '2.0.4',
                1,
                123,
                true,
                true,
                true
            )
        );
        $infoPacketInformation = json_encode(
            [
                'server_id' => 'ABC',
                'version' => '2.0.4',
                'proto' => 1,
                'max_payload' => 123,
                'auth_required' => true,
                'tls_required' => true,
                'tls_verify' => true
            ]
        );

        $packetFactory = new InfoPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("INFO {$infoPacketInformation}\r\n+OK")
        );

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function itUsesDefaultValues(): void
    {
        $expectedResult = new Result(
            Buffer::emptyBuffer(),
            new Info(
                'ABC',
                '2.0.4',
                1,
                123,
                false,
                false,
                false
            )
        );
        // auth_required, tls_required, tls_verify are missing on purpose and for the test case.
        $infoPacketInformation = json_encode(
            [
                'server_id' => 'ABC',
                'version' => '2.0.4',
                'proto' => 1,
                'max_payload' => 123
            ]
        );

        $packetFactory = new InfoPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append("INFO {$infoPacketInformation}\r\n")
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

        $packetFactory = new InfoPacketFactory();

        $result = $packetFactory->tryToCreateFromBuffer(
            Buffer::emptyBuffer()->append('+OK')
        );

        $this->assertEquals($expectedResult, $result);
    }
}
