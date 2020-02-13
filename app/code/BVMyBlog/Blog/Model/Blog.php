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
     * Retrieve post id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * Retrieve post title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::POST_CONTENT);
    }

    /**
     * Retrieve post image
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->getData(self::IMAGE_PATH);
    }

    /**
     * Retrieve post creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BlogInterface
     */
    public function setId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlogInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::POST_CONTENT, $content);
    }

    /**
     * Set image
     *
     * @param string $imagePath
     * @return BlogInterface
     */
    public function setImagePath($imagePath)
    {
        return $this->setData(self::IMAGE_PATH, $imagePath);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlogInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATED_AT, $creationTime);
    }
}
