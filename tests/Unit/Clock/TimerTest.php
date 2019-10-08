<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection;

use Marein\Nats\Clock\Clock;
use Marein\Nats\Clock\Timer;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase
{
    /**
     * @test
     */
    public function itCountsDown(): void
    {
        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->exactly(5))
            ->method('timestamp')
            ->willReturnOnConsecutiveCalls(1000, 1000, 1002, 1008, 1030);

        $timer = new Timer(
            $clock,
            10
        );

        $this->assertSame(10, $timer->remaining());
        $this->assertSame(8, $timer->remaining());
        $this->assertSame(2, $timer->remaining());
        $this->assertSame(0, $timer->remaining());
    }

    /**
     * @test
     */
    public function itCanBeRestarted(): void
    {
        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->exactly(7))
            ->method('timestamp')
            ->willReturnOnConsecutiveCalls(1000, 1000, 1002, 1008, 1009, 1009, 1010);

        $timer = new Timer(
            $clock,
            10
        );

        $this->assertSame(10, $timer->remaining());
        $this->assertSame(8, $timer->remaining());
        $this->assertSame(2, $timer->remaining());

        $timer->restart();

        $this->assertSame(10, $timer->remaining());
        $this->assertSame(9, $timer->remaining());
    }
}
