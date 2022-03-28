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

use Magento\Framework\Amqp\Config;
use Webjump\RabbitMQManagement\Model\AmqpConfig;

class AmqpConfigTest extends \PHPUnit\Framework\TestCase
{
    /** @var Config */
    private $configMock;

    /** @var AmqpConfig */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->configMock = $this->createMock(Config::class);

        // Instance
        $this->instance = new AmqpConfig($this->configMock);
    }

    /**
     * TestGetHost method
     *
     * @return void
     */
    public function testGetHost()
    {
        // Arrange
        $expectedResult = 'host';
        $this->configMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getHost();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetPort method
     *
     * @return void
     */
    public function testGetPort()
    {
        // Arrange
        $expectedResult = 'port';
        $this->configMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getPort();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetUsername()
    {
        // Arrange
        $expectedResult = 'username';
        $this->configMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getUsername();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetPassword method
     *
     * @return void
     */
    public function testGetPassword()
    {
        // Arrange
        $expectedResult = 'password';
        $this->configMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getPassword();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetSsl method
     *
     * @return void
     */
    public function testGetSsl()
    {
        // Arrange
        $expectedResult = 'ssl';
        $this->configMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getSsl();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
