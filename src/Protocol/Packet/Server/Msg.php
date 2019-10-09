<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;

final class Msg implements Packet
{
    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var SubscriptionId
     */
    private $subscriptionId;

    /**
     * @var Subject|null
     */
    private $replyTo;

    /**
     * @var string
     */
    private $payload;

    /**
     * Msg constructor.
     *
     * @param Subject        $subject
     * @param SubscriptionId $subscriptionId
     * @param Subject|null   $replyTo
     * @param string         $payload
     */
    public function __construct(Subject $subject, SubscriptionId $subscriptionId, ?Subject $replyTo, string $payload)
    {
        $this->subject = $subject;
        $this->subscriptionId = $subscriptionId;
        $this->replyTo = $replyTo;
        $this->payload = $payload;
    }

    /**
     * Returns the subject to which this message was sent.
     *
     * @return Subject
     */
    public function subject(): Subject
    {
        return $this->subject;
    }

    /**
     * Returns the subscription id of the subject.
     *
     * @return SubscriptionId
     */
    public function subscriptionId(): SubscriptionId
    {
        return $this->subscriptionId;
    }

    /**
     * Returns the subject where someone is waiting for a response.
     *
     * @return Subject|null
     */
    public function replyTo(): ?Subject
    {
        return $this->replyTo;
    }

    /**
     * Returns the payload.
     *
     * @return string
     */
    public function payload(): string
    {
        return $this->payload;
    }

    /**
     * @inheritdoc
     */
    public function accept(PacketHandler $packetHandler): void
    {
        $packetHandler->handleMsg($this);
    }
}
