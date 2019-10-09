<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;
use Marein\Nats\Protocol\Packet\Server\Msg;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
use PHPUnit\Framework\TestCase;

class MsgTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedSubject = Subject::random();
        $expectedSubscriptionId = SubscriptionId::random();
        $expectedPayload = 'payload';
        $expectedReplyTo = null;

        $msg = new Msg(
            $expectedSubject,
            $expectedSubscriptionId,
            $expectedReplyTo,
            $expectedPayload
        );

        $this->assertSame($expectedSubject, $msg->subject());
        $this->assertSame($expectedSubscriptionId, $msg->subscriptionId());
        $this->assertSame($expectedReplyTo, $msg->replyTo());
        $this->assertSame($expectedPayload, $msg->payload());
    }

    /**
     * @test
     */
    public function itCanBeCreatedWithReplyTo(): void
    {
        $expectedSubject = Subject::random();
        $expectedSubscriptionId = SubscriptionId::random();
        $expectedPayload = 'payload';
        $expectedReplyTo = Subject::random();

        $msg = new Msg(
            $expectedSubject,
            $expectedSubscriptionId,
            $expectedReplyTo,
            $expectedPayload
        );

        $this->assertSame($expectedSubject, $msg->subject());
        $this->assertSame($expectedSubscriptionId, $msg->subscriptionId());
        $this->assertSame($expectedReplyTo, $msg->replyTo());
        $this->assertSame($expectedPayload, $msg->payload());
    }

    /**
     * @test
     */
    public function itIsCallingBackPacketHandler(): void
    {
        $msg = new Msg(
            new Subject('subject'),
            new SubscriptionId('subscriptionId'),
            null,
            'payload'
        );

        $packetHandler = $this->createMock(PacketHandler::class);
        $packetHandler
            ->expects($this->once())
            ->method('handleMsg')
            ->with($msg);

        $msg->accept($packetHandler);
    }
}
