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

namespace Webjump\RabbitMQManagement\Test\Unit\Model\Queue;

use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;

class QueueInfoTest extends \PHPUnit\Framework\TestCase
{
    /** @var QueueInfo */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Instance
        $this->instance = new QueueInfo();
    }

    /**
     * TestIsEnabled method
     *
     * @return void
     */
    public function testEnabled()
    {
        // Arrange
        $expectedResult = true;
        $this->instance->setEnabled($expectedResult);

        // Act
        $result = $this->instance->isEnabled();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestQueueName method
     *
     * @return void
     */
    public function testQueueName()
    {
        // Arrange
        $expectedResult = 'queue_name';

        // Act
        $this->instance->setQueueName($expectedResult);
        $result = $this->instance->getQueueName();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestMaxConsumers method
     *
     * @return void
     */
    public function testMaxConsumers()
    {
        // Arrange
        $expectedResult = 10;

        // Act
        $this->instance->setMaxConsumers($expectedResult);
        $result = $this->instance->getMaxConsumers();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestMaxMessagesToRead method
     *
     * @return void
     */
    public function testMaxMessagesToRead()
    {
        // Arrange
        $expectedResult = 10;

        // Act
        $this->instance->setMaxMessagesToRead($expectedResult);
        $result = $this->instance->getMaxMessagesToRead();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestActiveConsumers method
     *
     * @return void
     */
    public function testActiveConsumers()
    {
        // Arrange
        $expectedResult = 10;

        // Act
        $this->instance->setActiveConsumers($expectedResult);
        $result = $this->instance->getActiveConsumers();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestMessagesInQueue method
     *
     * @return void
     */
    public function testMessagesInQueue()
    {
        // Arrange
        $expectedResult = 10;

        // Act
        $this->instance->setMessagesInQueue($expectedResult);
        $result = $this->instance->getMessagesInQueue();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestToArray method
     *
     * @return void
     */
    public function testToArrayAndSetData()
    {
        // Arrange
        $enabled = true;
        $activeConsumers = 10;
        $maxConsumers = 11;
        $maxMessagesToRead = 12;
        $queue = 'queue_name';
        $messagesInQueue = 100000;

        $expectedResult = [
            'enabled' => $enabled,
            'active_consumers' => $activeConsumers,
            'max_consumers' => $maxConsumers,
            'max_messages_to_read' => $maxMessagesToRead,
            'queue' => $queue,
            'messages_in_queue' => $messagesInQueue
        ];

        $this->instance->setData($expectedResult);

        // Act
        $result = $this->instance->toArray();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetNeededConsumers method
     *
     * @param array $argsMock
     * @param int $expectedResult
     *
     * @return void
     *
     * @dataProvider getNeededConsumersDataProvider
     */
    public function testGetNeededConsumers(array $argsMock, int $expectedResult)
    {
        // Arrange
        $activeConsumers = $argsMock['active_consumers'];
        $maxConsumers = $argsMock['max_consumers'];
        $maxMessagesToRead = $argsMock['max_messages_to_read'];
        $messagesInQueue = $argsMock['messages_in_queue'];

        $this->instance->setActiveConsumers($activeConsumers);
        $this->instance->setMaxConsumers($maxConsumers);
        $this->instance->setMaxMessagesToRead($maxMessagesToRead);
        $this->instance->setMessagesInQueue($messagesInQueue);

        // Act
        $result = $this->instance->getNeededConsumers();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function getNeededConsumersDataProvider(): array
    {
        return [
            'shouldReturnZeroWhenMessagesInQueueIsZero' => [
                'argsMock' => [
                    'active_consumers' => 0,
                    'max_consumers' => 0,
                    'max_messages_to_read' => 10,
                    'messages_in_queue' => 0,
                ],
                'expectedResult' => 0
            ],
            'shouldReturnZeroWhenMaxMessagesToReadIsZero' => [
                'argsMock' => [
                    'active_consumers' => 0,
                    'max_consumers' => 0,
                    'max_messages_to_read' => 0,
                    'messages_in_queue' => 10,
                ],
                'expectedResult' => 0
            ],
            'shouldReturnMaxConsumersWhenNeededConsumersIsAbove' => [
                'argsMock' => [
                    'active_consumers' => 0,
                    'max_consumers' => 10,
                    'max_messages_to_read' => 10000,
                    'messages_in_queue' => 10000000,
                ],
                'expectedResult' => 10
            ],
            'shouldReturnNeededConsumersWhenMaxConsumersIsAbove' => [
                'argsMock' => [
                    'active_consumers' => 0,
                    'max_consumers' => 10,
                    'max_messages_to_read' => 10000,
                    'messages_in_queue' => 50000,
                ],
                'expectedResult' => 5
            ]
        ];
    }
}
