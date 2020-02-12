<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use BVMyBlog\Blog\Model\ResourceModel\Post as ModelPost;

/**
 * Form Model Post
 */
class Post extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'bvmyblog_blog_post';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ModelPost::class);
    }

    /**
     * Function getIdentities
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
