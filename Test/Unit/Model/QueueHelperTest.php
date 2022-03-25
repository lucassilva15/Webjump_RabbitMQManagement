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

namespace Webjump\RabbitMQManagement\Test\Unit\Model;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessFactory;
use Webjump\RabbitMQManagement\Model\Queue\Helper;

class QueueHelperTest extends \PHPUnit\Framework\TestCase
{
    /** @var ProcessFactory */
    private $processFactoryMock;

    /** @var Process */
    private $processMock;

    /** @var Helper */
    private $instance;

    /**
     * @inheirtDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->processFactoryMock = $this->createMock(ProcessFactory::class);

        // Others
        $this->processMock = $this->createMock(Process::class);

        // Instance
        $this->instance = new Helper($this->processFactoryMock);
    }

    /**
     * TestCalculateNeededConsumers method
     *
     * @param array $argsMock
     * @param int $expectedResult
     *
     * @return void
     *
     * @dataProvider calculateNeededConsumersDataProvider
     */
    public function testCalculateNeededConsumers(array $argsMock, int $expectedResult)
    {
        // Assert
        $queueMessages = $argsMock['queueMessages'];
        $maxConsumers = $argsMock['maxConsumers'];
        $messagesByConsumer = $argsMock['messagesByConsumer'];

        // Act
        $result = $this->instance->calculateNeededConsumers($queueMessages, $maxConsumers, $messagesByConsumer);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function calculateNeededConsumersDataProvider(): array
    {
        return [
            'shouldReturnMaxConsumersValue' => [
                'argsMock' => [
                    'queueMessages' => 200000,
                    'maxConsumers' => 10,
                    'messagesByConsumer' => 10000,
                ],
                'expectedResult' => 10
            ],
            'shouldReturnNeededConsumersValue' => [
                'argsMock' => [
                    'queueMessages' => 50000,
                    'maxConsumers' => 10,
                    'messagesByConsumer' => 10000,
                ],
                'expectedResult' => 5
            ]
        ];
    }
}
