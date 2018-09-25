<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Exception\InvalidPacketException;
use Marein\Nats\Protocol\Model\SubscriptionId;
use Marein\Nats\Protocol\Packet\Packet;

final class Unsub implements Packet
{
    /**
     * @var SubscriptionId
     */
    private $subscriptionId;

    /**
     * @var int|null
     */
    private $maximumNumberOfMessages;

    /**
     * Unsub constructor.
     *
     * @param SubscriptionId $subscriptionId
     */
    public function __construct(SubscriptionId $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * Add the queue group field for this packet.
     *
     * @param int $maximumNumberOfMessages
     *
     * @return Unsub
     * @throws InvalidPacketException
     */
    public function withMaximumNumberOfMessages(int $maximumNumberOfMessages): Unsub
    {
        if ($maximumNumberOfMessages <= 0) {
            throw new InvalidPacketException(
                'Maximum number of messages must be greate than 0.'
            );
        }

        $this->maximumNumberOfMessages = $maximumNumberOfMessages;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        $message = 'UNSUB ' . (string)$this->subscriptionId;

        if ($this->maximumNumberOfMessages !== null) {
            $message .= ' ' . (string)$this->maximumNumberOfMessages;
        }

        $message .= Packet::MESSAGE_TERMINATOR;

        return $message;
    }
}
