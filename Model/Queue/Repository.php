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
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetAvailableConsumersQuantity;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetQueueList;

class Repository
{
    /** @var GetQueueList */
    private $getQueueListCommand;

    /** @var GetAvailableConsumersQuantity */
    private $getAvailableConsumersQuantityCommand;

    /** @var CreateConsumers */
    private $createConsumersCommand;

    /**
     * Repository constructor.
     *
     * @param GetQueueList $getQueueListCommand
     * @param GetAvailableConsumersQuantity $getAvailableConsumersQuantityCommand
     * @param CreateConsumers $createConsumersCommand
     */
    public function __construct(
        GetQueueList                  $getQueueListCommand,
        GetAvailableConsumersQuantity $getAvailableConsumersQuantityCommand,
        CreateConsumers               $createConsumersCommand
    )
    {
        $this->getQueueListCommand = $getQueueListCommand;
        $this->getAvailableConsumersQuantityCommand = $getAvailableConsumersQuantityCommand;
        $this->createConsumersCommand = $createConsumersCommand;
    }

    /**
     * GetQueueList method
     *
     * @return array
     */
    public function getQueueList(): array
    {
        return $this->getQueueListCommand->execute();
    }

    /**
     * GetAvailableConsumersQuantity method
     *
     * @param array $queue
     *
     * @return int
     */
    public function getAvailableConsumersQuantity(array $queue): int
    {
        return $this->getAvailableConsumersQuantityCommand->execute($queue);
    }

    /**
     * CreateConsumers method
     *
     * @param array $queue
     * @param int $consumersToBeCreated
     *
     * @return void
     */
    public function createConsumers(array $queue, int $consumersToBeCreated)
    {
        $this->createConsumersCommand->execute($queue, $consumersToBeCreated);
    }
}
