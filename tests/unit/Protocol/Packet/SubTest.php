<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;
use PHPUnit\Framework\TestCase;

class SubTest extends TestCase
{
    /**
     * @test
     * @dataProvider packetProvider
     */
    public function itShouldBePacked(Sub $sub, string $packed): void
    {
        $this->assertSame($packed, $sub->pack());
    }

    /**
     * @return array
     */
    public function packetProvider(): array
    {
        $subscriptionId = SubscriptionId::random();

        return [
            [
                (new Sub(new Subject('subject'), $subscriptionId)),
                'SUB subject ' . (string)$subscriptionId . "\r\n"
            ],
            [
                (new Sub(new Subject('subject'), $subscriptionId))->withQueueGroup('queueGroup'),
                'SUB subject queueGroup ' . (string)$subscriptionId . "\r\n"
            ]
        ];
    }
}
