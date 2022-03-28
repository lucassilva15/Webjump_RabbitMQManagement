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

use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\ZendClient;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Response;
use Webjump\RabbitMQManagement\Model\Queue\Commands\GetRabbitQueueList;

class GetRabbitQueueListTest extends \PHPUnit\Framework\TestCase
{
    /** @var ZendClient */
    private $clientMock;

    /** @var Response */
    private $responseMock;

    /** @var GetRabbitQueueList */
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
        $this->instance = new GetRabbitQueueList($this->clientMock);
    }

    /**
     * TestExecuteWhenItemsIsReturned method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecuteWhenItemsIsReturned()
    {
        // Arrange
        $items = [
            ['name' => 'queue.name']
        ];
        $expectedResult = [
            [
                'label' => 'queue.name',
                'value' => 'queue.name'
            ]
        ];

        $this->clientMock
            ->expects($this->once())
            ->method('doRequest')
            ->willReturn($this->responseMock);
        $this->responseMock
            ->expects($this->once())
            ->method('getBodyArray')
            ->willReturn($items);

        // Act
        $result = $this->instance->execute();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestExecuteWhenItemsIsEmpty method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecuteWhenItemsIsEmpty(){
        // Arrange
        $items = [];
        $expectedResult = [];

        $this->clientMock
            ->expects($this->once())
            ->method('doRequest')
            ->willReturn($this->responseMock);
        $this->responseMock
            ->expects($this->once())
            ->method('getBodyArray')
            ->willReturn($items);

        // Act
        $result = $this->instance->execute();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
