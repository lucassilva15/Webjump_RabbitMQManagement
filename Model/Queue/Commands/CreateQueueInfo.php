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

use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfoFactory;

class CreateQueueInfo
{
    /** @var QueueInfoFactory */
    private $queueInfoFactory;

    /**
     * CreateQueueInfoList constructor.
     *
     * @param QueueInfoFactory $queueInfoFactory
     */
    public function __construct(QueueInfoFactory $queueInfoFactory)
    {
        $this->queueInfoFactory = $queueInfoFactory;
    }

    /**
     * Execute method
     *
     * @param array $queueData
     *
     * @return QueueInfo
     */
    public function execute(array $queueData): QueueInfo
    {
        $queueInfo = $this->queueInfoFactory->create();
        $queueInfo->setData($queueData);
        return $queueInfo;
    }
}
