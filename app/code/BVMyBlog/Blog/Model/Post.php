<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Model;

/**
 * Class Post
 *
 * Model Post
 */
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'bvmyblog_blog_post';

    protected $_cacheTag = 'bvmyblog_blog_post';

    protected $_eventPrefix = 'bvmyblog_blog_post';

    /**
     * Construct
     */
    protected function _construct()
    {
        $this->_init(\BVMyBlog\Blog\Model\ResourceModel\Post::class);
    }

    /**
     * Function getIdentities
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Function getDefaultValues
     */
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
