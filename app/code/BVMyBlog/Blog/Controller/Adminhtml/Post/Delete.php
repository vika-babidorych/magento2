<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use BVMyBlog\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Deletes a post from the table
 */
class Delete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'BVMyBlog_Blog::blog_manage_posts';

    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepository;

    /**
     * @inheritdoc
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogRepository = $blogRepository;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (is_numeric($id)) {
            try {
                $post = $this->blogRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('Unable to process, post with such ID is missing.'));
            }
        }

        if ($post !== null && !$post->getPostId()) {
            $this->messageManager->addError(__('Unable to process, there is no post with this ID.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $this->blogRepository->delete($post);
            $this->messageManager->addSuccess(__('Your post has been deleted!'));
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addError(__('Error while trying to delete post'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
