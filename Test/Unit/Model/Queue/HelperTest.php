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

use Symfony\Component\Process\PhpExecutableFinder;
use Webjump\RabbitMQManagement\Model\Queue\Helper;

class HelperTest extends \PHPUnit\Framework\TestCase
{
    /** @var PhpExecutableFinder */
    private $phpExecutableFinderMock;

    /** @var Helper */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->phpExecutableFinderMock = $this->createMock(PhpExecutableFinder::class);

        // Instance
        $this->instance = new Helper($this->phpExecutableFinderMock);
    }

    /**
     * TestBuildStartConsumersCommand method
     *
     * @return void
     */
    public function testBuildStartConsumersCommand()
    {
        // Arrange
        $maxMessagesToRead = 10000;
        $queueName = 'queue.name';
        $expectedResult = "php /var/www/html/bin/magento queue:consumers:start --max-messages=$maxMessagesToRead $queueName";

        $this->phpExecutableFinderMock
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        // Act
        $result = $this->instance->buildStartConsumersCommand($maxMessagesToRead, $queueName);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
