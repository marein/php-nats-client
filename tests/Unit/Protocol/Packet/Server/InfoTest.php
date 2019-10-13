<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Server;

use Marein\Nats\Protocol\Packet\Server\Info;
use Marein\Nats\Protocol\Packet\Server\PacketHandler;
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
        $expectedIsAuthenticationRequired = true;
        $expectedIsTlsRequired = true;
        $expectedMustProvideTlsCertificate = true;

        $info = new Info(
            $expectedServerId,
            $expectedVersion,
            $expectedProtocol,
            $expectedPayloadLimit,
            $expectedIsAuthenticationRequired,
            $expectedIsTlsRequired,
            $expectedMustProvideTlsCertificate
        );

        $this->assertSame($expectedServerId, $info->serverId());
        $this->assertSame($expectedVersion, $info->version());
        $this->assertSame($expectedProtocol, $info->protocol());
        $this->assertSame($expectedPayloadLimit, $info->payloadLimit());
        $this->assertSame($expectedIsAuthenticationRequired, $info->isAuthenticationRequired());
        $this->assertSame($expectedIsTlsRequired, $info->isTlsRequired());
        $this->assertSame($expectedMustProvideTlsCertificate, $info->mustProvideTlsCertificate());
    }

    /**
     * @test
     */
    public function itIsCallingBackPacketHandler(): void
    {
        $info = new Info(
            'serverId',
            '1.0.0',
            1,
            1024,
            true,
            true,
            true
        );

        $packetHandler = $this->createMock(PacketHandler::class);
        $packetHandler
            ->expects($this->once())
            ->method('handleInfo')
            ->with($info);

        $info->accept($packetHandler);
    }
}
