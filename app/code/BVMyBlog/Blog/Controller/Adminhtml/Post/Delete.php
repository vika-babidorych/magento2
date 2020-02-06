<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Delete
 *
 * Controller Delete
 */
class Delete extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Post';

    protected $resultPageFactory;
    protected $contactFactory;

    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \BVMyBlog\Blog\Model\PostFactory $contactFactory
     * @return string
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \BVMyBlog\Blog\Model\PostFactory $contactFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->contactFactory = $contactFactory;
        parent::__construct($context);
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $contact = $this->contactFactory->create()->load($id);

        if (!$contact) {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $contact->delete();
            $this->messageManager->addSuccess(__('Your post has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete post'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/post', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
