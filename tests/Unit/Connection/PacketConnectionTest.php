<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Clock\SystemClock;
use Marein\Nats\Connection\Connection;
use Marein\Nats\Connection\PacketConnection;
use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;
use Marein\Nats\Connection\Timeout;
use Marein\Nats\Exception\TimeoutExpiredException;
use Marein\Nats\Protocol\Packet\Client\Packet;
use Marein\Nats\Protocol\Packet\Server\Ok;
use PHPUnit\Framework\TestCase;

class PacketConnectionTest extends TestCase
{
    /**
     * @test
     */
    public function itCanSendPacket(): void
    {
        $packet = $this->createMock(Packet::class);
        $packet
            ->expects($this->once())
            ->method('pack')
            ->willReturn('test');

        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->once())
            ->method('send')
            ->with('test');

        $packetConnection = new PacketConnection(
            $connection,
            new CompositePacketFactory(),
            new SystemClock()
        );

        $packetConnection->sendPacket($packet);
    }

    /**
     * @test
     */
    public function itReceivesPacketWhileCallingConnectionMultipleTimes(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->exactly(3))
            ->method('receive')
            ->willReturnOnConsecutiveCalls('+O', 'K', "\r\n");

        $packetConnection = new PacketConnection(
            $connection,
            new CompositePacketFactory(),
            new SystemClock()
        );

        $packet = $packetConnection->receivePacket(Timeout::fromSeconds(10));

        $this->assertInstanceOf(Ok::class, $packet);
    }

    /**
     * @test
     */
    public function itStoresRemainingBuffer(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->exactly(2))
            ->method('receive')
            ->willReturnOnConsecutiveCalls("+OK\r\n+O", "K\r\n");

        $packetConnection = new PacketConnection(
            $connection,
            new CompositePacketFactory(),
            new SystemClock()
        );

        $firstPacket = $packetConnection->receivePacket(Timeout::fromSeconds(10));
        $secondPacket = $packetConnection->receivePacket(Timeout::fromSeconds(10));

        $this->assertInstanceOf(Ok::class, $firstPacket);
        $this->assertInstanceOf(Ok::class, $secondPacket);
    }

    /**
     * @test
     */
    public function itTriesToCreateFromInternalBufferWithoutCallingConnection(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->once())
            ->method('receive')
            ->willReturn("+OK\r\n+OK\r\n+OK\r\n");

        $packetConnection = new PacketConnection(
            $connection,
            new CompositePacketFactory(),
            new SystemClock()
        );

        $firstPacket = $packetConnection->receivePacket(Timeout::fromSeconds(10));
        $secondPacket = $packetConnection->receivePacket(Timeout::fromSeconds(10));
        $thirdPacket = $packetConnection->receivePacket(Timeout::fromSeconds(10));

        $this->assertInstanceOf(Ok::class, $firstPacket);
        $this->assertInstanceOf(Ok::class, $secondPacket);
        $this->assertInstanceOf(Ok::class, $thirdPacket);
    }

    /**
     * @test
     */
    public function itThrowsTimeoutExpiredException(): void
    {
        $this->expectException(TimeoutExpiredException::class);

        $connection = $this->createMock(Connection::class);

        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->exactly(5))
            ->method('timestamp')
            ->willReturnOnConsecutiveCalls(1000, 1000, 1004, 1009, 1010);

        $packetConnection = new PacketConnection(
            $connection,
            new CompositePacketFactory(),
            $clock
        );

        $packetConnection->receivePacket(Timeout::fromSeconds(10));
    }
}
