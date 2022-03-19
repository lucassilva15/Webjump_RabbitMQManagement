<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Webjump_RabbitMQManagement',
    __DIR__
);
