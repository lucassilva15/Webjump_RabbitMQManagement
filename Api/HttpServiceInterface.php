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

interface HttpServiceInterface
{
    /**
     * GetEndpoint method
     *
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * GetMethod method
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * GetHeaders method
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * GetData method
     *
     * @return array
     */
    public function getData(): array;

    /**
     * DoRequest method
     *
     * @return HttpResponseInterface
     */
    public function doRequest(): HttpResponseInterface;
}
