<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use BVMyBlog\Blog\Api\BlockRepositoryInterface;
use BVMyBlog\Blog\Model\BlockFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use Magento\Backend\App\Action;
use BVMyBlog\Blog\Model\Block;
use Magento\Framework\Controller\ResultInterface;

/**
 * Saves data from form
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'BVMyBlog_Blog::blog_manage_posts';

    /**
     * @var mixed $blockFactory
     */
    private $blockFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param BlockFactory $blockFactory
     * @param BlockRepositoryInterface|null $blockRepository
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        BlockFactory $blockFactory = null,
        BlockRepositoryInterface $blockRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->blockFactory = $blockFactory
            ?: ObjectManager::getInstance()->get(BlockFactory::class);
        $this->blockRepository = $blockRepository
            ?: ObjectManager::getInstance()->get(BlockRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }
            /** @var Block $post */
            $post = $this->blockFactory->create();
            $imgPath = $data['img_path'][0]['url'];
            $data['img_path'] = $imgPath;

            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                try {
                    $post = $this->blockRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $post->setData($data);
            try {
                $this->blockRepository->save($post);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('bvmyblog_blog_post');
                return $this->processBlockReturn($post, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the post.'));
            }
            $this->dataPersistor->set('bvmyblog_blog_post', $data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param Block $post
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     * @throws LocalizedException
     */
    private function processBlockReturn($post, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/', ['post_id' => $post->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->blockFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $this->blockRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the post.'));
            $this->dataPersistor->set('bvmyblog_blog_post', $data);
            $resultRedirect->setPath('*/*/', ['post_id' => $id]);
        }
        return $resultRedirect;
    }
}
