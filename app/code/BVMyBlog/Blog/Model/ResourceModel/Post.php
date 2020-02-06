<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Model\ResourceModel;

/**
 * Class Post
 *
 * ResourceModel Post
 */
class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Construct
     */
    protected function _construct()
    {
        $this->_init('bvmyblog_blog_post', 'post_id');
    }
}
