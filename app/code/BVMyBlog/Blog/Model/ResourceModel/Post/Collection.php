<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Model\ResourceModel\Post;

/**
 * Class Collection
 *
 * ResourceModel Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'bvmyblog_blog_post_collection';
    protected $_eventObject = 'post_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\BVMyBlog\Blog\Model\Post::class, \BVMyBlog\Blog\Model\ResourceModel\Post::class);
    }
}
