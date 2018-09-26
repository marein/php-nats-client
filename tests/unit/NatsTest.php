<?php
declare(strict_types=1);

namespace Marein\Nats;

use Marein\Nats\Connection\Socket;
use PHPUnit\Framework\TestCase;

class NatsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldPublishThePayloadOnTheGivenSubject(): void
    {
        $socket = $this->createMock(Socket::class);

        $socket
            ->expects($this->once())
            ->method('send')
            ->with("PUB subject 7\r\npayload\r\n");

        $nats = new Nats(
            $socket
        );

        $nats->publish('subject', 'payload');
    }
}
