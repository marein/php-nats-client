<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Connection;

use Marein\Nats\Connection\Endpoint;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedHost = '127.0.0.1';
        $expectedPort = 4222;

        $endpoint = new Endpoint($expectedHost, $expectedPort);

        $this->assertSame($expectedHost, $endpoint->host());
        $this->assertSame($expectedPort, $endpoint->port());
    }
}
