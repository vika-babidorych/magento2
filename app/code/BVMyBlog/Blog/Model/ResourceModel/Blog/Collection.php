<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\ResourceModel\Blog;

use BVMyBlog\Blog\Model\Blog as ModelBlog;
use BVMyBlog\Blog\Model\ResourceModel\Blog as ResourceModelBlog;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

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
            ModelBlog::class,
            ResourceModelBlog::class
        );
    }
}
