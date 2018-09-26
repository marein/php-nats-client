<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\SocketException;

interface Socket
{
    /**
     * Send the message over the wire.
     *
     * @param string $message
     *
     * @throws SocketException
     */
    public function send(string $message): void;
}
