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

use Webjump\RabbitMQManagement\Model\Queue\Commands\GetQueueList;

class Repository
{
    /** @var GetQueueList */
    private $getQueueListCommand;

    /**
     * Repository constructor.
     *
     * @param GetQueueList $getQueueListCommand
     */
    public function __construct(GetQueueList $getQueueListCommand)
    {
        $this->getQueueListCommand = $getQueueListCommand;
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
}
