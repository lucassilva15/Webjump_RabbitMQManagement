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

namespace Webjump\RabbitMQManagement\Model\Queue\Commands;

use Magento\Framework\ShellInterface;
use Webjump\RabbitMQManagement\Model\Queue\Builders\QueueConsumerCommand;

class CreateConsumers
{
    /** @var ShellInterface */
    private $shellBackground;

    /** @var QueueConsumerCommand */
    private $queueConsumerCommandBuilder;

    /**
     * CreateConsumers constructor.
     *
     * @param ShellInterface $shellBackground
     * @param QueueConsumerCommand $queueConsumerCommandBuilder
     */
    public function __construct(ShellInterface $shellBackground, QueueConsumerCommand $queueConsumerCommandBuilder)
    {
        $this->shellBackground = $shellBackground;
        $this->queueConsumerCommandBuilder = $queueConsumerCommandBuilder;
    }

    /**
     * Execute method
     *
     * @param array $queue
     * @param int $consumersToBeCreated
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(array $queue, int $consumersToBeCreated)
    {
        $command = $this->queueConsumerCommandBuilder->build($queue);
        for ($consumersCreated = 0; $consumersCreated < $consumersToBeCreated; $consumersCreated++) {
            $this->shellBackground->execute($command);
        }
    }
}
