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

namespace Webjump\RabbitMQManagement\Model\Queue\Commands;

use Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Client\ZendClient;
use Zend_Http_Client;

class GetRabbitQueueByName
{
    const PATH = '/api/queues/%2F/';

    /** @var ZendClient */
    private $client;

    /**
     * GetRabbitQueue constructor.
     *
     * @param ZendClient $client
     */
    public function __construct(ZendClient $client)
    {
        $this->client = $client;
    }

    /**
     * Execute method
     *
     * @param string $queueCode
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(string $queueCode): array
    {
        $path = self::PATH . $queueCode;
        $response = $this->client->doRequest(Zend_Http_Client::GET, $path);
        return $response->getBodyArray();
    }
}
