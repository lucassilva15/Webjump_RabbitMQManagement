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

use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Model\Config;
use Webjump\RabbitMQManagement\Model\Queue\Helper;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\Repository;
use Webjump\RabbitMQManagement\Model\Queue\Service;

class ServiceTest extends \PHPUnit\Framework\TestCase
{
    /** @var Repository */
    private $repositoryMock;

    /** @var Json */
    private $jsonMock;

    /** @var Config */
    private $configMock;

    /** @var Helper */
    private $helperMock;

    /** @var QueueInfo */
    private $queueInfoMock;

    /** @var Service */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->repositoryMock = $this->createMock(Repository::class);
        $this->jsonMock = $this->createMock(Json::class);
        $this->configMock = $this->createMock(Config::class);
        $this->helperMock = $this->createMock(Helper::class);

        // Others
        $this->queueInfoMock = $this->createMock(QueueInfo::class);

        // Instance
        $this->instance = new Service(
            $this->repositoryMock,
            $this->jsonMock,
            $this->configMock,
            $this->helperMock
        );
    }

    /**
     * TestCreateNeededConsumers method
     *
     * @param array $argsMock
     * @param array $calls
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @dataProvider createNeededConsumersDataProvider
     */
    public function testCreateNeededConsumers(array $argsMock, array $calls)
    {
        // Arrange
        $this->configMock
            ->expects($this->exactly($calls['config_get_queues']))
            ->method('getQueues')
            ->willReturn($argsMock['config_get_queues']);
        $this->configMock
            ->expects($this->exactly($calls['config_is_enabled']))
            ->method('isEnabled')
            ->willReturn($argsMock['config_is_enabled']);
        $this->jsonMock
            ->expects($this->exactly($calls['json_unserialize']))
            ->method('unserialize')
            ->willReturn($argsMock['json_unserialize']);
        $this->repositoryMock
            ->expects($this->exactly($calls['repository_create_queue_info']))
            ->method('createQueueInfo')
            ->willReturn($this->queueInfoMock);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_is_enabled']))
            ->method('isEnabled')
            ->willReturn($argsMock['queue_info_is_enabled']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_get_queue_name']))
            ->method('getQueueName')
            ->willReturn($argsMock['queue_info_get_queue_name']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_get_max_messages_to_read']))
            ->method('getMaxMessagesToRead')
            ->willReturn($argsMock['queue_info_get_max_messages_to_read']);
        $this->helperMock
            ->expects($this->exactly($calls['helper_build_start_consumers_command']))
            ->method('buildStartConsumersCommand')
            ->willReturn($argsMock['helper_build_start_consumers_command']);
        $this->repositoryMock
            ->expects($this->exactly($calls['repository_get_active_consumers']))
            ->method('getActiveConsumers')
            ->willReturn($argsMock['repository_get_active_consumers']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_set_active_consumers']))
            ->method('setActiveConsumers');
        $this->repositoryMock
            ->expects($this->exactly($calls['repository_get_rabbit_queue_by_name']))
            ->method('getRabbitQueueByName')
            ->willReturn($argsMock['repository_get_rabbit_queue_by_name']);
        $this->queueInfoMock
            ->expects($this->exactly($calls['queue_info_set_messages_in_queue']))
            ->method('setMessagesInQueue');
        $this->repositoryMock
            ->expects($this->exactly($calls['repository_create_consumers']))
            ->method('createConsumers');

        // Act
        $this->instance->createNeededConsumers();
    }

    public function createNeededConsumersDataProvider(): array
    {
        return [
            'shouldReturnWhenModuleIsDisabled' => [
                'argsMock' => [
                    'config_get_queues' => 'queues',
                    'config_is_enabled' => false,
                    'json_unserialize' => [],
                    'queue_info_is_enabled' => false,
                    'queue_info_get_queue_name' => 'queue_name',
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 'command',
                    'repository_get_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => [],
                ],
                'calls' => [
                    'config_get_queues' => 1,
                    'config_is_enabled' => 1,
                    'json_unserialize' => 0,
                    'repository_create_queue_info' => 0,
                    'queue_info_is_enabled' => 0,
                    'queue_info_get_queue_name' => 0,
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 0,
                    'repository_get_active_consumers' => 0,
                    'queue_info_set_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => 0,
                    'queue_info_set_messages_in_queue' => 0,
                    'repository_create_consumers' => 0,
                ]
            ],
            'shouldReturnWhenQueueJsonIsEmpty' => [
                'argsMock' => [
                    'config_get_queues' => '',
                    'config_is_enabled' => true,
                    'json_unserialize' => [],
                    'queue_info_is_enabled' => false,
                    'queue_info_get_queue_name' => 'queue_name',
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 'command',
                    'repository_get_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => [],
                ],
                'calls' => [
                    'config_get_queues' => 1,
                    'config_is_enabled' => 1,
                    'json_unserialize' => 0,
                    'repository_create_queue_info' => 0,
                    'queue_info_is_enabled' => 0,
                    'queue_info_get_queue_name' => 0,
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 0,
                    'repository_get_active_consumers' => 0,
                    'queue_info_set_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => 0,
                    'queue_info_set_messages_in_queue' => 0,
                    'repository_create_consumers' => 0,
                ]
            ],
            'shouldReturnWhenQueueIsDisabled' => [
                'argsMock' => [
                    'config_get_queues' => 'queues',
                    'config_is_enabled' => true,
                    'json_unserialize' => [
                        ['queue']
                    ],
                    'queue_info_is_enabled' => false,
                    'queue_info_get_queue_name' => 'queue_name',
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 'command',
                    'repository_get_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => [],
                ],
                'calls' => [
                    'config_get_queues' => 1,
                    'config_is_enabled' => 1,
                    'json_unserialize' => 1,
                    'repository_create_queue_info' => 1,
                    'queue_info_is_enabled' => 1,
                    'queue_info_get_queue_name' => 0,
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 0,
                    'repository_get_active_consumers' => 0,
                    'queue_info_set_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => 0,
                    'queue_info_set_messages_in_queue' => 0,
                    'repository_create_consumers' => 0,
                ]
            ],
            'shouldCreateConsumers' => [
                'argsMock' => [
                    'config_get_queues' => 'queues',
                    'config_is_enabled' => true,
                    'json_unserialize' => [
                        ['queue']
                    ],
                    'queue_info_is_enabled' => true,
                    'queue_info_get_queue_name' => 'queue_name',
                    'queue_info_get_max_messages_to_read' => 0,
                    'helper_build_start_consumers_command' => 'command',
                    'repository_get_active_consumers' => 0,
                    'repository_get_rabbit_queue_by_name' => ['messages' => 0],
                ],
                'calls' => [
                    'config_get_queues' => 1,
                    'config_is_enabled' => 1,
                    'json_unserialize' => 1,
                    'repository_create_queue_info' => 1,
                    'queue_info_is_enabled' => 1,
                    'queue_info_get_queue_name' => 1,
                    'queue_info_get_max_messages_to_read' => 1,
                    'helper_build_start_consumers_command' => 1,
                    'repository_get_active_consumers' => 1,
                    'queue_info_set_active_consumers' => 1,
                    'repository_get_rabbit_queue_by_name' => 1,
                    'queue_info_set_messages_in_queue' => 1,
                    'repository_create_consumers' => 1,
                ]
            ]
        ];
    }

    /**
     * TestCreateQueueInfo method
     *
     * @return void
     */
    public function testCreateQueueInfo()
    {
        // Arrange
        $queueInfo = [];
        $expectedResult = $this->queueInfoMock;
        $this->repositoryMock
            ->expects($this->once())
            ->method('createQueueInfo')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->createQueueInfo($queueInfo);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetActiveConsumers method
     *
     * @return void
     */
    public function testGetActiveConsumers()
    {
        // Arrange
        $command = 'command';
        $expectedResult = 0;
        $this->repositoryMock
            ->expects($this->once())
            ->method('getActiveConsumers')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getActiveConsumers($command);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetRabbitQueueByName method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testGetRabbitQueueByName()
    {
        // Arrange
        $queueCode = 'queue_code';
        $expectedResult = [];
        $this->repositoryMock
            ->expects($this->once())
            ->method('getRabbitQueueByName')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getRabbitQueueByName($queueCode);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestCreateConsumers method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testCreateConsumers()
    {
        // Arrange
        $queueInfo = $this->queueInfoMock;
        $this->repositoryMock
            ->expects($this->once())
            ->method('createConsumers');

        // Act
        $this->instance->createConsumers($queueInfo);
    }

    /**
     * TestGetQueueList method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testGetQueueList()
    {
        // Arrange
        $expectedResult = [];
        $this->repositoryMock
            ->expects($this->once())
            ->method('getQueueList')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getQueueList();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
