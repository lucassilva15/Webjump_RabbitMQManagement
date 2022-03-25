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

use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateQueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetActiveConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueList;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueByName;

class Repository
{
    /** @var GetRabbitQueueList */
    private $getQueueListCommand;

    /** @var CreateConsumers */
    private $createConsumersCommand;

    /** @var CreateQueueInfo */
    private $createQueueInfoCommand;

    /** @var GetActiveConsumers */
    private $getActiveConsumersCommand;

    /** @var GetRabbitQueueByName */
    private $getRabbitQueueByNameCommand;

    /**
     * Repository constructor.
     *
     * @param CreateQueueInfo $createQueueInfoCommand
     * @param GetActiveConsumers $getActiveConsumersCommand
     * @param GetRabbitQueueByName $getRabbitQueueByNameCommand
     * @param CreateConsumers $createConsumersCommand
     * @param GetRabbitQueueList $getQueueListCommand
     */
    public function __construct(
        CreateQueueInfo      $createQueueInfoCommand,
        GetActiveConsumers   $getActiveConsumersCommand,
        GetRabbitQueueByName $getRabbitQueueByNameCommand,
        CreateConsumers      $createConsumersCommand,
        GetRabbitQueueList   $getQueueListCommand
    )
    {
        $this->createConsumersCommand = $createConsumersCommand;
        $this->getActiveConsumersCommand = $getActiveConsumersCommand;
        $this->getRabbitQueueByNameCommand = $getRabbitQueueByNameCommand;
        $this->createQueueInfoCommand = $createQueueInfoCommand;
        $this->getQueueListCommand = $getQueueListCommand;
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
        return $this->createQueueInfoCommand->execute($queueInfo);
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
        return $this->getActiveConsumersCommand->execute($command);
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
        return $this->getRabbitQueueByNameCommand->execute($queueCode);
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
        $this->createConsumersCommand->execute($queueInfo);
    }

    /**
     * GetQueueList method
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQueueList(): array
    {
        return $this->getQueueListCommand->execute();
    }
}
