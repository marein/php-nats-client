<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Packet\Client;

use Marein\Nats\Protocol\Packet\Client\Connect;
use PHPUnit\Framework\TestCase;

class ConnectTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBePacked(): void
    {
        $expectedPack = 'CONNECT {"verbose":true,"pedantic":false,"tls_required":false,"auth_token":null,' .
            '"user":null,"pass":null,"name":"marein\/php-nats-client","lang":"php",' .
            '"version":"0.0.0","protocol":0,"echo":false}' .
            "\r\n";

        $connect = new Connect(
            true,
            false,
            false,
            null,
            null,
            null,
            'marein/php-nats-client',
            'php',
            '0.0.0',
            0,
            false
        );

        $this->assertSame(
            $expectedPack,
            $connect->pack()
        );
    }
}
