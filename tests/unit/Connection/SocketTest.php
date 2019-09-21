<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection;

use Marein\Nats\Connection\Socket;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedHost = '127.0.0.1';
        $expectedPort = 4222;

        $socket = new Socket($expectedHost, $expectedPort);

        $this->assertSame($expectedHost, $socket->host());
        $this->assertSame($expectedPort, $socket->port());
    }
}
