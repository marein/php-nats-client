<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Client;

use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Packet\Client\Pub;
use PHPUnit\Framework\TestCase;

class PubTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $pub = new Pub(
            new Subject('subject'),
            'payload'
        );

        $this->assertSame(
            "PUB subject 7\r\npayload\r\n",
            $pub->pack()
        );
    }

    /**
     * @test
     */
    public function itShouldBePackedWithReplyTo(): void
    {
        $pub = new Pub(
            new Subject('subject'),
            'payload'
        );
        $pub->withReplyTo(new Subject('reply'));

        $this->assertSame(
            "PUB subject reply 7\r\npayload\r\n",
            $pub->pack()
        );
    }
}
