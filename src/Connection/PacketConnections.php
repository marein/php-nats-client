<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;
use Marein\Nats\Exception\ConnectionLostException;
use Marein\Nats\Exception\TimeoutExpiredException;

final class PacketConnections
{
    /**
     * @var Socket
     */
    private $socket;

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
     * @param Socket            $socket
     * @param Timeout           $timeout
     * @param Clock             $clock
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(
        Socket $socket,
        Timeout $timeout,
        Clock $clock,
        ConnectionFactory $connectionFactory
    ) {
        $this->socket = $socket;
        $this->timeout = $timeout;
        $this->clock = $clock;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Returns a connection for publishing purposes.
     *
     * @return PacketConnection
     * @throws ConnectionLostException
     * @throws TimeoutExpiredException
     */
    public function forPublishing(): PacketConnection
    {
        if (!$this->forPublishing) {
            $this->forPublishing = new PacketConnection(
                $this->connectionFactory->establish($this->socket),
                new CompositePacketFactory(),
                $this->clock
            );
            // Receive the info packet.
            $this->forPublishing->receivePacket($this->timeout);
        }

        return $this->forPublishing;
    }
}
