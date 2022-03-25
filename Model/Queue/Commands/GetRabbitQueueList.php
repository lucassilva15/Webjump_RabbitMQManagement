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

class GetRabbitQueueList
{
    const PATH = '/api/queues';

    /** @var ZendClient */
    private $client;

    /**
     * GetQueueList constructor.
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
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): array
    {
        $response = $this->client->doRequest(\Zend_Http_Client::GET, self::PATH);
        $items = $response->getBodyArray();

        $queues = [];
        if (empty($items) === true) {
            return $queues;
        }

        foreach ($items as $item) {
            $name = $item['name'];
            $queues[] = ['label' => $name, 'value' => $name];
        }

        return $queues;
    }
}
