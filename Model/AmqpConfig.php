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

use Magento\Framework\Amqp\Config;

class AmqpConfig
{
    /** @var Config */
    private $config;

    /**
     * AmqpHelper constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * GetHost method
     *
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->config->getValue(Config::HOST);
    }

    /**
     * GetPort method
     *
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->config->getValue(Config::PORT);
    }

    /**
     * GetUsername method
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->config->getValue(Config::USERNAME);
    }

    /**
     * GetPassword method
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->config->getValue(Config::PASSWORD);
    }

    /**
     * GetSsl method
     *
     * @return string|null
     */
    public function getSsl(): ?string
    {
        return $this->config->getValue(Config::SSL);
    }
}
