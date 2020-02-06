<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use BVMyBlog\Blog\Model\ResourceModel\Post\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Index
 *
 * Controller Index
 */
class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $resultPageFactory = false;

    protected $blogCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @return string
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        BlogCollectionFactory $blogCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Blog Posts')));

        return $resultPage;
    }
}
