<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

/**
 * Class Edit
 *
 * Controller Edit
 */
class Edit extends Action implements HttpGetActionInterface
{
    protected $resultPageFactory;
    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @return string
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Function execute
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
