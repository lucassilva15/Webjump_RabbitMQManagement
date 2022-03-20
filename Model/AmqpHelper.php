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

namespace Webjump\RabbitMQManagement\Model;

use Magento\Framework\Amqp\Config as AmqpConfig;

class AmqpHelper
{
    /** @var AmqpConfig */
    private $amqpConfig;

    /**
     * AmqpHelper constructor.
     *
     * @param AmqpConfig $amqpConfig
     */
    public function __construct(AmqpConfig $amqpConfig)
    {
        $this->amqpConfig = $amqpConfig;
    }

    /**
     * GetHost method
     *
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->amqpConfig->getValue(AmqpConfig::HOST);
    }

    /**
     * GetPort method
     *
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->amqpConfig->getValue(AmqpConfig::PORT);
    }

    /**
     * GetUsername method
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->amqpConfig->getValue(AmqpConfig::USERNAME);
    }

    /**
     * GetPassword method
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->amqpConfig->getValue(AmqpConfig::PASSWORD);
    }
}
