<?php
declare(strict_types=1);
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Vika_HelloWorldPlugin',
    __DIR__
);
