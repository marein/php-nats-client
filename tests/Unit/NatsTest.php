<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit;

use Marein\Nats\Clock\SystemClock;
use Marein\Nats\Connection\Connection;
use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Connection\Timeout;
use Marein\Nats\Nats;
use PHPUnit\Framework\TestCase;

class NatsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldPublishThePayloadOnTheGivenSubject(): void
    {
        $endpoint = new Endpoint('127.0.0.1', 4222);
        $infoPacketInformation = [
            'server_id' => 'test',
            'max_payload' => 1233,
            'proto' => 1,
            'version' => '2.0.4'
        ];

        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->once())
            ->method('send')
            ->with("PUB subject 7\r\npayload\r\n");
        $connection
            ->expects($this->exactly(2))
            ->method('receive')
            ->willReturnOnConsecutiveCalls('INFO ' . json_encode($infoPacketInformation) . "\r\n", "+OK\r\n");

        $connectionFactory = $this->createMock(ConnectionFactory::class);
        $connectionFactory
            ->expects($this->once())
            ->method('establish')
            ->with($endpoint)
            ->willReturn($connection);

        $nats = new Nats(
            $endpoint,
            Timeout::fromSeconds(10),
            new SystemClock(),
            $connectionFactory
        );

        $nats->publish('subject', 'payload');
    }
}
