<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

final class Socket
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * Socket constructor.
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
