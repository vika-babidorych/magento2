<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use BVMyBlog\Blog\Api\BlogRepositoryInterface;
use BVMyBlog\Blog\Model\BlogFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Action\Action;
use BVMyBlog\Blog\Model\Blog;
use Magento\Framework\Controller\ResultInterface;

/**
 * Saves data from form
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'BVMyBlog_Blog::blog_manage_posts';

    /**
     * @var mixed $blogFactory
     */
    private $blogFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepository;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param BlogFactory $blogFactory
     * @param BlogRepositoryInterface|null $blogRepository
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        BlogFactory $blogFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->blogFactory = $blogFactory;
        $this->blogRepository = $blogRepository;
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
            /** @var Blog $post */
            $post = $this->blogFactory->create(['data' => $data]);
            $imgPath = $data['image_path'][0]['url'];
            $data['image_path'] = $imgPath;

            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                try {
                    $post = $this->blogRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $post->setData($data);
            try {
                $this->blogRepository->save($post);
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
     * Process and set the blog return
     *
     * @param Blog $post
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface $resultRedirect
     * @throws CouldNotSaveException
     */
    private function processBlockReturn($post, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/', ['post_id' => $post->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->blogFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel = $this->blogRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the post.'));
            $this->dataPersistor->set('bvmyblog_blog_post', $data);
            $resultRedirect->setPath('*/*/', ['post_id' => $id]);
        }
        return $resultRedirect;
    }
}
