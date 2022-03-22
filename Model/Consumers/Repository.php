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

namespace Webjump\RabbitMQManagement\Model\Consumers;

use Webjump\RabbitMQManagement\Model\Consumers\Commands\CreateConsumer;

class Repository
{
    /** @var CreateConsumer */
    private $createConsumerCommand;

    /**
     * Repository constructor.
     *
     * @param CreateConsumer $createConsumerCommand
     */
    public function __construct(CreateConsumer $createConsumerCommand)
    {
        $this->createConsumerCommand = $createConsumerCommand;
    }

    /**
     * CreateConsumer method
     *
     * @param array $queue
     *
     * @return void
     */
    public function createConsumer(array $queue)
    {
        $this->createConsumerCommand->execute($queue);
    }
}
