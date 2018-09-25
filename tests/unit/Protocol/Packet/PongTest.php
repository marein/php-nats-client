<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use PHPUnit\Framework\TestCase;

class PongTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $this->assertSame("PONG\r\n", (new Pong)->pack());
    }
}
