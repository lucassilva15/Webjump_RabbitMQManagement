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

use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Endpoint;
use Webjump\RabbitMQManagement\Model\AmqpConfig;
use Webjump\RabbitMQManagement\Model\Config;

class EndpointTest extends \PHPUnit\Framework\TestCase
{
    /** @var AmqpConfig */
    private $amqpConfigMock;

    /** @var Config */
    private $configMock;

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

    public function testBuild(array $argsMock, array $calls){
        // Arrange
        $this->amqpConfigMock
            ->expects($this->exactly($calls['amqp_config_get_ssl']))
            ->method('getSsl')
            ->willReturn($argsMock['amqp_config_get_ssl']);

        // Act
        // Assert
    }
}
