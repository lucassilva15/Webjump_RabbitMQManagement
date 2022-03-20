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

use Webjump\RabbitMQManagement\Model\Requests\QueueList;

class GetQueueList
{
    /** @var QueueList */
    private $queueList;

    /**
     * GetQueueList constructor.
     *
     * @param QueueList $queueList
     */
    public function __construct(QueueList $queueList)
    {
        $this->queueList = $queueList;
    }

    /**
     * Execute method
     *
     * @return array
     */
    public function execute(): array
    {
        $queues = [];
        $response = $this->queueList->doRequest();
        $items = $response->getBodyArray();

        if (empty($items) === true) {
            return $queues;
        }

        foreach ($items as $item) {
            $name = $item['name'];
            $queues[] = ['label' => $name, 'value' => $name];
        }

        return $queues;
    }
}
