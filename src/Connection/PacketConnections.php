<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Connection\PacketFactory\CompositePacketFactory;
use Marein\Nats\Exception\ConnectionLostException;

final class PacketConnections
{
    /**
     * @var Socket
     */
    private $socket;

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
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(Socket $socket, ConnectionFactory $connectionFactory)
    {
        $this->socket = $socket;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Returns a connection for publishing purposes.
     *
     * @return PacketConnection
     * @throws ConnectionLostException
     */
    public function forPublishing(): PacketConnection
    {
        if (!$this->forPublishing) {
            $this->forPublishing = new PacketConnection(
                $this->connectionFactory->establish($this->socket),
                new CompositePacketFactory()
            );
            // Receive the info packet.
            $this->forPublishing->receivePacket();
        }

        return $this->forPublishing;
    }
}
