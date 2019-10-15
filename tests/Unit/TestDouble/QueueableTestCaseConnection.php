<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\TestDouble;

use Marein\Nats\Connection\Connection;
use PHPUnit\Framework\TestCase;

final class QueueableTestCaseConnection implements Connection
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var \SplQueue
     */
    private $sendQueue;

    /**
     * @var \SplQueue
     */
    private $receiveQueue;

    /**
     * Connection constructor.
     *
     * @param TestCase $testCase
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
        $this->sendQueue = new \SplQueue();
        $this->receiveQueue = new \SplQueue();
    }

    /**
     * @inheritdoc
     */
    public function send(string $data): void
    {
        $this->testCase::assertFalse(
            $this->sendQueue->isEmpty(),
            'Connection sendQueue is empty but "' . $data . '" should be sent.'
        );

        $this->testCase::assertSame(
            $data,
            $this->sendQueue->dequeue()
        );
    }

    /**
     * @inheritdoc
     */
    public function receive(int $timeoutInSeconds): string
    {
        $this->testCase::assertFalse(
            $this->receiveQueue->isEmpty(),
            'Connection receiveQueue is empty but data has been requested.'
        );

        [$actualData, $actualTimeoutInSeconds] = $this->receiveQueue->dequeue();

        $this->testCase::assertSame($actualTimeoutInSeconds, $timeoutInSeconds);

        return $actualData;
    }

    /**
     * Enqueue expected data.
     *
     * @param string $data
     */
    public function enqueueSend(string $data): void
    {
        $this->sendQueue->enqueue($data);
    }

    /**
     * Enqueue expected data and a timeout.
     *
     * @param string $data
     * @param int $timeoutInSeconds
     */
    public function enqueueReceive(string $data, int $timeoutInSeconds): void
    {
        $this->receiveQueue->enqueue([$data, $timeoutInSeconds]);
    }

    /**
     * Assert that the queues are empty.
     */
    public function assertEmptyQueues(): void
    {
        $this->testCase::assertTrue(
            $this->sendQueue->isEmpty(),
            'Connection sendQueue is not empty.' . PHP_EOL .
            var_export(iterator_to_array($this->sendQueue), true)
        );
        $this->testCase::assertTrue(
            $this->receiveQueue->isEmpty(),
            'Connection receiveQueue is not empty.' . PHP_EOL .
            var_export(iterator_to_array($this->receiveQueue), true)
        );
    }
}
