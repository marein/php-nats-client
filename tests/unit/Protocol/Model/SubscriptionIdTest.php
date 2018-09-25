<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Model;

use PHPUnit\Framework\TestCase;

class SubscriptionIdTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedRandomly(): void
    {
        $subscriptionIdOne = SubscriptionId::random();
        $subscriptionIdTwo = SubscriptionId::random();

        $this->assertNotSame((string)$subscriptionIdOne, (string)$subscriptionIdTwo);
    }
}
