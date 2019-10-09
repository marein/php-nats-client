<?php
declare(strict_types=1);

namespace Marein\Nats\Integration;

use Marein\Nats\Clock\Clock;

final class SystemClock implements Clock
{
    /**
     * @inheritdoc
     */
    public function timestamp(): int
    {
        return time();
    }
}
