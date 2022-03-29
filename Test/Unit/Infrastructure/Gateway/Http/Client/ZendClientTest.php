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

namespace Webjump\RabbitMQManagement\Test\Unit\Infrastructure\Gateway\Http\Client;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Logger\LoggerProxy;
use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Endpoint;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Headers;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\ZendClient;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Response;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\ResponseFactory;
use Zend_Http_Response;

class ZendClientTest extends \PHPUnit\Framework\TestCase
{
    /** @var ZendClientFactory */
    private $zendClientFactoryMock;

    /** @var ResponseFactory */
    private $httpResponseFactoryMock;

    /** @var LoggerProxy */
    private $loggerMock;

    /** @var Endpoint */
    private $endpointBuilderMock;

    /** @var Headers */
    private $headersBuilderMock;

    /** @var Json */
    private $jsonMock;

    /** @var ZendClient */
    private $zendClientMock;

    /** @var Zend_Http_Response */
    private $zendHttpResponse;

    /** @var Response */
    private $httpResponseMock;

    /** @var ZendClient */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->zendClientFactoryMock = $this->createMock(ZendClientFactory::class);
        $this->httpResponseFactoryMock = $this->createMock(ResponseFactory::class);
        $this->loggerMock = $this->createMock(LoggerProxy::class);
        $this->endpointBuilderMock = $this->createMock(Endpoint::class);
        $this->headersBuilderMock = $this->createMock(Headers::class);
        $this->jsonMock = $this->createMock(Json::class);

        // Others
        $this->zendClientMock = $this->getMockBuilder(ZendClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['setUri', 'setMethod', 'setHeaders', 'request'])
            ->getMock();
        $this->zendHttpResponse = $this->createMock(Zend_Http_Response::class);
        $this->httpResponseMock = $this->createMock(Response::class);

        // Instance
        $this->instance = new ZendClient(
            $this->zendClientFactoryMock,
            $this->httpResponseFactoryMock,
            $this->loggerMock,
            $this->endpointBuilderMock,
            $this->headersBuilderMock,
            $this->jsonMock
        );
    }

    /**
     * TestDoRequest method
     *
     * @param array $argsMock
     * @param array $calls
     *
     * @return void
     * @throws LocalizedException
     *
     * @dataProvider doRequestDataProvider
     */
    public function testDoRequest(array $argsMock, array $calls)
    {
        // Arrange
        $expectedResult = $this->httpResponseMock;

        $method = 'method';
        $path = 'path';
        $options = [];

        $this->zendClientFactoryMock
            ->expects($this->exactly($calls['zend_client_factory_create']))
            ->method('create')
            ->willReturn($this->zendClientMock);
        $this->endpointBuilderMock
            ->expects($this->exactly($calls['endpoint_builder_build']))
            ->method('build')
            ->willReturn('endpoint');
        $this->headersBuilderMock
            ->expects($this->exactly($calls['headers_builder_build']))
            ->method('build')
            ->willReturn([]);
        $this->zendClientMock
            ->expects($this->exactly($calls['zend_client_set_uri']))
            ->method('setUri');
        $this->zendClientMock
            ->expects($this->exactly($calls['zend_client_set_method']))
            ->method('setMethod');
        $this->zendClientMock
            ->expects($this->exactly($calls['zend_client_set_headers']))
            ->method('setHeaders');
        $this->jsonMock
            ->expects($this->exactly($calls['json_serialize']))
            ->method('serialize')
            ->willReturn('');
        $this->loggerMock
            ->expects($this->exactly($calls['logger_info']))
            ->method('info');

        if ($argsMock['throw_exception'] === true) {
            $this->zendClientMock
                ->expects($this->exactly($calls['zend_client_set_method']))
                ->method('request')
                ->willThrowException(new \Zend_Http_Client_Adapter_Exception());
            $this->loggerMock
                ->expects($this->exactly(1))
                ->method('error');
            $this->expectException(LocalizedException::class);
        }

        if ($argsMock['throw_exception'] === false) {
            $this->zendClientMock
                ->expects($this->exactly($calls['zend_client_request']))
                ->method('request')
                ->willReturn($this->zendHttpResponse);
        }

        $this->zendHttpResponse
            ->expects($this->exactly($calls['zend_http_response_get_status']))
            ->method('getStatus')
            ->willReturn(1);
        $this->zendHttpResponse
            ->expects($this->exactly($calls['zend_http_response_get_body']))
            ->method('getBody')
            ->willReturn('body');
        $this->zendHttpResponse
            ->expects($this->exactly($calls['zend_http_response_get_headers']))
            ->method('getHeaders')
            ->willReturn([]);
        $this->httpResponseFactoryMock
            ->expects($this->exactly($calls['http_response_factory_create']))
            ->method('create')
            ->willReturn($this->httpResponseMock);

        // Act
        $result = $this->instance->doRequest($method, $path, $options);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function doRequestDataProvider(): array
    {
        return [
            'shouldReturnResponseObject' => [
                'argsMock' => [
                    'throw_exception' => false
                ],
                'calls' => [
                    'zend_client_factory_create' => 1,
                    'endpoint_builder_build' => 1,
                    'headers_builder_build' => 1,
                    'zend_client_set_uri' => 1,
                    'zend_client_set_method' => 1,
                    'zend_client_set_headers' => 1,
                    'json_serialize' => 2,
                    'logger_info' => 2,
                    'zend_client_request' => 1,
                    'zend_http_response_get_status' => 1,
                    'zend_http_response_get_body' => 1,
                    'zend_http_response_get_headers' => 1,
                    'http_response_factory_create' => 1,
                ]
            ],
            'shouldThrowExceptionWhenFails' => [
                'argsMock' => [
                    'throw_exception' => true
                ],
                'calls' => [
                    'zend_client_factory_create' => 1,
                    'endpoint_builder_build' => 1,
                    'headers_builder_build' => 1,
                    'zend_client_set_uri' => 1,
                    'zend_client_set_method' => 1,
                    'zend_client_set_headers' => 1,
                    'json_serialize' => 1,
                    'logger_info' => 1,
                    'zend_client_request' => 1,
                    'zend_http_response_get_status' => 0,
                    'zend_http_response_get_body' => 0,
                    'zend_http_response_get_headers' => 0,
                    'http_response_factory_create' => 0,
                ]
            ]
        ];
    }
}
