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

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessFactory;

class GetActiveConsumers
{
    const GET_QUEUE_CONSUMERS_QUANTITY_COMMAND = ['ps', '-aux'];

    /** @var ProcessFactory */
    private $processFactory;

    /**
     * GetActiveConsumers constructor.
     *
     * @param ProcessFactory $processFactory
     */
    public function __construct(ProcessFactory $processFactory)
    {
        $this->processFactory = $processFactory;
    }

    /**
     * GetCurrentConsumersQuantity method
     *
     * @param string $command
     *
     * @return int
     */
    public function execute(string $command): int
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
