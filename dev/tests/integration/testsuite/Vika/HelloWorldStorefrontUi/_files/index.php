<?php
declare(strict_types=1);

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$model= $objectManager->create(Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterface::class)
    ->setTitle('HelloWorld2132342354');

$helloWorldRepository = $objectManager->get(
    Vika\HelloWorldAPI\Api\HelloWorldAPIRepositoryInterface::class
);

$helloWorldRepository->save($model);
