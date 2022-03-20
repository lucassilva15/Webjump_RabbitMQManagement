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

namespace Webjump\RabbitMQManagement\Api;

use Webjump\RabbitMQManagement\Api\Data\HttpResponseInterface;

interface HttpClientInterface
{
    /**
     * DoRequest method
     *
     * @param HttpServiceInterface $service
     *
     * @return HttpResponseInterface
     */
    public function doRequest(HttpServiceInterface $service): HttpResponseInterface;
}
