<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Err;
use PHPUnit\Framework\TestCase;

class ErrTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedMessage = 'Error Message';

        $err = new Err($expectedMessage);

        $this->assertSame($expectedMessage, $err->message());
    }
}
