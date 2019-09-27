<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Model;

final class SubscriptionId
{
    /**
     * @var string
     */
    private $value;

    /**
     * SubscriptionId constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Create a random subscription id.
     *
     * @return SubscriptionId
     */
    public static function random(): SubscriptionId
    {
        return new SubscriptionId(bin2hex(random_bytes(10)));
    }

    /**
     * Return the subscription id as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
