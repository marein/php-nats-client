<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;
use Marein\Nats\Exception\ConnectionException;
use Marein\Nats\Protocol\Packet\Client\Connect;

final class PacketConnections
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @var int
     */
    private $timeoutInSeconds;

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
        $this->endpoint = $endpoint;
        $this->timeoutInSeconds = $timeoutInSeconds;
        $this->clock = $clock;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Returns a connection for publishing purposes.
     *
     * @return PacketConnection
     * @throws ConnectionException
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
            // todo: https://github.com/marein/php-nats-client/issues/3
            $this->forPublishing->receivePacket($this->timeoutInSeconds);
            $this->forPublishing->sendPacket(
                new Connect(
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
                )
            );
        }

        return $this->forPublishing;
    }
}
