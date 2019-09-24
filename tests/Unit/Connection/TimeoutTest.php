<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection;

use Marein\Nats\Connection\Timeout;
use Marein\Nats\Exception\TimeoutExpiredException;
use PHPUnit\Framework\TestCase;

class TimeoutTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedSeconds = 3;

        $timout = Timeout::fromSeconds($expectedSeconds);

        $this->assertSame($expectedSeconds, $timout->inSeconds());
    }

    /**
     * @test
     */
    public function itCanSubtractTime(): void
    {
        $timout = Timeout::fromSeconds(3)->subtract(2);

        $this->assertSame(1, $timout->inSeconds());
    }

    /**
     * @test
     */
    public function itThrowsTimeoutExpiredExceptionOnFromSeconds(): void
    {
        $this->expectException(TimeoutExpiredException::class);

        Timeout::fromSeconds(-1);
    }

    /**
     * @test
     */
    public function itThrowsTimeoutExpiredExceptionOnSubtract(): void
    {
        $this->expectException(TimeoutExpiredException::class);

        Timeout::fromSeconds(3)->subtract(3);
    }
}
