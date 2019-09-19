<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

use Marein\Nats\Protocol\Model\Subject;

final class Pub implements Packet
{
    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var int
     */
    private $payloadLength;

    /**
     * @var Subject|null
     */
    private $replyTo;

    /**
     * Pub constructor.
     *
     * @param Subject $subject
     * @param string  $payload
     */
    public function __construct(Subject $subject, string $payload)
    {
        $this->subject = $subject;
        $this->payload = $payload;
        $this->payloadLength = strlen($payload);
    }

    /**
     * Add the reply to field for this packet.
     *
     * @param Subject $subject
     *
     * @return Pub
     */
    public function withReplyTo(Subject $subject): Pub
    {
        $this->replyTo = $subject;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        $message = 'PUB ' . (string)$this->subject;

        if ($this->replyTo !== null) {
            $message .= ' ' . (string)$this->replyTo;
        }

        $message .= sprintf(
            ' %s%s%s%s',
            (string)$this->payloadLength,
            Packet::MESSAGE_TERMINATOR,
            $this->payload,
            Packet::MESSAGE_TERMINATOR
        );

        return $message;
    }
}
