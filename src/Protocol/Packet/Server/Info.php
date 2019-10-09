<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

final class Info implements Packet
{
    /**
     * @var string
     */
    private $serverId;

    /**
     * @var string
     */
    private $version;

    /**
     * @var int
     */
    private $protocol;

    /**
     * @var int
     */
    private $payloadLimit;

    /**
     * Info constructor.
     *
     * @param string $serverId
     * @param string $version
     * @param int    $protocol
     * @param int    $payloadLimit
     */
    public function __construct(string $serverId, string $version, int $protocol, int $payloadLimit)
    {
        $this->serverId = $serverId;
        $this->version = $version;
        $this->protocol = $protocol;
        $this->payloadLimit = $payloadLimit;
    }

    /**
     * Returns the unique identifier of the nats server.
     *
     * @return string
     */
    public function serverId(): string
    {
        return $this->serverId;
    }

    /**
     * Returns the version of the nats server.
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Returns the protocol version of the nats server.
     *
     * @return int
     */
    public function protocol(): int
    {
        return $this->protocol;
    }

    /**
     * Returns the payload limit that the nats server will accept.
     *
     * @return int
     */
    public function payloadLimit(): int
    {
        return $this->payloadLimit;
    }

    /**
     * @inheritdoc
     */
    public function accept(PacketHandler $packetHandler): void
    {
        $packetHandler->handleInfo($this);
    }
}
