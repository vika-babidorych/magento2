<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Form Resource Model Post
 */
class Post extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('bvmyblog_blog_post', 'post_id');
    }
}
