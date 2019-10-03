<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;
use Marein\Nats\Exception\ConnectionException;
use Marein\Nats\Exception\TimeoutExpiredException;

final class PacketConnections
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @var Timeout
     */
    private $timeout;

    /**
     * @var Clock
     */
    private $clock;

    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var PacketConnection|null
     */
    private $forPublishing;

    /**
     * PacketConnections constructor.
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
        $this->endpoint = $endpoint;
        $this->timeout = $timeout;
        $this->clock = $clock;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Returns a connection for publishing purposes.
     *
     * @return PacketConnection
     * @throws ConnectionException
     * @throws TimeoutExpiredException
     */
    public function forPublishing(): PacketConnection
    {
        if (!$this->forPublishing) {
            $this->forPublishing = new PacketConnection(
                $this->connectionFactory->establish($this->endpoint),
                new CompositePacketFactory(),
                $this->clock
            );
            // Receive the info packet.
            $this->forPublishing->receivePacket($this->timeout);
        }

        return $this->forPublishing;
    }
}
