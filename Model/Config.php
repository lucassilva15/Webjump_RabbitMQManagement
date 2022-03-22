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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const BASE_PATH = 'rabbitmq_management';
    const ENABLED_MODULE_FLAG = 'general/enabled';
    const SERVICE_PORT_FIELD = 'rabbitmq_configuration/service_port';
    const QUEUES_FLAG = 'rabbitmq_configuration/queues';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * IsSetFlag method
     *
     * @param string $field
     * @param mixed|null $storeId
     *
     * @return bool
     */
    protected function isSetFlag(string $field, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::BASE_PATH . '/' . $field,
            ScopeInterface::SCOPE_WEBSITES,
            $storeId
        );
    }

    /**
     * GetValue method
     *
     * @param string $field
     * @param mixed|null $storeId
     *
     * @return mixed
     */
    protected function getValue(string $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            static::BASE_PATH . '/' . $field,
            ScopeInterface::SCOPE_WEBSITES,
            $storeId
        );
    }

    /**
     * IsEnabled method
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isEnabled(int $storeId = null): bool
    {
        return $this->isSetFlag(self::ENABLED_MODULE_FLAG, $storeId);
    }

    /**
     * GetQueuesOptions method
     *
     * @param int|null $storeId
     *
     * @return string|null
     */
    public function getQueues(int $storeId = null):? string
    {
        return $this->getValue(self::QUEUES_FLAG, $storeId);
    }

    /**
     * GetServicePort method
     *
     * @param int|null $storeId
     *
     * @return string|null
     */
    public function getServicePort(int $storeId = null): ?string
    {
        return $this->getValue(self::SERVICE_PORT_FIELD, $storeId);
    }
}
