<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class CompositePacketFactory implements PacketFactory
{
    /**
     * This is an assignment of the first three characters of a packet to the packet factory.
     * The first three are used because they distinguish all packets. This may change in the future.
     * This is for the faster search for the right packet factory.
     *
     * @var array<string, PacketFactory>
     */
    private array $packetFactories;

    /**
     * CompositePacketFactory constructor.
     */
    public function __construct()
    {
        $this->packetFactories = [
            '-ER' => new ErrPacketFactory(),
            'INF' => new InfoPacketFactory(),
            'MSG' => new MsgPacketFactory(),
            '+OK' => new OkPacketFactory(),
            'PIN' => new PingPacketFactory(),
            'PON' => new PongPacketFactory()
        ];
    }

    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        $packetFactoryKey = substr($buffer->value(), 0, 3);

        if (!array_key_exists($packetFactoryKey, $this->packetFactories)) {
            return new Result($buffer, null);
        }

        return $this->packetFactories[$packetFactoryKey]->tryToCreateFromBuffer($buffer);
    }
}
