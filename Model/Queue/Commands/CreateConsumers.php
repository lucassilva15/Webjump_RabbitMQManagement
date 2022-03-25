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
use Webjump\RabbitMQManagement\Model\Queue\Helper;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;

class CreateConsumers
{
    /** @var ShellInterface */
    private $shellBackground;

    /** @var Helper */
    private $helper;

    /**
     * CreateConsumers constructor.
     *
     * @param ShellInterface $shellBackground
     * @param Helper $queueConsumerCommandBuilder
     */
    public function __construct(ShellInterface $shellBackground, Helper $helper)
    {
        $this->shellBackground = $shellBackground;
        $this->helper = $helper;
    }

    /**
     * Execute method
     *
     * @param QueueInfo $queueInfo
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(QueueInfo $queueInfo)
    {
        $consumersToBeCreated = $queueInfo->getNeededConsumers();
        if ($consumersToBeCreated <= 0) {
            return;
        }

        $command = $this->helper->buildStartConsumersCommand(
            $queueInfo->getMaxMessagesToRead(),
            $queueInfo->getQueueName()
        );

        for ($consumersCreated = 0; $consumersCreated < $consumersToBeCreated; $consumersCreated++) {
            $this->shellBackground->execute($command);
        }
    }
}
