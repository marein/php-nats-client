<?php
declare(strict_types=1);

namespace Marein\Nats\Connection;

final class Buffer
{
    /**
     * @var string
     */
    private $value;

    /**
     * Buffer constructor.
     *
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Returns an empty buffer.
     *
     * @return Buffer
     */
    public static function emptyBuffer(): Buffer
    {
        return new Buffer('');
    }

    /**
     * Returns true if there's an occurrence.
     *
     * @param string $value
     *
     * @return bool
     */
    public function canReadUntilAfterNextOccurrence(string $value): bool
    {
        return strpos($this->value, $value) !== false;
    }

    /**
     * Returns a new buffer with characters until after the next occurrence.
     *
     * @param string $value
     *
     * @return Buffer
     */
    public function readUntilAfterNextOccurrence(string $value): Buffer
    {
        return new Buffer(
            substr($this->value, 0, strpos($this->value, $value) + strlen($value))
        );
    }

    /**
     * Returns true if there're enough characters.
     *
     * @param int $position
     *
     * @return bool
     */
    public function canReadUpToPosition(int $position): bool
    {
        return $this->length() >= $position;
    }

    /**
     * Returns a new buffer with characters up to this position.
     *
     * @param int $position
     *
     * @return Buffer
     */
    public function readUpToPosition(int $position): Buffer
    {
        return new Buffer(
            substr($this->value, 0, $position)
        );
    }

    /**
     * Returns true if the buffer starts with the value.
     *
     * @param string $value
     *
     * @return bool
     */
    public function startsWith(string $value): bool
    {
        return strpos($this->value, $value) === 0;
    }

    /**
     * Returns a new buffer with the added string.
     *
     * @param string $value
     *
     * @return Buffer
     */
    public function append(string $value): Buffer
    {
        return new Buffer($this->value . $value);
    }

    /**
     * Removes the characters up to this position.
     *
     * @param int $position
     *
     * @return Buffer
     */
    public function removeUpToPosition(int $position): Buffer
    {
        return new Buffer(
            substr($this->value, $position)
        );
    }

    /**
     * Returns true if the buffer is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->value === '';
    }

    /**
     * Returns the value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Returns the length of the buffer.
     *
     * @return int
     */
    public function length(): int
    {
        return strlen($this->value);
    }
}
