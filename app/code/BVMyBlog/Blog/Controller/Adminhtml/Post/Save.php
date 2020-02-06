<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Save
 *
 * Controller Save
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Post';

    protected $resultPageFactory;
    protected $postFactory;

    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \BVMyBlog\Blog\Model\PostFactory $postFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \BVMyBlog\Blog\Model\PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['post_id'];
                $image_url = $data['url_key'][0]['url'];
                $data['url_key'] = $image_url;

                $post = $this->postFactory->create()->load($id);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $post->setData($data);
                $post->save();
                $this->messageManager->addSuccess(__('Successfully saved the post.'));
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $post->getId()]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
