<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

interface ConnectionFactory
{
    /**
     * Establishes a connection to the given socket.
     *
     * @param Socket $socket
     *
     * @return Connection
     */
    public function establish(Socket $socket): Connection;
}
