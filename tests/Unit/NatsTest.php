<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit;

use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Integration\SystemClock;
use Marein\Nats\Nats;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Connect;
use Marein\Nats\Protocol\Packet\Client\Ping;
use Marein\Nats\Protocol\Packet\Client\Pub;
use Marein\Nats\Tests\Unit\TestDouble\QueueableTestCaseConnection;
use Marein\Nats\Tests\Unit\TestDouble\QueueableTestCaseConnectionFactory;
use PHPUnit\Framework\TestCase;

class NatsTest extends TestCase
{
    private const TIMEOUT_IN_SECONDS = 10;

    /**
     * @var QueueableTestCaseConnection
     */
    private $connection;

    /**
     * @var Nats
     */
    private $nats;

    /**
     * Setup a working connection and a working nats instance.
     */
    protected function setUp(): void
    {
        $expectedEndpoint = new Endpoint('127.0.0.1', 4222);
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

        $this->connection = new QueueableTestCaseConnection($this);
        $this->nats = new Nats(
            $expectedEndpoint,
            self::TIMEOUT_IN_SECONDS,
            new SystemClock(),
            new QueueableTestCaseConnectionFactory(
                $this,
                $expectedEndpoint,
                $this->connection
            )
        );

        $this->connection->enqueueSend($expectedConnectPacket->pack());
        $this->connection->enqueueReceive(
            'INFO ' . json_encode($expectedInfoPacketInformation) . "\r\n",
            self::TIMEOUT_IN_SECONDS
        );
    }

    /**
     * Assert that connection queues are empty.
     */
    public function tearDown(): void
    {
        $this->connection->assertEmptyQueues();
    }

    /**
     * @test
     */
    public function itShouldPublishThePayloadOnTheGivenSubject(): void
    {
        $expectedPubPacket = new Pub(
            new Subject('subject'),
            'payload'
        );

        $this->connection->enqueueSend($expectedPubPacket->pack());

        $this->nats->publish('subject', 'payload');
    }

    /**
     * @test
     */
    public function itShouldFlush(): void
    {
        $this->connection->enqueueSend((new Ping())->pack());
        $this->connection->enqueueReceive("PONG\r\n", 10);

        $this->nats->flush();
    }
}
