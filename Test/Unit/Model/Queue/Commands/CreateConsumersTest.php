<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\RabbitMQManagement\Test\Unit\Model\Queue\Commands;

use Magento\Framework\App\Shell;
use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Helper;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;

class CreateConsumersTest extends \PHPUnit\Framework\TestCase
{
    /** @var Shell */
    private $shelBackgroudMock;

    /** @var Helper */
    private $helperMock;

    /** @var QueueInfo */
    private $queueInfoMock;

    /** @var CreateConsumers */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->shelBackgroudMock = $this->createMock(Shell::class);
        $this->helperMock = $this->createMock(Helper::class);

        // Others
        $this->queueInfoMock = $this->createMock(QueueInfo::class);

        // Instance
        $this->instance = new CreateConsumers($this->shelBackgroudMock, $this->helperMock);
    }

    /**
     * TestExecute method
     *
     * @param array $argsMock
     * @param array $calls
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @dataProvider executeDataProvider
     */
    public function testExecute(array $argsMock, array $calls)
    {
        // Arrange
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_get_needed_consumers']))
            ->method('getNeededConsumers')
            ->willReturn($argsMock['queue_info_get_needed_consumers']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_get_max_messages_to_read']))
            ->method('getMaxMessagesToRead')
            ->willReturn($argsMock['queue_info_get_max_messages_to_read']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_get_queue_name']))
            ->method('getQueueName')
            ->willReturn($argsMock['queue_info_get_queue_name']);
        $this->helperMock
            ->expects($this->exactly($calls['helper_build_start_consumers_command']))
            ->method('buildStartConsumersCommand')
            ->willReturn('command');
        $this->shelBackgroudMock
            ->expects($this->exactly($calls['shell_background_execute']))
            ->method('execute');

        // Act
        $this->instance->execute($this->queueInfoMock);
    }

    public function executeDataProvider(): array
    {
        return [
            'shouldReturnWhenConsumersToBeCreatedIsLessThanZero' => [
                'argsMock' => [
                    'queue_info_get_needed_consumers' => 0,
                    'queue_info_get_max_messages_to_read' => 0,
                    'queue_info_get_queue_name' => 'queue.name'
                ],
                'calls' => [
                    'queue_info_get_needed_consumers' => 1,
                    'queue_info_get_max_messages_to_read' => 0,
                    'queue_info_get_queue_name' => 0,
                    'helper_build_start_consumers_command' => 0,
                    'shell_background_execute' => 0
                ],
            ],
            'shouldCreateConsumers' => [
                'argsMock' => [
                    'queue_info_get_needed_consumers' => 10,
                    'queue_info_get_max_messages_to_read' => 0,
                    'queue_info_get_queue_name' => 'queue.name'
                ],
                'calls' => [
                    'queue_info_get_needed_consumers' => 1,
                    'queue_info_get_max_messages_to_read' => 1,
                    'queue_info_get_queue_name' => 1,
                    'helper_build_start_consumers_command' => 1,
                    'shell_background_execute' => 10
                ],
            ],
        ];
    }
}
