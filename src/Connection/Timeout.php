<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

use Marein\Nats\Exception\TimeoutExpiredException;

final class Timeout
{
    /**
     * @var int
     */
    private $seconds;

    /**
     * Timeout constructor.
     *
     * @param int $seconds
     *
     * @throws TimeoutExpiredException
     */
    private function __construct(int $seconds)
    {
        if ($seconds < 1) {
            throw new TimeoutExpiredException();
        }

        $this->seconds = $seconds;
    }

    /**
     * Create timeout from seconds.
     *
     * @param int $seconds
     *
     * @return Timeout
     * @throws TimeoutExpiredException
     */
    public static function fromSeconds(int $seconds): Timeout
    {
        return new Timeout($seconds);
    }

    /**
     * Subtract the seconds from the timeout.
     *
     * @param int $seconds
     *
     * @return Timeout
     * @throws TimeoutExpiredException
     */
    public function subtract(int $seconds): Timeout
    {
        return new Timeout($this->seconds - $seconds);
    }

    /**
     * Returns the amount of time in seconds.
     *
     * @return int
     */
    public function inSeconds(): int
    {
        return $this->seconds;
    }
}
