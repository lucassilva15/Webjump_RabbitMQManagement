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

namespace Webjump\RabbitMQManagement\Model\Consumers\Commands;

use Webjump\RabbitMQManagement\Model\Requests\GetQueueByIdFactory;

class CreateConsumer
{
    /** @var GetQueueByIdFactory */
    private $getQueueByIdFactory;

    /**
     * CreateConsumer constructor.
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
     * @return void
     */
    public function execute(array $queue)
    {
        $queueEnabled = $queue['enabled'] ?? null;
        if ($queueEnabled !== '1') {
            return;
        }

        $request = $this->getQueueByIdFactory->create([
            'queueCode' => $queue['queue']
        ]);
        $response = $request->doRequest();
        $responseData = $response->getBodyArray();

        $consumers = $responseData['consumers'];

        if ($consumers < $queue['max_consumers']) {
            $queueMessages = $responseData['messages'];
            $neededConsumers = ceil((float)($queueMessages / $queue['read_messages']));
            if ($consumers < $neededConsumers) {
                for ($consumersCount = $consumers; $consumersCount < $neededConsumers; $consumersCount++) {
                    exec("php magento queue:consumers:start --max-messages={$queue['read_messages']} {$queue['queue']} > /dev/null &");
                }
            }
        }
    }
}
