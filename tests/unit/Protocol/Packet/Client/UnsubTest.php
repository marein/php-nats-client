<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Exception\InvalidPacketException;
use Marein\Nats\Protocol\Model\SubscriptionId;
use PHPUnit\Framework\TestCase;

class UnsubTest extends TestCase
{
    /**
     * @test
     * @dataProvider packetProvider
     */
    public function itShouldBePacked(Unsub $unsub, string $packed): void
    {
        $this->assertSame($packed, $unsub->pack());
    }

    /**
     * @test
     */
    public function maximumNumberOfMessagesShouldBeGreaterThanNull(): void
    {
        $this->expectException(InvalidPacketException::class);

        (new Unsub(SubscriptionId::random()))->withMaximumNumberOfMessages(0);
    }

    /**
     * @return array
     */
    public function packetProvider(): array
    {
        $subscriptionId = SubscriptionId::random();

        return [
            [
                (new Unsub($subscriptionId)),
                'UNSUB ' . (string)$subscriptionId . "\r\n"
            ],
            [
                (new Unsub($subscriptionId))->withMaximumNumberOfMessages(3),
                'UNSUB ' . (string)$subscriptionId . " 3\r\n"
            ]
        ];
    }
}
