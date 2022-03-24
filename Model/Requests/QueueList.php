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
use Webjump\RabbitMQManagement\Api\HttpServiceInterface;
use Webjump\RabbitMQManagement\Model\Http\AbstractHttpRequest;
use Zend_Http_Client;

final class QueueList extends AbstractHttpRequest implements HttpServiceInterface
{
    const RESOURCE = '/api/queues';

    /**
     * GetEndpoint method
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEndpoint(): string
    {
        return $this->generateEndpoint(self::RESOURCE);
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
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function doRequest(): HttpResponseInterface
    {
        return $this->httpClient->doRequest($this);
    }
}
