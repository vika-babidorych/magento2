<?php
declare(strict_types=1);

namespace Vika\HelloWorld\Model\ResourceModel\HelloWorld;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vika\HelloWorld\Model\HelloWorld as ModelHelloWorld;
use Vika\HelloWorld\Model\ResourceModel\HelloWorld as ResourceModelHelloWorld;

/**
 * Resource Model Collection
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'vika_helloworld_collection';
    protected $_eventObject = 'helloworld_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            ModelHelloWorld::class,
            ResourceModelHelloWorld::class
        );
    }
}
