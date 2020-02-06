<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\ViewModel;

use BVMyBlog\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Description
 *
 * Description of post
 */
class Description implements ArgumentInterface
{
    protected $modelFactory;

    /**
     * Construct
     *
     * @param PostCollectionFactory $modelFactory
     */
    public function __construct(
        PostCollectionFactory $modelFactory
    ) {
        $this->modelFactory = $modelFactory;
    }

    /**
     * Function getPostById
     *
     * @param string $id
     * @return \Magento\Framework\DataObject
     */
    public function getPostById($id)
    {
        $collection = $this->modelFactory->create();
        $result = $collection->load()->getItemById($id);
        return $result;
    }
}
