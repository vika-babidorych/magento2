<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\ResourceModel\Block;

use BVMyBlog\Blog\Model\Block as ModelBlock;
use BVMyBlog\Blog\Model\ResourceModel\Block as ResourceModelBlock;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;

/**
 * Grid Resource Model Collection
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'bvmyblog_blog_post_collection';
    protected $_eventObject = 'post_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            ModelBlock::class,
            ResourceModelBlock::class
        );
    }
    /**
     * Add filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    /**
     * Perform adding filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter('store', ['in' => $store], 'public');
    }
}
