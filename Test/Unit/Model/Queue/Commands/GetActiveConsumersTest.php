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

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessFactory;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetActiveConsumers;

class GetActiveConsumersTest extends \PHPUnit\Framework\TestCase
{
    /** @var ProcessFactory */
    private $processFactoryMock;

    /** @var Process */
    private $processMock;

    /** @var GetActiveConsumers */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->processFactoryMock = $this->createMock(ProcessFactory::class);

        // Others
        $this->processMock = $this->createMock(Process::class);

        // Instance
        $this->instance = new GetActiveConsumers($this->processFactoryMock);
    }

    /**
     * TestExecuteWithSuccessFully method
     *
     * @return void
     */
    public function testExecuteWithSuccessFully()
    {
        // Arrange
        $command = 'command';
        $expectedResult = 2;

        $this->processFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->processMock);
        $this->processMock
            ->expects($this->once())
            ->method('run');
        $this->processMock
            ->expects($this->once())
            ->method('isSuccessful')
            ->willReturn(true);
        $this->processMock
            ->expects($this->once())
            ->method('getOutput')
            ->willReturn('command_command');

        // Act
        $result = $this->instance->execute($command);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestExecuteWithCommandException method
     *
     * @return void
     */
    public function testExecuteWithCommandException(){
        // Arrange
        $command = 'command';

        $this->processFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->processMock);
        $this->processMock
            ->expects($this->once())
            ->method('run');
        $this->processMock
            ->expects($this->exactly(2))
            ->method('isSuccessful')
            ->willReturn(false);

        $this->expectException(ProcessFailedException::class);

        // Act
        $this->instance->execute($command);
    }
}
