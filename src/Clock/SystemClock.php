<?php
declare(strict_types=1);

namespace Marein\Nats\Clock;

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
