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

use Magento\Framework\Exception\LocalizedException;
use Webjump\RabbitMQManagement\Model\AmqpConfig;
use Webjump\RabbitMQManagement\Model\Config;

class Endpoint
{
    /** @var AmqpConfig */
    private $amqpConfig;

    /** @var Config */
    private $config;

    /**
     * Endpoint constructor.
     *
     * @param AmqpConfig $amqpConfig
     * @param Config $config
     */
    public function __construct(AmqpConfig $amqpConfig, Config $config)
    {
        $this->amqpConfig = $amqpConfig;
        $this->config = $config;
    }

    /**
     * Build method
     *
     * @param string $resource
     *
     * @return string
     * @throws LocalizedException
     */
    public function build(string $resource): string
    {
        $protocol = $this->getProtocol();

        $host = $this->getHost();
        if (empty($host) === true) {
            throw new LocalizedException(__('RabbitMQ host is a required configuration.'));
        }

        $port = $this->getPort();
        if (empty($port) === true) {
            throw new LocalizedException(__('RabbitMQ port is a required configuration.'));
        }

        return $protocol . $host . ":" . $port . $resource;
    }

    /**
     * GetProtocol method
     *
     * @return string
     */
    private function getProtocol(): string
    {
        $ssl = $this->amqpConfig->getSsl();
        if ($ssl !== 'true') {
            return 'http://';
        }
        return 'https://';
    }

    /**
     * GetHost method
     *
     * @return string|null
     */
    private function getHost(): ?string
    {
        return $this->amqpConfig->getHost();
    }

    /**
     * GetPort method
     *
     * @return string|null
     */
    private function getPort(): ?string
    {
        return $this->config->getServicePort();
    }
}
