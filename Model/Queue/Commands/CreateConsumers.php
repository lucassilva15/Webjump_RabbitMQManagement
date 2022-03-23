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

use Magento\Framework\ShellInterface;
use Symfony\Component\Process\PhpExecutableFinder;

class CreateConsumers
{
    const CONSUMERS_COMMAND = "/bin/magento queue:consumers:start %s %s";

    /** @var ShellInterface */
    private $shellBackground;

    /** @var PhpExecutableFinder */
    private $phpExecutableFinder;

    /**
     * CreateConsumers constructor.
     *
     * @param ShellInterface $shellBackground
     * @param PhpExecutableFinder $phpExecutableFinder
     */
    public function __construct(ShellInterface $shellBackground, PhpExecutableFinder $phpExecutableFinder)
    {
        $this->shellBackground = $shellBackground;
        $this->phpExecutableFinder = $phpExecutableFinder;
    }

    /**
     * Execute method
     *
     * @param array $queue
     * @param int $consumersToBeCreated
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(array $queue, int $consumersToBeCreated)
    {
        $php = $this->phpExecutableFinder->find() ?: 'php';
        for ($consumersCreated = 0; $consumersCreated < $consumersToBeCreated; $consumersCreated++) {
            $arguments = [
                "--max-messages={$queue['read_messages']}",
                $queue['queue'],
            ];

            $command = $php . ' ' . BP . self::CONSUMERS_COMMAND;

            $this->shellBackground->execute($command, $arguments);
        }
    }
}
