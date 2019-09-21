<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Client;

use Marein\Nats\Protocol\Packet\Client\Pong;
use PHPUnit\Framework\TestCase;

class PongTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $pong = new Pong();

        $this->assertSame(
            "PONG\r\n",
            $pong->pack()
        );
    }
}
