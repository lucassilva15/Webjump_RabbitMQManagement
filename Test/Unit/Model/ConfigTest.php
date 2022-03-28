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

namespace Webjump\RabbitMQManagement\Test\Unit\Model;

use Magento\Framework\App\Config as ScopeConfig;
use Webjump\RabbitMQManagement\Model\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /** @var ScopeConfig */
    private $scopeConfigMock;

    /** @var Config */
    private $instance;

    /**
     * @inheirtDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->scopeConfigMock = $this->createMock(ScopeConfig::class);

        // Instance
        $this->instance = new Config($this->scopeConfigMock);
    }

    /**
     * TestIsEnabled method
     *
     * @return void
     */
    public function testIsEnabled()
    {
        // Arrange
        $expectedResult = true;
        $this->scopeConfigMock
            ->expects($this->once())
            ->method('isSetFlag')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->isEnabled();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetQueues method
     *
     * @return void
     */
    public function testGetQueues()
    {
        // Arrange
        $expectedResult = 'queues';
        $this->scopeConfigMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getQueues();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetServicePort method
     *
     * @return void
     */
    public function testGetServicePort(){
        // Arrange
        $expectedResult = 'port';
        $this->scopeConfigMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->getServicePort();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
