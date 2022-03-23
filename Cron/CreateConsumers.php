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
use Webjump\RabbitMQManagement\Model\Queue\Service;

class CreateConsumers
{
    /** @var Config */
    private $config;

    /** @var Json */
    private $json;

    /** @var Service */
    private $queueService;

    /**
     * CreateConsumers constructor.
     *
     * @param Config $config
     * @param Json $json
     * @param Service $queueService
     */
    public function __construct(Config $config, Json $json, Service $queueService)
    {
        $this->config = $config;
        $this->json = $json;
        $this->queueService = $queueService;
    }

    /**
     * Execute method
     *
     * @return void
     */
    public function execute()
    {
        $queuesJson = $this->config->getQueues();

        if (
            $this->config->isEnabled() === false
            || empty($queuesJson) === true
        ) {
            return;
        }

        $queues = $this->json->unserialize($queuesJson);

        foreach ($queues as $queue) {
            $consumersToBeCreated = $this->queueService->getAvailableConsumersQuantity($queue);
            if ($consumersToBeCreated > 0) {
                $this->queueService->createConsumers($queue, $consumersToBeCreated);
            }
        }
    }
}
