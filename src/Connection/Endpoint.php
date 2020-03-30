<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

final class Endpoint
{
    /**
     * @var string
     */
    private string $host;

    /**
     * @var int
     */
    private int $port;

    /**
     * Endpoint constructor.
     *
     * @param string $host
     * @param int    $port
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Returns the host.
     *
     * @return string
     */
    public function host(): string
    {
        return $this->host;
    }

    /**
     * Returns the port.
     *
     * @return int
     */
    public function port(): int
    {
        return $this->port;
    }
}
