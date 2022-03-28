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

namespace Webjump\RabbitMQManagement\Test\Unit\Infrastructure\Gateway\Http\Client\Builders;

use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Headers;
use Webjump\RabbitMQManagement\Model\AmqpConfig;

class HeadersTest extends \PHPUnit\Framework\TestCase
{
    /** @var AmqpConfig */
    private $amqpConfigMock;

    /** @var Headers */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->amqpConfigMock = $this->createMock(AmqpConfig::class);

        // Instance
        $this->instance = new Headers($this->amqpConfigMock);
    }

    /**
     * TestBuild method
     *
     * @return void
     */
    public function testBuild()
    {
        // Arrange
        $customHeaders = [];
        $expectedResult = [
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Authorization' => 'Basic dXNlcm5hbWU6cGFzc3dvcmQ=',
        ];

        $this->amqpConfigMock
            ->expects($this->once())
            ->method('getUsername')
            ->willReturn('username');
        $this->amqpConfigMock
            ->expects($this->once())
            ->method('getPassword')
            ->willReturn('password');

        // Act
        $result = $this->instance->build($customHeaders);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
