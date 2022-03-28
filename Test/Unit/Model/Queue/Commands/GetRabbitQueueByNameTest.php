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

use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\ZendClient;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Response;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueByName;

class GetRabbitQueueByNameTest extends \PHPUnit\Framework\TestCase
{
    /** @var ZendClient */
    private $clientMock;

    /** @var Response */
    private $responseMock;

    /** @var GetRabbitQueueByName */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->clientMock = $this->createMock(ZendClient::class);

        // Others
        $this->responseMock = $this->createMock(Response::class);

        // Instance
        $this->instance = new GetRabbitQueueByName($this->clientMock);
    }

    /**
     * TestExecute method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecute()
    {
        // Arrange
        $queueCode = 'queue.code';
        $expectedResult = [];
        $this->clientMock
            ->expects($this->once())
            ->method('doRequest')
            ->willReturn($this->responseMock);
        $this->responseMock
            ->expects($this->once())
            ->method('getBodyArray')
            ->willReturn($expectedResult);

        // Act
        $result = $this->instance->execute($queueCode);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
