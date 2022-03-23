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

use Webjump\RabbitMQManagement\Model\Queue\Builders\QueueConsumerCommand;
use Webjump\RabbitMQManagement\Model\QueueHelper;
use Webjump\RabbitMQManagement\Model\Requests\GetQueueByIdFactory;

class GetAvailableConsumersQuantity
{
    /** @var GetQueueByIdFactory */
    private $getQueueByIdFactory;

    /** @var QueueConsumerCommand */
    private $queueConsumerCommandBuilder;

    /** @var QueueHelper */
    private $queueHelper;

    /**
     * GetAvailableConsumersQuantity constructor.
     *
     * @param GetQueueByIdFactory $getQueueByIdFactory
     * @param QueueConsumerCommand $queueConsumerCommandBuilder
     * @param QueueHelper $queueHelper
     */
    public function __construct(
        GetQueueByIdFactory  $getQueueByIdFactory,
        QueueConsumerCommand $queueConsumerCommandBuilder,
        QueueHelper          $queueHelper
    )
    {
        $this->getQueueByIdFactory = $getQueueByIdFactory;
        $this->queueConsumerCommandBuilder = $queueConsumerCommandBuilder;
        $this->queueHelper = $queueHelper;
    }

    /**
     * Execute method
     *
     * @param array $queue
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(array $queue): int
    {
        $queueEnabled = $queue['enabled'] ?? null;
        if ($queueEnabled !== '1') {
            return 0;
        }

        $request = $this->getQueueByIdFactory->create([
            'queueCode' => $queue['queue']
        ]);

        $response = $request->doRequest();
        $responseData = $response->getBodyArray();

        $command = $this->queueConsumerCommandBuilder->build($queue);
        $consumers = $this->queueHelper->getCurrentConsumersQuantity($command);
        $maxConsumers = (int)$queue['max_consumers'] ?? 0;

        if ($consumers < $maxConsumers) {
            $queueMessages = $responseData['messages'] ?? 0;
            $messagesByConsumer = (int)$queue['read_messages'] ?? 0;
            return $this->queueHelper->calculateNeededConsumers($queueMessages, $maxConsumers, $messagesByConsumer);
        }
        return 0;
    }
}
