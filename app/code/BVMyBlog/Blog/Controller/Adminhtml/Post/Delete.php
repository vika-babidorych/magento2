<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use BVMyBlog\Blog\Api\BlockRepositoryInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Deletes a post from the table
 */
class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'BVMyBlog_Blog::blog_manage_posts';

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @inheritdoc
     *
     * @param Context $context
     * @param BlockRepositoryInterface|null $blockRepository
     */
    public function __construct(
        Context $context,
        BlockRepositoryInterface $blockRepository = null
    ) {
        $this->blockRepository = $blockRepository
            ?: ObjectManager::getInstance()->get(BlockRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');

        $post = $this->blockRepository->getById($id);

        if (!$id) {
            $this->messageManager->addError(__('Unable to process, there is no post with this ID.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/post', ['_current' => true]);
        }

        try {
            $this->blockRepository->delete($post);
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
