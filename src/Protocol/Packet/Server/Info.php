<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

final class Info implements Packet
{
    /**
     * @var string
     */
    private $serverId;

    /**
     * @var string
     */
    private $version;

    /**
     * @var int
     */
    private $protocol;

    /**
     * @var int
     */
    private $payloadLimit;

    /**
     * Info constructor.
     *
     * @param string $serverId
     * @param string $version
     * @param int    $protocol
     * @param int    $payloadLimit
     */
    public function __construct(string $serverId, string $version, int $protocol, int $payloadLimit)
    {
        $this->serverId = $serverId;
        $this->version = $version;
        $this->protocol = $protocol;
        $this->payloadLimit = $payloadLimit;
    }

    /**
     * Creates an Info object from string.
     *
     * @param string $value
     *
     * @return Info
     */
    public static function fromJson(string $value): Info
    {
        $information = json_decode(substr($value, 5), true);

        return new Info(
            $information['server_id'],
            $information['version'],
            (int)$information['proto'],
            (int)$information['max_payload']
        );
    }
}
