<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\ResourceModel\Post;

use BVMyBlog\Blog\Model\Post as ModelPost;
use BVMyBlog\Blog\Model\ResourceModel\Post as ResourceModelPost;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Form Resource Model Collection
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
        $this->_init(ModelPost::class, ResourceModelPost::class);
    }
}
