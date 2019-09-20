<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\ConnectionLostException;

interface Connection
{
    /**
     * Send the data over the wire.
     *
     * @param string $data
     *
     * @throws ConnectionLostException
     */
    public function send(string $data): void;

    /**
     * Receive data from the wire.
     *
     * @return string
     * @throws ConnectionLostException
     */
    public function receive(): string;
}
