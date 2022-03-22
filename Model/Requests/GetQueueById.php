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

namespace Webjump\RabbitMQManagement\Model\Requests;

use Webjump\RabbitMQManagement\Api\Data\HttpResponseInterface;
use Webjump\RabbitMQManagement\Api\HttpClientInterface;
use Webjump\RabbitMQManagement\Api\HttpServiceInterface;
use Webjump\RabbitMQManagement\Model\AmqpConfig;
use Webjump\RabbitMQManagement\Model\Http\AbstractHttpRequest;
use Webjump\RabbitMQManagement\Model\Http\Builders\Endpoint;
use Zend_Http_Client;

final class GetQueueById extends AbstractHttpRequest implements HttpServiceInterface
{
    const RESOURCE = '/api/queues/%2F/';

    /** @var string */
    private $queueCode;

    /**
     * GetQueueById constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param Endpoint $endpointBuilder
     * @param AmqpConfig $amqpConfig
     * @param string $queueCode
     * @param array $data
     */
    public function __construct(
        HttpClientInterface $httpClient,
        Endpoint            $endpointBuilder,
        AmqpConfig          $amqpConfig,
        string              $queueCode,
        array               $data = []
    )
    {
        $this->queueCode = $queueCode;
        parent::__construct($httpClient, $endpointBuilder, $amqpConfig, $data);
    }

    /**
     * GetEndpoint method
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEndpoint(): string
    {
        return $this->generateEndpoint(self::RESOURCE . $this->queueCode);
    }

    /**
     * GetMethod method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return Zend_Http_Client::GET;
    }

    /**
     * DoRequest method
     *
     * @return HttpResponseInterface
     */
    public function doRequest(): HttpResponseInterface
    {
        return $this->httpClient->doRequest($this);
    }
}
