<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Api\Data\BlogInterface;
use BVMyBlog\Blog\Model\ResourceModel\Blog as ModelBlog;
use Magento\Framework\Model\AbstractModel;

/**
 * Grid Model Blog
 */
class Blog extends AbstractModel implements BlogInterface
{
    /**
     * Blog cache tag
     */
    const CACHE_TAG = 'bvmyblog_blog_post';

    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bvmyblog_blog_post';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ModelBlog::class);
    }

    /**
     * Function getIdentities
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve post id
     *
     * @return int
     */
    public function getPostId() : int
    {
        $id = $this->_getData(self::POST_ID);

        if ($id !== null) {
            $id = (int)$id;
        }

        return $id;
    }

    /**
     * Retrieve post title
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->_getData(self::TITLE);
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent() : string
    {
        return $this->_getData(self::POST_CONTENT);
    }

    /**
     * Retrieve post image
     *
     * @return string|null
     */
    public function getImagePath() : string
    {
        return $this->_getData(self::IMAGE_PATH);
    }

    /**
     * Retrieve post creation time
     *
     * @return string
     */
    public function getCreationTime() : string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BlogInterface
     */
    public function setPostId($id) : BlogInterface
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogInterface
     */
    public function setTitle($title) : BlogInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlogInterface
     */
    public function setContent($content) : BlogInterface
    {
        return $this->setData(self::POST_CONTENT, $content);
    }

    /**
     * Set image
     *
     * @param string $imagePath
     * @return BlogInterface
     */
    public function setImagePath($imagePath) : BlogInterface
    {
        return $this->setData(self::IMAGE_PATH, $imagePath);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlogInterface
     */
    public function setCreationTime($creationTime) : BlogInterface
    {
        return $this->setData(self::CREATED_AT, $creationTime);
    }
}
