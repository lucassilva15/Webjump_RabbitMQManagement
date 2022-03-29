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

namespace Webjump\RabbitMQManagement\Test\Unit\Infrastructure\Gateway\Http;

use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Response;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /** @var Json */
    private $jsonMock;

    /** @var array */
    private $data;

    /** @var Response */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->jsonMock = $this->createMock(Json::class);
        $this->data = [
            'code' => 12,
            'headers' => [],
            'body' => 'body'
        ];

        // Instance
        $this->instance = new Response($this->jsonMock, $this->data);
    }

    /**
     * TestGetCode method
     *
     * @return void
     */
    public function testGetCode()
    {
        // Arrange
        $expectedResult = $this->data['code'];

        // Act
        $result = $this->instance->getCode();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetHeaders method
     *
     * @return void
     */
    public function testGetHeaders()
    {
        // Arrange
        $expectedResult = $this->data['headers'];

        // Act
        $result = $this->instance->getHeaders();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetBody method
     *
     * @return void
     */
    public function testGetBody()
    {
        // Arrange
        $expectedResult = $this->data['body'];

        // Act
        $result = $this->instance->getBody();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * TestGetBodyArray method
     *
     * @param array $argsMock
     * @param array $calls
     * @param array $expectedResult
     *
     * @return void
     *
     * @dataProvider getBodyArrayDataProvider
     */
    public function testGetBodyArray(array $argsMock, array $calls, array $expectedResult)
    {
        // Arrange
        $this->jsonMock
            ->expects($this->exactly($calls['json_unserialize']))
            ->method('unserialize')
            ->willReturn($argsMock['json_unserialize']);
        $instance = $this->getMockBuilder(Response::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->jsonMock, []])
            ->disableArgumentCloning()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getBody'])
            ->getMock();

        $instance
            ->expects($this->exactly($calls['instance_get_body']))
            ->method('getBody')
            ->willReturn($argsMock['instance_get_body']);

        // Act
        $result = $instance->getBodyArray();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function getBodyArrayDataProvider(): array
    {
        return [
            'shouldReturnArrayEmpty' => [
                'argsMock' => [
                    'instance_get_body' => '',
                    'json_unserialize' => ['json']
                ],
                'calls' => [
                    'instance_get_body' => 1,
                    'json_unserialize' => 0
                ],
                'expectedResult' => []
            ],
            'shouldReturnJsonUnserialize' => [
                'argsMock' => [
                    'instance_get_body' => 'Not Empty',
                    'json_unserialize' => ['json']
                ],
                'calls' => [
                    'instance_get_body' => 2,
                    'json_unserialize' => 1
                ],
                'expectedResult' => ['json']
            ]
        ];
    }
}
