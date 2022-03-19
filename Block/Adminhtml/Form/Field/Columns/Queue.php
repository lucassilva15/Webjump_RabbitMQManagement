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

class Queue extends Select
{
    /**
     * SetInputName method
     *
     * @param $value
     *
     * @return Queue
     */
    public function setInputName($value): Queue
    {
        return $this->setData('name', $value);
    }

    /**
     * SetInputId method
     *
     * @param $value
     *
     * @return Queue
     */
    public function setInputId($value): Queue
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
            ['label' => 'async.products.all', 'value' => 'async.products.all'],
            ['label' => 'wj.linxsyncproduct.all', 'value' => 'wj.linxsyncproduct.all'],
        ];
    }
}
