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

use Magento\Backend\Block\Store\Switcher;
use Magento\Framework\App\Cache\TypeList;
use Magento\Framework\Event\Manager\Proxy;
use Magento\Framework\Registry;
use Magento\Framework\Validation\ValidationException;
use PHPUnit\Framework\MockObject\MockObject;
use Webjump\RabbitMQManagement\Model\Adminhtml\Attribute\Validator;
use Webjump\RabbitMQManagement\Model\Config;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->switcherMock = $this->createMock(Switcher::class);
        $this->configMock = $this->createMock(Config::class);
        $this->contextMock = $this->createMock(\Magento\Framework\Model\Context::class);
        $this->registryMock = $this->createMock(Registry::class);
        $this->scopeConfigMock = $this->createMock(\Magento\Framework\App\Config::class);
        $this->cacheTypeListMock = $this->createMock(TypeList::class);

        // Others
        $this->eventDispatcherMock = $this->createMock(Proxy::class);

        // Instance
        $this->instance = new Validator(
            $this->switcherMock,
            $this->configMock,
            $this->contextMock,
            $this->registryMock,
            $this->scopeConfigMock,
            $this->cacheTypeListMock
        );
    }

    /**
     * TestBeforeSave method
     *
     * @param array $argsMock
     * @param array $calls
     *
     * @return void
     * @throws \Magento\Framework\Validation\ValidationException
     *
     * @dataProvider beforeSaveDataProvider
     */
    public function testBeforeSave(array $argsMock, array $calls)
    {
        // Arrange
        $methods = ['getValue'];
        $constructorArgs = [
            $this->switcherMock,
            $this->configMock,
            $this->contextMock,
            $this->registryMock,
            $this->scopeConfigMock,
            $this->cacheTypeListMock
        ];

        $this->contextMock
            ->method('getEventDispatcher')
            ->willReturn($this->eventDispatcherMock);

        $instance = $this->createPartialMockWithOriginalMethods(
            Validator::class,
            $constructorArgs,
            $methods
        );

        $instanceValue = $argsMock['instance_get_value'];
        $instance->expects($this->exactly($calls['instance_get_value']))
            ->method('getValue')
            ->willReturn($instanceValue);

        $this->configMock
            ->expects($this->exactly($calls['config_is_enabled']))
            ->method('isEnabled')
            ->willReturn($argsMock['config_is_enabled']);

        if (
            empty($instanceValue[0]['queue']) === true
            && empty($instanceValue) === false
            && $instanceValue !== ['']
        ) {
            $this->expectException(ValidationException::class);
        }

        if (count($instanceValue) > 1) {
            $this->expectException(ValidationException::class);
        }

        // Act
        /** @var Validator $instance */
        $instance->beforeSave();
    }

    public function beforeSaveDataProvider(): array
    {
        return [
            'shouldSkipWhenModuleIsDisabled' => [
                'argsMock' => [
                    'instance_get_value' => [],
                    'config_is_enabled' => false
                ],
                'calls' => [
                    'instance_get_value' => 4,
                    'config_is_enabled' => 1
                ]
            ],
            'shouldContinueWhenValueIsNotArray' => [
                'argsMock' => [
                    'instance_get_value' => [''],
                    'config_is_enabled' => true
                ],
                'calls' => [
                    'instance_get_value' => 4,
                    'config_is_enabled' => 1
                ]
            ],
            'shouldThrowExceptionWhenQueueValueIsNotSet' => [
                'argsMock' => [
                    'instance_get_value' => [[]],
                    'config_is_enabled' => true
                ],
                'calls' => [
                    'instance_get_value' => 1,
                    'config_is_enabled' => 1
                ]
            ],
            'shouldThrowExceptionWhenQueueValueIsDuplicated' => [
                'argsMock' => [
                    'instance_get_value' => [['queue' => 'queue'], ['queue' => 'queue']],
                    'config_is_enabled' => true
                ],
                'calls' => [
                    'instance_get_value' => 1,
                    'config_is_enabled' => 1
                ]
            ],
            'shouldSaveWithSuccessfully' => [
                'argsMock' => [
                    'instance_get_value' => [['queue' => 'queue']],
                    'config_is_enabled' => true
                ],
                'calls' => [
                    'instance_get_value' => 4,
                    'config_is_enabled' => 1
                ]
            ]
        ];
    }

    /**
     * CreatePartialMockWithOriginalMethods method
     *
     * @param string $class
     * @param array $constructorArgs
     * @param array $methods
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function createPartialMockWithOriginalMethods(string $class, array $constructorArgs, array $methods): MockObject
    {
        return $this->getMockBuilder($class)
            ->enableOriginalConstructor()
            ->setConstructorArgs($constructorArgs)
            ->disableArgumentCloning()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods($methods)
            ->getMock();
    }
}
