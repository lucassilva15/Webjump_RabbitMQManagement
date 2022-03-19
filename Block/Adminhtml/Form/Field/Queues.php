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

namespace Webjump\RabbitMQManagement\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Queues extends AbstractFieldArray
{
    const ENABLED_COLUMN = 'enabled';
    const QUEUE_COLUMN = 'queue';
    const MAX_CONSUMERS_COLUMN = 'max_consumers';
    const READ_MESSAGES_COLUMN = 'read_messages';

    /** @var Columns\Enable */
    private $enabledColumnRenderer;

    /** @var Columns\Queue */
    private $queueColumnRenderer;

    /**
     * _prepareToRender method
     *
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn(self::ENABLED_COLUMN, [
            'label' => __('Enable'),
            'renderer' => $this->getEnabledColumnRenderer()
        ]);
        $this->addColumn(self::QUEUE_COLUMN, [
            'label' => __('Queue'),
            'renderer' => $this->getQueueColumnRenderer()
        ]);
        $this->addColumn(self::MAX_CONSUMERS_COLUMN, [
            'label' => __('Max Consumers'),
            'class' => 'required-entry validate-digits validate-number'
        ]);
        $this->addColumn(self::READ_MESSAGES_COLUMN, [
            'label' => __('Read Messages'),
            'class' => 'required-entry validate-digits validate-number'
        ]);
    }

    /**
     * _prepareArrayRow method
     *
     * @param DataObject $row
     *
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $enabled = $row->getData(self::ENABLED_COLUMN);
        if ($enabled !== null) {
            $options['option_' . $this->getEnabledColumnRenderer()->calcOptionHash($enabled)] = 'selected="selected"';
        }

        $queue = $row->getData(self::QUEUE_COLUMN);
        if ($queue !== null) {
            $options['option_' . $this->getQueueColumnRenderer()->calcOptionHash($queue)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * GetEnabledColumnRenderer method
     *
     * @return Columns\Enable
     * @throws LocalizedException
     */
    private function getEnabledColumnRenderer(): Columns\Enable
    {
        if (!$this->enabledColumnRenderer) {
            $this->enabledColumnRenderer = $this->getLayout()->createBlock(
                Columns\Enable::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->enabledColumnRenderer;
    }

    /**
     * GetQueueColumnRenderer method
     *
     * @return Columns\Queue
     * @throws LocalizedException
     */
    private function getQueueColumnRenderer(): Columns\Queue
    {
        if (!$this->queueColumnRenderer) {
            $this->queueColumnRenderer = $this->getLayout()->createBlock(
                Columns\Queue::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->queueColumnRenderer;
    }
}
