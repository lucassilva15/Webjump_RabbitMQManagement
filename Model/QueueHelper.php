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

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessFactory;

class QueueHelper
{
    const GET_QUEUE_CONSUMERS_QUANTITY_COMMAND = ['ps', '-aux'];

    /** @var ProcessFactory */
    private $processFactory;

    /** @var LoggerInterface */
    private $logger;

    /**
     * QueueHelper constructor.
     *
     * @param ProcessFactory $processFactory
     * @param LoggerInterface $logger
     */
    public function __construct(ProcessFactory $processFactory, LoggerInterface $logger)
    {
        $this->processFactory = $processFactory;
        $this->logger = $logger;
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
     * @return int
     */
    public function getCurrentConsumersQuantity(string $command): int
    {
        $process = $this->processFactory->create([
            'command' => self::GET_QUEUE_CONSUMERS_QUANTITY_COMMAND
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();

        return substr_count($output, $command);
    }
}
