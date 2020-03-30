<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Model;

final class Subject
{
    /**
     * @var string
     */
    private string $name;

    /**
     * Subject constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Create a random subject.
     *
     * @return Subject
     */
    public static function random(): Subject
    {
        return new Subject(bin2hex(random_bytes(10)));
    }

    /**
     * Return the name of the subject.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
