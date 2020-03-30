<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

final class Info implements Packet
{
    /**
     * @var string
     */
    private string $serverId;

    /**
     * @var string
     */
    private string $version;

    /**
     * @var int
     */
    private int $protocol;

    /**
     * @var int
     */
    private int $payloadLimit;

    /**
     * @var bool
     */
    private bool $isAuthenticationRequired;

    /**
     * @var bool
     */
    private bool $isTlsRequired;

    /**
     * @var bool
     */
    private bool $mustProvideTlsCertificate;

    /**
     * Info constructor.
     *
     * @param string $serverId
     * @param string $version
     * @param int    $protocol
     * @param int    $payloadLimit
     * @param bool   $isAuthenticationRequired
     * @param bool   $isTlsRequired
     * @param bool   $mustProvideTlsCertificate
     */
    public function __construct(
        string $serverId,
        string $version,
        int $protocol,
        int $payloadLimit,
        bool $isAuthenticationRequired,
        bool $isTlsRequired,
        bool $mustProvideTlsCertificate
    ) {
        $this->serverId = $serverId;
        $this->version = $version;
        $this->protocol = $protocol;
        $this->payloadLimit = $payloadLimit;
        $this->isAuthenticationRequired = $isAuthenticationRequired;
        $this->isTlsRequired = $isTlsRequired;
        $this->mustProvideTlsCertificate = $mustProvideTlsCertificate;
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
     * Returns true if authentication is required.
     *
     * @return bool
     */
    public function isAuthenticationRequired(): bool
    {
        return $this->isAuthenticationRequired;
    }

    /**
     * Returns true if tls is required.
     *
     * @return bool
     */
    public function isTlsRequired(): bool
    {
        return $this->isTlsRequired;
    }

    /**
     * Returns true if the server needs a client certificate.
     *
     * @return bool
     */
    public function mustProvideTlsCertificate(): bool
    {
        return $this->mustProvideTlsCertificate;
    }

    /**
     * @inheritdoc
     */
    public function accept(PacketHandler $packetHandler): void
    {
        $packetHandler->handleInfo($this);
    }
}
