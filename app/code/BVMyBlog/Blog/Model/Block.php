<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Api\Data\BlockInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use BVMyBlog\Blog\Model\ResourceModel\Block as ModelBlock;
use Magento\Framework\Exception\LocalizedException;

/**
 * Grid Model Block
 */
class Block extends AbstractModel implements BlockInterface, IdentityInterface
{
    /**
     * Block cache tag
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
        $this->_init(ModelBlock::class);
    }

    /**
     * Prevent posts recursion
     *
     * @return AbstractModel
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $needle = 'post_id="' . $this->getId() . '"';
        if (false == strstr($this->getContent(), (string) $needle)) {
            return parent::beforeSave();
        }
        throw new LocalizedException(
            __('Make sure that static post content does not reference the post itself.')
        );
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
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
    public function getImgPath()
    {
        return $this->getData(self::IMG_PATH);
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
     * @return BlockInterface
     */
    public function setId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlockInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlockInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::POST_CONTENT, $content);
    }

    /**
     * Set image
     *
     * @param string $imgPath
     * @return BlockInterface
     */
    public function setImgPath($imgPath)
    {
        return $this->setData(self::IMG_PATH, $imgPath);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlockInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATED_AT, $creationTime);
    }
}
