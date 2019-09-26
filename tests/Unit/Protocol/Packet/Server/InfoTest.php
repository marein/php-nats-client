<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Info;
use PHPUnit\Framework\TestCase;

class InfoTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $expectedServerId = 'FADC3O3PGSL7';
        $expectedVersion = '2.0.4';
        $expectedProtocol = 1;
        $expectedPayloadLimit = 1048576;

        $info = new Info(
            $expectedServerId,
            $expectedVersion,
            $expectedProtocol,
            $expectedPayloadLimit
        );

        $this->assertSame($expectedServerId, $info->serverId());
        $this->assertSame($expectedVersion, $info->version());
        $this->assertSame($expectedProtocol, $info->protocol());
        $this->assertSame($expectedPayloadLimit, $info->payloadLimit());
    }
}
