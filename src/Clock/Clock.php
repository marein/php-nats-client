<?php
declare(strict_types=1);

namespace Marein\Nats\Clock;

interface Clock
{
    /**
     * Returns the current timestamp.
     *
     * @return int
     */
    public function timestamp(): int;
}
