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

namespace Webjump\RabbitMQManagement\Model\Http;

use Webjump\RabbitMQManagement\Api\HttpClientInterface;
use Webjump\RabbitMQManagement\Model\AmqpConfig;
use Webjump\RabbitMQManagement\Model\Http\Builders\Endpoint;

abstract class AbstractHttpRequest
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var Endpoint */
    private $endpointBuilder;

    /** @var AmqpConfig */
    private $amqpConfig;

    /** @var array */
    private $data;

    /**
     * AbstractHttpRequest constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param Endpoint $endpointBuilder
     * @param AmqpConfig $amqpConfig
     * @param array $data
     */
    public function __construct(
        HttpClientInterface $httpClient,
        Endpoint            $endpointBuilder,
        AmqpConfig          $amqpConfig,
        array               $data = []
    )
    {
        $this->httpClient = $httpClient;
        $this->endpointBuilder = $endpointBuilder;
        $this->amqpConfig = $amqpConfig;
        $this->data = $data;
    }

    /**
     * GenerateEndpoint method
     *
     * @param string $resource
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function generateEndpoint(string $resource): string
    {
        return $this->endpointBuilder->build($resource);
    }

    /**
     * GetHeaders method
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Authorization' => sprintf('Basic %s', $this->getBasicToken())
        ];
    }

    /**
     * GetBasicToken method
     *
     * @return string
     */
    private function getBasicToken(): string
    {
        $username = $this->amqpConfig->getUsername();
        $password = $this->amqpConfig->getPassword();
        return base64_encode("$username:$password");
    }

    /**
     * GetData method
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
