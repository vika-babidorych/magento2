<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\ViewModel;

use BVMyBlog\Blog\Helper\Data;
use BVMyBlog\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Top
 *
 * ViewModel post
 * @property  helper
 */
class Top implements ArgumentInterface
{
    protected $modelFactory;
    /**
     * @var Data
     */
    protected $helper;

    /**
     * Construct
     *
     * @param PostCollectionFactory $modelFactory
     * @param \BVMyBlog\Blog\Helper\Data $helper
     */
    public function __construct(
        PostCollectionFactory $modelFactory,
        Data $helper
    ) {
        $this->modelFactory = $modelFactory;
        $this->helper = $helper;
    }

    /**
     * Function listTop by field created_at
     */
    public function listTop()
    {
        $collection = $this->modelFactory->create();
        $collection->setOrder('created_at', 'DESC')->setPageSize(5);
        return $collection;
    }

    /**
     * Function isMatch current_product_types in $types_array
     *
     * @return bool
     */
    public function isMatch()
    {
        $types = $this->helper->getConfig('catalog/blog/blog_applied_to');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->get(\Magento\Framework\Registry::class)->registry('current_product');
        $current_product_types = $product->getTypeId();
        $types_array = explode(',', $types);
        $match = in_array($current_product_types, $types_array);
        return $match;
    }
}
