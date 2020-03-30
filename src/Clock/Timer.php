<?php
declare(strict_types=1);

namespace Marein\Nats\Clock;

final class Timer
{
    /**
     * @var Clock
     */
    private Clock $clock;

    /**
     * @var int
     */
    private int $seconds;

    /**
     * @var int
     */
    private int $expiresAt;

    /**
     * Timer constructor.
     *
     * @param Clock $clock
     * @param int   $seconds
     */
    public function __construct(Clock $clock, int $seconds)
    {
        $this->clock = $clock;
        $this->seconds = $seconds;
        $this->restart();
    }

    /**
     * Returns the remaining time.
     *
     * @return int
     */
    public function remaining(): int
    {
        return max(
            0,
            $this->expiresAt - $this->clock->timestamp()
        );
    }

    /**
     * Restarts the timer.
     */
    public function restart(): void
    {
        $this->expiresAt = $this->clock->timestamp() + $this->seconds;
    }
}
