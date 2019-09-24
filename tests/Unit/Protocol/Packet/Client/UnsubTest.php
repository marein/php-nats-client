<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Client;

use Marein\Nats\Exception\InvalidPacketException;
use Marein\Nats\Protocol\Model\SubscriptionId;
use Marein\Nats\Protocol\Packet\Client\Unsub;
use PHPUnit\Framework\TestCase;

class UnsubTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $subscriptionId = SubscriptionId::random();

        $unsub = new Unsub(
            $subscriptionId
        );

        $this->assertSame(
            'UNSUB ' . (string)$subscriptionId . "\r\n",
            $unsub->pack()
        );
    }

    /**
     * @test
     */
    public function itShouldBePackedWithMaximumNumberOfMessages(): void
    {
        $subscriptionId = SubscriptionId::random();

        $unsub = new Unsub(
            $subscriptionId
        );
        $unsub->withMaximumNumberOfMessages(3);

        $this->assertSame(
            'UNSUB ' . (string)$subscriptionId . " 3\r\n",
            $unsub->pack()
        );
    }

    /**
     * @test
     */
    public function maximumNumberOfMessagesShouldBeGreaterThanNull(): void
    {
        $this->expectException(InvalidPacketException::class);

        $unsub = new Unsub(
            SubscriptionId::random()
        );
        $unsub->withMaximumNumberOfMessages(0);
    }
}
