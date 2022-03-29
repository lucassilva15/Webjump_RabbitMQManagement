<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Endpoint;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\Builders\Headers;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Contracts\HttpClientInterface;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Contracts\HttpResponseInterface;
use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\ResponseFactory;
use Zend_Http_Client_Exception;

class ZendClient implements HttpClientInterface
{
    /** @var ZendClientFactory */
    private $zendClientFactory;

    /** @var ResponseFactory */
    private $httpResponseFactory;

    /** @var LoggerInterface */
    private $logger;

    /** @var Endpoint */
    private $endpointBuilder;

    /** @var Headers */
    private $headersBuilder;

    /** @var Json */
    private $json;

    /**
     * ZendClient constructor.
     *
     * @param ZendClientFactory $zendClientFactory
     * @param ResponseFactory $httpResponseFactory
     * @param LoggerInterface $logger
     * @param Endpoint $endpointBuilder
     * @param Headers $headersBuilder
     * @param Json $json
     */
    public function __construct(
        ZendClientFactory $zendClientFactory,
        ResponseFactory   $httpResponseFactory,
        LoggerInterface   $logger,
        Endpoint          $endpointBuilder,
        Headers           $headersBuilder,
        Json              $json
    )
    {
        $this->zendClientFactory = $zendClientFactory;
        $this->httpResponseFactory = $httpResponseFactory;
        $this->logger = $logger;
        $this->endpointBuilder = $endpointBuilder;
        $this->headersBuilder = $headersBuilder;
        $this->json = $json;
    }

    /**
     * DoRequest method
     *
     * @param string $method
     * @param string $path
     * @param array $options
     *
     * @return HttpResponseInterface
     * @throws LocalizedException
     */
    public function doRequest(string $method, string $path, array $options = []): HttpResponseInterface
    {
        $client = $this->zendClientFactory->create();
        $uri = $this->endpointBuilder->build($path);
        $headers = $this->headersBuilder->build($options['headers'] ?? []);

        try {
            $client->setUri($uri);
            $client->setMethod($method);
            $client->setHeaders($headers);

            $requestData = [
                'method' => $method,
                'uri' => $uri,
                'options' => $options
            ];

            $this->logger->info('Request: ' . $this->json->serialize($requestData));

            $result = $client->request();
        } catch (Zend_Http_Client_Exception $e) {
            $this->logger->error('Response Error: ' . $e->getMessage());
            throw new LocalizedException(__('Resource temporarily unavailable'));
        }

        $responseData = [
            'code' => $result->getStatus(),
            'body' => $result->getBody(),
            'headers' => $result->getHeaders()
        ];

        $this->logger->info('Response: ' . $this->json->serialize($responseData));

        return $this->httpResponseFactory->create([
            'data' => $responseData]
        );
    }
}
