<?php
declare(strict_types=1);

namespace Vika\HelloWorld\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Model HelloWorld
 */
class HelloWorld extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('vika_helloworld', 'id');
    }
}
