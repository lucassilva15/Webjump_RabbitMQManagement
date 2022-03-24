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

class Service
{
    /** @var Repository */
    private $repository;

    /**
     * Service constructor.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
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

    /**
     * GetAvailableConsumersQuantity method
     *
     * @param array $queue
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAvailableConsumersQuantity(array $queue): int
    {
        return $this->repository->getAvailableConsumersQuantity($queue);
    }

    /**
     * CreateConsumers method
     *
     * @param array $queue
     * @param int $consumersToBeCreated
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createConsumers(array $queue, int $consumersToBeCreated)
    {
        $this->repository->createConsumers($queue, $consumersToBeCreated);
    }
}
