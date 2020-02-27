<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use BVMyBlog\Blog\Api\BlogRepositoryInterface;
use BVMyBlog\Blog\Model\Blog;
use BVMyBlog\Blog\Model\BlogFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * @param BlogRepositoryInterface $blogRepository
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
            $id = $this->getRequest()->getParam('id');
            if (empty($data)) {
                $this->messageManager->addErrorMessage(__('Please specify valid data.'));
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }

            $imgPath = $data['image_path'][0]['url'] ?? '';
            $data['image_path'] = $imgPath;

            if ($id) {
                try {
                    $post = $this->blogRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
                $post->addData($data);
            } else {
                $post = $this->blogFactory->create(['data' => $data]);
            }

            try {
                $this->blogRepository->save($post);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('bvmyblog_blog_post');
                return $this->processBlockReturn($post, $data, $resultRedirect);
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
            $this->dataPersistor->set('bvmyblog_blog_post', $data);
            return $resultRedirect->setPath('*/*/');
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
     */
    private function processBlockReturn($post, $data, $resultRedirect) : ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        $id = $post->getPostId();
        if ($redirect === 'continue' && isset($id) && is_numeric($id)) {
            $resultRedirect->setPath('*/*/', ['post_id' => $id]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
