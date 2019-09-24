<?php
declare(strict_types=1);

namespace Marein\Nats\Clock;

use Marein\Nats\Exception\ConnectionLostException;

interface Clock
{
    /**
     * Returns the current timestamp.
     *
     * @return int
     */
    public function timestamp(): int;
}
