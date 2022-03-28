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

use Symfony\Component\Process\PhpExecutableFinder;
use Webjump\RabbitMQManagement\Model\Queue\Helper;

class HelperTest extends \PHPUnit\Framework\TestCase
{
    /** @var PhpExecutableFinder */
    private $phpExecutableFinderMock;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        // Constructor
        $this->phpExecutableFinderMock = $this->createMock(PhpExecutableFinder::class);

        // Instance
        $this->instance = new Helper($this->phpExecutableFinderMock);
    }

    public function testBuildStartConsumersCommand(){
        // Arrange
        $this->phpExecutableFinderMock
            ->method($this->once())

        // Act
        // Assert
    }
}
