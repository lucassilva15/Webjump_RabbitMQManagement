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

use Webjump\RabbitMQManagement\Model\Requests\GetQueueByIdFactory;

class GetAvailableConsumersQuantity
{
    /** @var GetQueueByIdFactory */
    private $getQueueByIdFactory;

    /**
     * GetAvailableConsumers constructor.
     *
     * @param GetQueueByIdFactory $getQueueByIdFactory
     */
    public function __construct(GetQueueByIdFactory $getQueueByIdFactory)
    {
        $this->getQueueByIdFactory = $getQueueByIdFactory;
    }

    /**
     * Execute method
     *
     * @param array $queue
     *
     * @return int
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

        $consumers = $responseData['consumers'] ?? 0;
        $maxConsumers = (int)$queue['max_consumers'] ?? 0;

        if ($consumers < $maxConsumers) {
            $queueMessages = $responseData['messages'] ?? 0;
            $messagesByConsumer = (int)$queue['read_messages'] ?? 0;
            return $this->calculateNeededConsumers($queueMessages, $maxConsumers, $messagesByConsumer);
        }
        return 0;
    }

    /**
     * CalculateNeededConsumers method
     *
     * @param int $queueMessages
     * @param int $maxConsumers
     * @param int $messagesByConsumer
     *
     * @return int
     */
    private function calculateNeededConsumers(int $queueMessages, int $maxConsumers, int $messagesByConsumer): int
    {
        $neededConsumers = ceil((float)($queueMessages / $messagesByConsumer));
        if ($neededConsumers > $maxConsumers) {
            return $maxConsumers;
        }
        return (int)$neededConsumers;
    }
}
