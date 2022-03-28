<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\RabbitMQManagement\Test\Unit\Cron;

use Webjump\RabbitMQManagement\Cron\CreateConsumers;
use Webjump\RabbitMQManagement\Model\Queue\Service;

class CreateConsumersTest extends \PHPUnit\Framework\TestCase
{
    /** @var Service */
    private $queueServiceMock;

    /** @var CreateConsumers */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->queueServiceMock = $this->createMock(Service::class);

        // Instance
        $this->instance = new CreateConsumers($this->queueServiceMock);
    }

    /**
     * TestExecute method
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecute()
    {
        // Arrange
        $this->queueServiceMock
            ->expects($this->once())
            ->method('createNeededConsumers');

        // Act
        $this->instance->execute();
    }
}
