<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Protocol\Model\Subject;
use PHPUnit\Framework\TestCase;

class PubTest extends TestCase
{
    /**
     * @test
     * @dataProvider packetProvider
     */
    public function itShouldBePacked(Pub $pub, string $packed): void
    {
        $this->assertSame($packed, $pub->pack());
    }

    /**
     * @return array
     */
    public function packetProvider(): array
    {
        return [
            [
                (new Pub(new Subject('subject'), 'payload')),
                "PUB subject 7\r\npayload\r\n"
            ],
            [
                (new Pub(new Subject('subject'), 'payload'))->withReplyTo(new Subject('reply')),
                "PUB subject reply 7\r\npayload\r\n"
            ]
        ];
    }
}
