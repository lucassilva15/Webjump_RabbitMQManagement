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

namespace Webjump\RabbitMQManagement\Model\Http\Data;

use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json;
use Webjump\RabbitMQManagement\Api\Data\HttpResponseInterface;

final class Response extends DataObject implements HttpResponseInterface
{
    /** @var Json */
    private $json;

    /**
     * Response constructor.
     *
     * @param Json $json
     * @param array $data
     */
    public function __construct(Json $json, array $data = [])
    {
        $this->json = $json;
        parent::__construct($data);
    }

    /**
     * GetCode method
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->getData(self::CODE);
    }

    /**
     * GetHeaders method
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->getData(self::HEADERS);
    }

    /**
     * GetBody method
     *
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->getData(self::BODY);
    }

    /**
     * GetBodyArray method
     *
     * @return array
     */
    public function getBodyArray(): array
    {
        if (empty($this->getBody()) === true) {
            return [];
        }

        return $this->json->unserialize($this->getBody());
    }
}
