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

namespace Webjump\RabbitMQManagement\Model;

use Magento\Framework\ShellInterface;

class QueueHelper
{
    const GET_QUEUE_CONSUMERS_QUANTITY_COMMAND = "ps aux --no-heading | grep '%s' | wc -l";

    /** @var ShellInterface */
    private $shell;

    /**
     * QueueHelper constructor.
     *
     * @param ShellInterface $shell
     */
    public function __construct(ShellInterface $shell)
    {
        $this->shell = $shell;
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
    public function calculateNeededConsumers(int $queueMessages, int $maxConsumers, int $messagesByConsumer): int
    {
        $neededConsumers = ceil((float)($queueMessages / $messagesByConsumer));
        if ($neededConsumers > $maxConsumers) {
            return $maxConsumers;
        }
        return (int)$neededConsumers;
    }

    /**
     * GetCurrentConsumersQuantity method
     *
     * @param string $command
     *
     * @return string
     */
    public function getCurrentConsumersQuantity(string $command): string
    {
        $command = sprintf(self::GET_QUEUE_CONSUMERS_QUANTITY_COMMAND, $command);
        return exec($command);
    }
}
