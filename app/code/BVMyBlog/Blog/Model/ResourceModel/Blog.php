<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Grid Resource Model Blog
 */
class Blog extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('bvmyblog_blog_post', 'post_id');
    }
}
