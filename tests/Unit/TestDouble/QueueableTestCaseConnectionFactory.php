<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\TestDouble;

use Marein\Nats\Connection\Connection;
use Marein\Nats\Connection\ConnectionFactory;
use Marein\Nats\Connection\Endpoint;
use Marein\Nats\Exception\ConnectionException;
use PHPUnit\Framework\TestCase;

final class QueueableTestCaseConnectionFactory implements ConnectionFactory
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var QueueableTestCaseConnection
     */
    private $connection;

    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * Connection constructor.
     *
     * @param TestCase                    $testCase
     * @param Endpoint                    $endpoint
     * @param QueueableTestCaseConnection $connection
     */
    public function __construct(
        TestCase $testCase,
        Endpoint $endpoint,
        QueueableTestCaseConnection $connection
    ) {
        $this->testCase = $testCase;
        $this->endpoint = $endpoint;
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function establish(Endpoint $endpoint): Connection
    {
        $this->testCase::assertSame($this->endpoint, $endpoint);

        return $this->connection;
    }
}
