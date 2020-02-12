<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

/**
 * Adds new post
 */
class NewAction extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'BVMyBlog_Blog::blog_manage_posts';

    /**
     * @var PageFactory $resultPageFactory
     */
    private $resultPageFactory;

    /**
     * @inheritdoc
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
