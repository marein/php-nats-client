<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\ConnectionException;

interface Connection
{
    /**
     * Send the data over the wire.
     *
     * @param string $data
     *
     * @throws ConnectionException
     */
    public function send(string $data): void;

    /**
     * Receive data from the wire.
     *
     * @param Timeout $timeout
     *
     * @return string
     * @throws ConnectionException
     */
    public function receive(Timeout $timeout): string;
}
