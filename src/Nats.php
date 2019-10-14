<?php
declare(strict_types=1);

namespace Marein\Nats;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Connection\PacketConnections;
use Marein\Nats\Exception\ConnectionException;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Pub;

final class Nats
{
    /**
     * @var PacketConnections
     */
    private $packetConnections;

    /**
     * @var int
     */
    private $timeoutInSeconds;

    /**
     * Nats constructor.
     *
     * @param Endpoint          $endpoint
     * @param int               $timeoutInSeconds
     * @param Clock             $clock
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(
        Endpoint $endpoint,
        int $timeoutInSeconds,
        Clock $clock,
        ConnectionFactory $connectionFactory
    ) {
        $this->timeoutInSeconds = $timeoutInSeconds;
        $this->packetConnections = new PacketConnections(
            $endpoint,
            $timeoutInSeconds,
            $clock,
            $connectionFactory
        );
    }

    /**
     * Publish the payload on the given subject.
     *
     * @param string $subject
     * @param string $payload
     *
     * @throws ConnectionException
     */
    public function publish(string $subject, string $payload): void
    {
        $this->packetConnections->forPublishing()->sendPacket(
            new Pub(
                new Subject($subject),
                $payload
            )
        );
    }
}
