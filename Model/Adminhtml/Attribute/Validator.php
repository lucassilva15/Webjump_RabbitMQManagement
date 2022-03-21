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

namespace Webjump\RabbitMQManagement\Model\Adminhtml\Attribute;

use Exception;
use Magento\Backend\Block\Store\Switcher;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Validation\ValidationException;
use Webjump\RabbitMQManagement\Model\Config;

class Validator extends ArraySerialized
{
    /** @var int */
    protected $scopeCode;

    /** @var Config */
    private $config;

    /**
     * Validation constructor.
     *
     * @param Switcher $switcher
     * @param Config $config
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     * @param TypeListInterface $cacheTypeList
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Switcher             $switcher,
        Config               $config,
        Context              $context,
        Registry             $registry,
        ScopeConfigInterface $scopeConfig,
        TypeListInterface    $cacheTypeList,
        AbstractResource     $resource = null,
        AbstractDb           $resourceCollection = null,
        array                $data = [],
        Json                 $serializer = null
    )
    {
        $this->scopeCode = $switcher->getWebsiteId();
        $this->config = $config;
        parent::__construct(
            $context,
            $registry,
            $scopeConfig,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data,
            $serializer
        );
    }

    /**
     * Save method
     *
     * @return Validator
     * @throws Exception
     */
    public function save(): Validator
    {
        $attributeCodes = [];
        $mappingValues = (array)$this->getValue();
        if ($this->config->isEnabled($this->scopeCode)) {
            foreach ($mappingValues as $value) {
                if ($this->checkIfValueIsArray($value) === true) {
                    if ($this->checkIfQueueIsDuplicated($attributeCodes, $value['queue'])) {
                        throw new ValidationException(__('Cannot repeat RabbitMQ Queue'));
                    }
                    $attributeCodes[] = $value['queue'];
                }
            }
        }

        return parent::save();
    }

    /**
     * CheckIfValueIsArray method
     *
     * @param $value
     *
     * @return bool
     */
    private function checkIfValueIsArray($value): bool
    {
        return is_array($value);
    }

    /**
     * CheckIfQueueIsDuplicated method
     *
     * @param array $attributeCodes
     * @param string $queue
     *
     * @return bool
     */
    private function checkIfQueueIsDuplicated(array $attributeCodes, string $queue): bool
    {
        if (in_array($queue, $attributeCodes)) {
            return true;
        }
        return false;
    }
}
