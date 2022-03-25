<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders;

use Webjump\RabbitMQManagement\Model\AmqpConfig;

class Headers
{
    /** @var AmqpConfig */
    private $amqpConfig;

    /**
     * Headers constructor.
     *
     * @param AmqpConfig $amqpConfig
     */
    public function __construct(AmqpConfig $amqpConfig)
    {
        $this->amqpConfig = $amqpConfig;
    }

    /**
     * Build method
     *
     * @param array $customHeaders
     *
     * @return array
     */
    public function build(array $customHeaders): array
    {
        $headers = [
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Authorization' => sprintf('Basic %s', $this->getBasicToken()),
        ];

        return array_merge($headers, $customHeaders);
    }

    /**
     * GetBasicToken method
     *
     * @return string
     */
    private function getBasicToken(): string
    {
        $username = $this->amqpConfig->getUsername();
        $password = $this->amqpConfig->getPassword();
        return base64_encode("$username:$password");
    }
}
