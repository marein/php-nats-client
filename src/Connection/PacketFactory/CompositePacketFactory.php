<?php
declare(strict_types=1);

namespace Marein\Nats\Connection\PacketFactory;

use Marein\Nats\Connection\Buffer;
use Marein\Nats\Protocol\Packet\Server\Packet;

final class CompositePacketFactory implements PacketFactory
{
    /**
     * @var PacketFactory[]
     */
    private $packetFactories;

    /**
     * CompositePacketFactory constructor.
     */
    public function __construct()
    {
        $this->packetFactories = [
            new MsgPacketFactory(),
            new OkPacketFactory(),
            new ErrPacketFactory(),
            new InfoPacketFactory()
        ];
    }

    /**
     * @inheritdoc
     */
    public function tryToCreateFromBuffer(Buffer $buffer): Result
    {
        foreach ($this->packetFactories as $packetFactory) {
            $result = $packetFactory->tryToCreateFromBuffer($buffer);

            if ($result->packet() !== null) {
                return $result;
            }
        }

        return new Result($buffer, null);
    }
}
