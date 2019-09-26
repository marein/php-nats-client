<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

final class Err implements Packet
{
    /**
     * @var string
     */
    private $message;

    /**
     * Err constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Returns the error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
