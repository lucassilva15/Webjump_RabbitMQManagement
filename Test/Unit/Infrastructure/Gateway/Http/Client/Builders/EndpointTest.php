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

use Magento\Framework\Exception\LocalizedException;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Endpoint;
use Webjump\RabbitMQManagement\Model\AmqpConfig;
use Webjump\RabbitMQManagement\Model\Config;

class EndpointTest extends \PHPUnit\Framework\TestCase
{
    /** @var AmqpConfig */
    private $amqpConfigMock;

    /** @var Config */
    private $configMock;

    /** @var Endpoint */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->amqpConfigMock = $this->createMock(AmqpConfig::class);
        $this->configMock = $this->createMock(Config::class);

        // Instance
        $this->instance = new Endpoint($this->amqpConfigMock, $this->configMock);
    }

    /**
     * TestBuild method
     *
     * @param array $argsMock
     * @param array $calls
     * @param string $expectedResult
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @dataProvider buildDataProvider
     */
    public function testBuild(array $argsMock, array $calls, string $expectedResult)
    {
        // Arrange
        $resource = '/resource';

        $this->amqpConfigMock
            ->expects($this->exactly($calls['amqp_config_get_ssl']))
            ->method('getSsl')
            ->willReturn($argsMock['amqp_config_get_ssl']);
        $this->amqpConfigMock
            ->expects($this->exactly($calls['amqp_config_get_host']))
            ->method('getHost')
            ->willReturn($argsMock['amqp_config_get_host']);
        $this->configMock
            ->expects($this->exactly($calls['config_get_service_port']))
            ->method('getServicePort')
            ->willReturn($argsMock['config_get_service_port']);

        if(empty($argsMock['amqp_config_get_host'])){
            $this->expectException(LocalizedException::class);
        }

        if(empty($argsMock['config_get_service_port'])){
            $this->expectException(LocalizedException::class);
        }

        // Act
        $result = $this->instance->build($resource);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function buildDataProvider(): array
    {
        return [
            'shouldReturnHttpProtocol' => [
                'argsMock' => [
                    'amqp_config_get_ssl' => null,
                    'amqp_config_get_host' => 'host',
                    'config_get_service_port' => 'port',
                ],
                'calls' => [
                    'amqp_config_get_ssl' => 1,
                    'amqp_config_get_host' => 1,
                    'config_get_service_port' => 1,
                ],
                'expectedResult' => 'http://host:port/resource'
            ],
            'shouldReturnHttpsProtocol' => [
                'argsMock' => [
                    'amqp_config_get_ssl' => 'true',
                    'amqp_config_get_host' => 'host',
                    'config_get_service_port' => 'port',
                ],
                'calls' => [
                    'amqp_config_get_ssl' => 1,
                    'amqp_config_get_host' => 1,
                    'config_get_service_port' => 1,
                ],
                'expectedResult' => 'https://host:port/resource'
            ],
            'shouldThrowExceptionWhenHostIsEmpty' => [
                'argsMock' => [
                    'amqp_config_get_ssl' => 'true',
                    'amqp_config_get_host' => '',
                    'config_get_service_port' => 'port',
                ],
                'calls' => [
                    'amqp_config_get_ssl' => 1,
                    'amqp_config_get_host' => 1,
                    'config_get_service_port' => 0,
                ],
                'expectedResult' => 'https://host:port/resource'
            ],
            'shouldThrowExceptionWhenPortIsEmpty' => [
                'argsMock' => [
                    'amqp_config_get_ssl' => 'true',
                    'amqp_config_get_host' => 'host',
                    'config_get_service_port' => '',
                ],
                'calls' => [
                    'amqp_config_get_ssl' => 1,
                    'amqp_config_get_host' => 1,
                    'config_get_service_port' => 1,
                ],
                'expectedResult' => 'https://host:port/resource'
            ]
        ];
    }
}
