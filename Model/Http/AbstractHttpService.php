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
use Webjump\RabbitMQManagement\Model\AmqpHelper;

abstract class AbstractHttpService
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var AmqpHelper */
    private $amqpHelper;

    /** @var array */
    private $data;

    /**
     * AbstractHttpService constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param AmqpHelper $amqpHelper
     * @param array $data
     */
    public function __construct(
        HttpClientInterface $httpClient,
        AmqpHelper          $amqpHelper,
        array               $data = []
    ) {
        $this->httpClient = $httpClient;
        $this->amqpHelper = $amqpHelper;
        $this->data = $data;
    }

    /**
     * GenerateEndpoint method
     *
     * @param string $resource
     *
     * @return string
     */
    protected function generateEndpoint(string $resource): string
    {
        return "http://{$this->amqpHelper->getHost()}:15672$resource";
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
        $username = $this->amqpHelper->getUsername();
        $password = $this->amqpHelper->getPassword();
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
