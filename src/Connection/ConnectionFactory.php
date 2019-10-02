<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\ConnectionException;

interface ConnectionFactory
{
    /**
     * Establishes a connection to the given socket.
     *
     * @param Socket $socket
     *
     * @return Connection
     * @throws ConnectionException
     */
    public function establish(Socket $socket): Connection;
}
