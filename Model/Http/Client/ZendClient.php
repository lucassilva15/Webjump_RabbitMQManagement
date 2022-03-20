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

namespace Webjump\RabbitMQManagement\Model\Http\Client;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;
use Psr\Log\LoggerInterface;
use Webjump\RabbitMQManagement\Api\Data\HttpResponseInterface;
use Webjump\RabbitMQManagement\Api\HttpClientInterface;
use Webjump\RabbitMQManagement\Api\HttpServiceInterface;
use Webjump\RabbitMQManagement\Model\Http\Data\ResponseFactory;
use Zend_Http_Client;
use Zend_Http_Client_Exception;

class ZendClient implements HttpClientInterface
{
    /** @var ZendClientFactory */
    private $zendClientFactory;

    /** @var ResponseFactory */
    private $httpResponseFactory;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ZendClient constructor.
     *
     * @param ZendClientFactory $zendClientFactory
     * @param ResponseFactory $httpResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ZendClientFactory $zendClientFactory,
        ResponseFactory   $httpResponseFactory,
        LoggerInterface   $logger
    )
    {
        $this->zendClientFactory = $zendClientFactory;
        $this->httpResponseFactory = $httpResponseFactory;
        $this->logger = $logger;
    }

    /**
     * DoRequest method
     *
     * @param HttpServiceInterface $service
     *
     * @return HttpResponseInterface
     * @throws LocalizedException
     */
    public function doRequest(HttpServiceInterface $service): HttpResponseInterface
    {
        $client = $this->zendClientFactory->create();
        $headers = $service->getHeaders();

        try {
            $client->setUri($this->getEndpoint($service));
            $client->setMethod($service->getMethod());
            $client->setHeaders($service->getHeaders());

            $this->logger->info($this->getEndpoint($service), [$service->getData()]);
            $this->logger->info('headers', $headers);

            $result = $client->request();
        } catch (Zend_Http_Client_Exception $e) {
            $this->logger->error($e->getMessage());
            throw new LocalizedException(__('Resource temporarily unavailable'));
        }

        $this->logger->info($result->getBody());

        return $this->httpResponseFactory->create(
            [
                'data' => [
                    'code' => $result->getStatus(),
                    'body' => $result->getBody(),
                    'headers' => $result->getHeaders()
                ]
            ]
        );
    }

    /**
     * GetEndpoint method
     *
     * @param HttpServiceInterface $service
     *
     * @return string
     */
    private function getEndpoint(HttpServiceInterface $service): string
    {
        if ($service->getMethod() === Zend_Http_Client::GET && empty($service->getData()) === false) {
            return $service->getEndpoint() . '?' . http_build_query($service->getData());
        }

        return $service->getEndpoint();
    }
}
