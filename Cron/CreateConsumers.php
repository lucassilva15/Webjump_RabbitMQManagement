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

namespace Webjump\RabbitMQManagement\Cron;

use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Model\Config;
use Webjump\RabbitMQManagement\Model\Consumers\Service;

class CreateConsumers
{
    /** @var Config */
    private $config;

    /** @var Json */
    private $json;

    /** @var Service */
    private $consumersService;

    /**
     * CreateConsumers constructor.
     *
     * @param Config $config
     * @param Json $json
     * @param Service $consumersService
     */
    public function __construct(Config $config, Json $json, Service $consumersService)
    {
        $this->config = $config;
        $this->json = $json;
        $this->consumersService = $consumersService;
    }

    /**
     * Execute method
     *
     * @return void
     */
    public function execute()
    {
        $queuesJson = $this->config->getQueues();
        $queues = $this->json->unserialize($queuesJson);

        foreach($queues as $queue){
            $this->consumersService->createConsumer($queue);
        }
    }
}
