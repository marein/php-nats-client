<?php
declare(strict_types=1);

namespace Marein\Nats;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Connection\PacketConnections;
use Marein\Nats\Connection\Timeout;
use Marein\Nats\Exception\ConnectionException;
use Marein\Nats\Exception\TimeoutExpiredException;
use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Pub;

final class Nats
{
    /**
     * @var PacketConnections
     */
    private $packetConnections;

    /**
     * @var Timeout
     */
    private $timeout;

    /**
     * Nats constructor.
     *
     * @param Endpoint          $endpoint
     * @param Timeout           $timeout
     * @param Clock             $clock
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(
        Endpoint $endpoint,
        Timeout $timeout,
        Clock $clock,
        ConnectionFactory $connectionFactory
    ) {
        $this->timeout = $timeout;
        $this->packetConnections = new PacketConnections(
            $endpoint,
            $timeout,
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
     * @throws TimeoutExpiredException
     */
    public function publish(string $subject, string $payload): void
    {
        $this->packetConnections->forPublishing()->sendPacket(
            new Pub(
                new Subject($subject),
                $payload
            )
        );

        // todo: https://github.com/marein/php-nats-client/issues/3
        $this->packetConnections->forPublishing()->receivePacket($this->timeout);
    }
}
