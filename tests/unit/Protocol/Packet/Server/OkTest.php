<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

use PHPUnit\Framework\TestCase;

class OkTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $ok = new Ok();

        $this->assertSame(
            "+OK\r\n",
            $ok->pack()
        );
    }
}
