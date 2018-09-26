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
     */
    public function itShouldBePacked(): void
    {
        $subscriptionId = SubscriptionId::random();

        $sub = new Sub(
            new Subject('subject'),
            $subscriptionId
        );

        $this->assertSame(
            'SUB subject ' . (string)$subscriptionId . "\r\n",
            $sub->pack()
        );
    }

    /**
     * @test
     */
    public function itShouldBePackedWithQueueGroup(): void
    {
        $subscriptionId = SubscriptionId::random();

        $sub = new Sub(
            new Subject('subject'),
            $subscriptionId
        );
        $sub->withQueueGroup('queueGroup');

        $this->assertSame(
            'SUB subject queueGroup ' . (string)$subscriptionId . "\r\n",
            $sub->pack()
        );
    }
}
