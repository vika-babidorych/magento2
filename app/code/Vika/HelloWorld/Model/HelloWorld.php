<?php
declare(strict_types=1);

namespace Vika\HelloWorld\Model;

use Magento\Framework\Model\AbstractModel;
use Vika\HelloWorld\Model\ResourceModel\HelloWorld as ResourceModelHelloWorld;
use Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterface;

/**
 * Model HelloWorld
 */
class HelloWorld extends AbstractModel implements HelloWorldAPIInterface
{
    /**
     * Cache tag constant vika
     */
    const CACHE_TAG = 'vika_helloworld';

    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'vika_helloworld';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModelHelloWorld::class);
    }

    /**
     * Retrieve post id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * Retrieve title
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->_getData(self::TITLE);
    }

    /**
     * Retrieve content
     *
     * @return string
     */
    public function getContent() : string
    {
        return $this->_getData(self::CONTENT);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return HelloWorldAPIInterface
     */
    public function setId($id) : HelloWorldAPIInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HelloWorldAPIInterface
     */
    public function setTitle($title) : HelloWorldAPIInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return HelloWorldAPIInterface
     */
    public function setContent($content) : HelloWorldAPIInterface
    {
        return $this->setData(self::CONTENT, $content);
    }
}
