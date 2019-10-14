<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit;

use Marein\Nats\Connection\Connection;
use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Integration\SystemClock;
use Marein\Nats\Nats;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Connect;
use Marein\Nats\Protocol\Packet\Client\Pub;
use PHPUnit\Framework\TestCase;

class NatsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldPublishThePayloadOnTheGivenSubject(): void
    {
        $endpoint = new Endpoint('127.0.0.1', 4222);
        $expectedInfoPacketInformation = [
            'server_id' => 'test',
            'max_payload' => 1233,
            'proto' => 1,
            'version' => '2.0.4'
        ];
        $expectedConnectPacket = new Connect(
            false,
            false,
            false,
            null,
            null,
            null,
            'marein/php-nats-client',
            'php',
            '0.0.0',
            0,
            false
        );
        $expectedPubPacket = new Pub(
            new Subject('subject'),
            'payload'
        );

        $connection = $this->createMock(Connection::class);
        $connection
            ->expects($this->exactly(2))
            ->method('send')
            ->withConsecutive(
                [$expectedConnectPacket->pack()],
                [$expectedPubPacket->pack()]
            );
        $connection
            ->expects($this->once())
            ->method('receive')
            ->willReturn('INFO ' . json_encode($expectedInfoPacketInformation) . "\r\n");

        $connectionFactory = $this->createMock(ConnectionFactory::class);
        $connectionFactory
            ->expects($this->once())
            ->method('establish')
            ->with($endpoint)
            ->willReturn($connection);

        $nats = new Nats(
            $endpoint,
            10,
            new SystemClock(),
            $connectionFactory
        );

        $nats->publish('subject', 'payload');
    }
}
