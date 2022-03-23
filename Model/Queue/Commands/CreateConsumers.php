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

class CreateConsumers
{
    const CONSUMERS_COMMAND = "php magento queue:consumers:start --max-messages=%s %s > /dev/null &";

    /**
     * Execute method
     *
     * @param array $queue
     * @param int $consumersToBeCreated
     *
     * @return void
     */
    public function execute(array $queue, int $consumersToBeCreated)
    {
        for ($consumersCreated = 0; $consumersCreated < $consumersToBeCreated; $consumersCreated++) {
            $command = sprintf(self::CONSUMERS_COMMAND, $queue['read_messages'], $queue['queue']);
            exec($command);
        }
    }
}
