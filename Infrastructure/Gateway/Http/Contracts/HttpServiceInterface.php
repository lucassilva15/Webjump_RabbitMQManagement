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

namespace Webjump\RabbitMQManagement\Infrastructure\Gateway\Http\Contracts;

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
     * @param string $method
     * @param string $path
     * @param array $options
     *
     * @return HttpResponseInterface
     */
    public function doRequest(string $method, string $path, array $options = []): HttpResponseInterface;
}
