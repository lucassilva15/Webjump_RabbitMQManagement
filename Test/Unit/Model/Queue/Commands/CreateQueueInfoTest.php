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

use Webjump\RabbitMQManagement\Model\Queue\Commands\CreateQueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfo;
use Webjump\RabbitMQManagement\Model\Queue\QueueInfoFactory;

class CreateQueueInfoTest extends \PHPUnit\Framework\TestCase
{
    /** @var QueueInfoFactory */
    private $queueInfoFactoryMock;

    /** @var QueueInfo */
    private $queueInfoMock;

    /** @var CreateQueueInfo */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->queueInfoFactoryMock = $this->createMock(QueueInfoFactory::class);

        // Others
        $this->queueInfoMock = $this->createMock(QueueInfo::class);

        // Instance
        $this->instance = new CreateQueueInfo($this->queueInfoFactoryMock);
    }

    /**
     * TestExecute method
     *
     * @return void
     */
    public function testExecute()
    {
        // Arrange
        $expectedResult = $this->queueInfoMock;
        $queueData = [];
        $this->queueInfoFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($expectedResult);
        $this->queueInfoMock
            ->expects($this->once())
            ->method('setData');

        // Act
        $result = $this->instance->execute($queueData);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
