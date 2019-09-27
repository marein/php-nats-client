<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Model;

use Marein\Nats\Protocol\Model\SubscriptionId;
use PHPUnit\Framework\TestCase;

class SubscriptionIdTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
    {
        $expectedValue = 'value';

        $subscriptionId = new SubscriptionId('value');

        $this->assertSame($expectedValue, (string)$subscriptionId);
    }

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
