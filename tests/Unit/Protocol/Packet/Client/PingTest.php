<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Client;

use Marein\Nats\Protocol\Packet\Client\Ping;
use PHPUnit\Framework\TestCase;

class PingTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $ping = new Ping();

        $this->assertSame(
            "PING\r\n",
            $ping->pack()
        );
    }
}
