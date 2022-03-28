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

use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateQueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetActiveConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueByName;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueList;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\Repository;

class RepositoryTest extends \PHPUnit\Framework\TestCase
{
    /** @var CreateQueueInfo */
    private $createQueueInfoCommand;

    /** @var GetActiveConsumers */
    private $getActiveConsumersCommandMock;

    /** @var GetRabbitQueueByNameTest */
    private $getRabbitQueueByNameCommandMock;

    /** @var CreateConsumers */
    private $createConsumersCommandMock;

    /** @var GetRabbitQueueList */
    private $getQueueListCommandMock;

    /** @var QueueInfo */
    private $queueInfoMock;

    /** @var Repository */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->createQueueInfoCommand = $this->createMock(CreateQueueInfo::class);
        $this->getActiveConsumersCommandMock = $this->createMock(GetActiveConsumers::class);
        $this->getRabbitQueueByNameCommandMock = $this->createMock(GetRabbitQueueByName::class);
        $this->createConsumersCommandMock = $this->createMock(CreateConsumers::class);
        $this->getQueueListCommandMock = $this->createMock(GetRabbitQueueList::class);

        // Others
        $this->queueInfoMock = $this->createMock(QueueInfo::class);

        // Instance
        $this->instance = new Repository(
            $this->createQueueInfoCommand,
            $this->getActiveConsumersCommandMock,
            $this->getRabbitQueueByNameCommandMock,
            $this->createConsumersCommandMock,
            $this->getQueueListCommandMock
        );
    }

    /**
     * TestCreateQueueInfo method
     *
     * @return void
     */
    public function testCreateQueueInfo()
    {
        // Arrange
        $queueInfoData = [];
        $expectedResult = $this->queueInfoMock;
        $this->createQueueInfoCommand
            ->expects($this->once())
            ->method('execute')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->createQueueInfo($queueInfoData);

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
        $this->getActiveConsumersCommandMock
            ->expects($this->once())
            ->method('execute')
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
        $this->getRabbitQueueByNameCommandMock
            ->expects($this->once())
            ->method('execute')
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
        $this->createConsumersCommandMock
            ->expects($this->once())
            ->method('execute');

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
        $this->getQueueListCommandMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getQueueList();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
