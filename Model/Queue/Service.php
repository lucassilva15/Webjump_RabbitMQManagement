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

namespace Webjump\RabbitMQManagement\Model\Queue;

use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Model\Config;

class Service
{
    /** @var Repository */
    private $repository;

    /** @var Json */
    private $json;

    /** @var Config */
    private $config;

    /** @var Helper */
    private $helper;

    /**
     * Service constructor.
     *
     * @param Repository $repository
     * @param Json $json
     * @param Config $config
     * @param Helper $helper
     */
    public function __construct(Repository $repository, Json $json, Config $config, Helper $helper)
    {
        $this->repository = $repository;
        $this->json = $json;
        $this->config = $config;
        $this->helper = $helper;
    }

    /**
     * CreateNeededConsumers method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createNeededConsumers(): void
    {
        $queuesJson = $this->config->getQueues();

        if ($this->config->isEnabled() === false || empty($queuesJson) === true) {
            return;
        }

        $queueDataList = $this->json->unserialize($queuesJson);

        foreach ($queueDataList as $queueData) {
            $queueInfo = $this->createQueueInfo($queueData);

            if ($queueInfo->isEnabled() === false) {
                continue;
            }

            $queueName = $queueInfo->getQueueName();
            $startConsumersCommand = $this->helper->buildStartConsumersCommand(
                $queueInfo->getMaxMessagesToRead(),
                $queueName
            );

            $queueInfo->setActiveConsumers($this->getActiveConsumers($startConsumersCommand));

            $rabbitQueueData = $this->getRabbitQueueByName($queueName);
            $queueInfo->setMessagesInQueue($rabbitQueueData['messages']);

            $this->createConsumers($queueInfo);
        }
    }

    /**
     * CreateQueueInfo method
     *
     * @param array $queueInfo
     *
     * @return QueueInfo
     */
    public function createQueueInfo(array $queueInfo): QueueInfo
    {
        return $this->repository->createQueueInfo($queueInfo);
    }

    /**
     * GetActiveConsumers method
     *
     * @param string $command
     *
     * @return int
     */
    public function getActiveConsumers(string $command): int
    {
        return $this->repository->getActiveConsumers($command);
    }

    /**
     * GetRabbitQueue method
     *
     * @param string $queueCode
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRabbitQueueByName(string $queueCode): array
    {
        return $this->repository->getRabbitQueueByName($queueCode);
    }

    /**
     * CreateConsumers method
     *
     * @param QueueInfo $queueInfo
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createConsumers(QueueInfo $queueInfo)
    {
        $this->repository->createConsumers($queueInfo);
    }

    /**
     * GetQueueList method
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQueueList(): array
    {
        return $this->repository->getQueueList();
    }
}
