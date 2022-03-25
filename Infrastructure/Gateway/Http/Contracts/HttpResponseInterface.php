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

interface HttpResponseInterface
{
    const CODE = 'code';
    const HEADERS = 'headers';
    const BODY = 'body';

    /**
     * GetCode method
     *
     * @return int
     */
    public function getCode(): int;

    /**
     * GetHeaders method
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * GetBody method
     *
     * @return string|null
     */
    public function getBody(): ?string;

    /**
     * GetBodyArray method
     *
     * @return array
     */
    public function getBodyArray(): array;
}
