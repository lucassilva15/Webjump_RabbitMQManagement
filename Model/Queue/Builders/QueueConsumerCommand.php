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

namespace Webjump\RabbitMQManagement\Model\Queue\Builders;

use Symfony\Component\Process\PhpExecutableFinder;

class QueueConsumerCommand
{
    const CONSUMERS_COMMAND = "/bin/magento queue:consumers:start %s %s";

    /** @var PhpExecutableFinder */
    private $phpExecutableFinder;

    /**
     * QueueConsumerCommand constructor.
     *
     * @param PhpExecutableFinder $phpExecutableFinder
     */
    public function __construct(PhpExecutableFinder $phpExecutableFinder)
    {
        $this->phpExecutableFinder = $phpExecutableFinder;
    }

    /**
     * Build method
     *
     * @param array $queue
     *
     * @return string
     */
    public function build(array $queue): string
    {
        $php = $this->phpExecutableFinder->find() ?: 'php';
        $arguments = [
            "--max-messages={$queue['read_messages']}",
            $queue['queue'],
        ];

        $command = $php . ' ' . BP . self::CONSUMERS_COMMAND;
        return vsprintf($command, $arguments);
    }
}
