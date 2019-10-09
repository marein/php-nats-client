<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Server;

interface PacketHandler
{
    /**
     * Handle an Err object.
     *
     * @param Err $err
     */
    public function handleErr(Err $err): void;

    /**
     * Handle an Info object.
     *
     * @param Info $info
     */
    public function handleInfo(Info $info): void;

    /**
     * Handle an Msg object.
     *
     * @param Msg $msg
     */
    public function handleMsg(Msg $msg): void;

    /**
     * Handle a NullPacket object.
     *
     * @param NullPacket $nullPacket
     */
    public function handleNullPacket(NullPacket $nullPacket): void;

    /**
     * Handle an Ok object.
     *
     * @param Ok $ok
     */
    public function handleOk(Ok $ok): void;

    /**
     * Handle a Ping object.
     *
     * @param Ping $ping
     */
    public function handlePing(Ping $ping): void;

    /**
     * Handle a Pong object.
     *
     * @param Pong $pong
     */
    public function handlePong(Pong $pong): void;
}
