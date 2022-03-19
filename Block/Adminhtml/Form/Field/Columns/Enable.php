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

namespace Webjump\RabbitMQManagement\Block\Adminhtml\Form\Field\Columns;

use Magento\Framework\View\Element\Html\Select;

class Enable extends Select
{
    /**
     * SetInputName method
     *
     * @param $value
     *
     * @return Enable
     */
    public function setInputName($value): Enable
    {
        return $this->setData('name', $value);
    }

    /**
     * SetInputId method
     *
     * @param $value
     *
     * @return Enable
     */
    public function setInputId($value): Enable
    {
        return $this->setId($value);
    }

    /**
     * _toHtml method
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * GetSourceOptions method
     *
     * @return string[][]
     */
    private function getSourceOptions(): array
    {
        return [
            ['label' => 'Yes', 'value' => '1'],
            ['label' => 'No', 'value' => '0'],
        ];
    }
}
