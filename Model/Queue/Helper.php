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

use Symfony\Component\Process\PhpExecutableFinder;
use const BP;

class Helper
{
    const START_CONSUMERS_COMMAND = "/bin/magento queue:consumers:start %s %s";

    /** @var PhpExecutableFinder */
    private $phpExecutableFinder;

    /**
     * Helper constructor.
     *
     * @param PhpExecutableFinder $phpExecutableFinder
     */
    public function __construct(PhpExecutableFinder $phpExecutableFinder)
    {
        $this->phpExecutableFinder = $phpExecutableFinder;
    }

    /**
     * BuildStartConsumersCommand method
     *
     * @param int $maxMessagesToRead
     * @param string $queueName
     *
     * @return string
     */
    public function buildStartConsumersCommand(int $maxMessagesToRead, string $queueName): string
    {
        $php = $this->phpExecutableFinder->find() ?: 'php';

        $arguments = [
            "--max-messages=$maxMessagesToRead",
            $queueName,
        ];

        $command = $php . ' ' . BP . self::START_CONSUMERS_COMMAND;

        return vsprintf($command, $arguments);
    }
}
