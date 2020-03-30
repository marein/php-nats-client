<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Protocol\Model\Subject;
use Marein\Nats\Protocol\Model\SubscriptionId;

final class Sub implements Packet
{
    /**
     * @var Subject
     */
    private Subject $subject;

    /**
     * @var SubscriptionId
     */
    private SubscriptionId $subscriptionId;

    /**
     * @var string|null
     */
    private ?string $queueGroup;

    /**
     * Sub constructor.
     *
     * @param Subject        $subject
     * @param SubscriptionId $subscriptionId
     */
    public function __construct(Subject $subject, SubscriptionId $subscriptionId)
    {
        $this->subject = $subject;
        $this->subscriptionId = $subscriptionId;
        $this->queueGroup = null;
    }

    /**
     * Add the queue group field for this packet.
     *
     * @param string $queueGroup
     *
     * @return Sub
     */
    public function withQueueGroup(string $queueGroup): Sub
    {
        $this->queueGroup = $queueGroup;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        $message = 'SUB ' . (string)$this->subject;

        if ($this->queueGroup !== null) {
            $message .= ' ' . $this->queueGroup;
        }

        $message .= ' ' . (string)$this->subscriptionId . Packet::MESSAGE_TERMINATOR;

        return $message;
    }
}
