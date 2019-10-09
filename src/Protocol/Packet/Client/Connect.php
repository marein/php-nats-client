<?php
declare(strict_types=1);

namespace Marein\Nats\Protocol\Packet\Client;

final class Connect implements Packet
{
    /**
     * @var bool
     */
    private $shouldBeVerbose;

    /**
     * @var bool
     */
    private $shouldBePedantic;

    /**
     * @var bool
     */
    private $shouldRequireTls;

    /**
     * @var string|null
     */
    private $authorizationToken;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string
     */
    private $clientLibraryName;

    /**
     * @var string
     */
    private $clientLibraryProgrammingLanguage;

    /**
     * @var string
     */
    private $clientLibraryVersion;

    /**
     * @var int
     */
    private $clientProtocolVersion;

    /**
     * @var bool
     */
    private $shouldEchoToOwnSubscriptions;

    /**
     * Connect constructor.
     *
     * @param bool        $shouldBeVerbose
     * @param bool        $shouldBePedantic
     * @param bool        $shouldRequireTls
     * @param string|null $authorizationToken
     * @param string|null $username
     * @param string|null $password
     * @param string      $clientLibraryName
     * @param string      $clientLibraryProgrammingLanguage
     * @param string      $clientLibraryVersion
     * @param int         $clientProtocolVersion
     * @param bool        $shouldEchoToOwnSubscriptions
     */
    public function __construct(
        bool $shouldBeVerbose,
        bool $shouldBePedantic,
        bool $shouldRequireTls,
        ?string $authorizationToken,
        ?string $username,
        ?string $password,
        string $clientLibraryName,
        string $clientLibraryProgrammingLanguage,
        string $clientLibraryVersion,
        int $clientProtocolVersion,
        bool $shouldEchoToOwnSubscriptions
    ) {
        $this->shouldBeVerbose = $shouldBeVerbose;
        $this->shouldBePedantic = $shouldBePedantic;
        $this->shouldRequireTls = $shouldRequireTls;
        $this->authorizationToken = $authorizationToken;
        $this->username = $username;
        $this->password = $password;
        $this->clientLibraryName = $clientLibraryName;
        $this->clientLibraryProgrammingLanguage = $clientLibraryProgrammingLanguage;
        $this->clientLibraryVersion = $clientLibraryVersion;
        $this->clientProtocolVersion = $clientProtocolVersion;
        $this->shouldEchoToOwnSubscriptions = $shouldEchoToOwnSubscriptions;
    }

    /**
     * @inheritdoc
     */
    public function pack(): string
    {
        return sprintf(
            'CONNECT %s%s',
            json_encode(
                [
                    'verbose' => $this->shouldBeVerbose,
                    'pedantic' => $this->shouldBePedantic,
                    'tls_required' => $this->shouldRequireTls,
                    'auth_token' => $this->authorizationToken,
                    'user' => $this->username,
                    'pass' => $this->password,
                    'name' => $this->clientLibraryName,
                    'lang' => $this->clientLibraryProgrammingLanguage,
                    'version' => $this->clientLibraryVersion,
                    'protocol' => $this->clientProtocolVersion,
                    'echo' => $this->shouldEchoToOwnSubscriptions
                ]
            ),
            Packet::MESSAGE_TERMINATOR
        );
    }
}
