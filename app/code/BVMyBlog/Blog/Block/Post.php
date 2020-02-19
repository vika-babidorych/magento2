<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Block;

use BVMyBlog\Blog\Model\BlogRepository;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Returns post data
 */
class Post extends Template
{
    /**
     * @var RedirectInterface $redirect
     */
    private $redirect;

    /**
     * @var DataObject $post
     */
    private $post;

    /**
     * @var BlogRepository $blogRepository
     */
    private $blogRepository;

    /**
     * @param Context $context
     * @param RedirectInterface $redirect
     * @param BlogRepository $blogRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        RedirectInterface $redirect,
        BlogRepository $blogRepository,
        array $data = []
    ) {
        $this->redirect = $redirect;
        $this->blogRepository = $blogRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns post id
     *
     * @return int
     */
    public function getBlogId() : int
    {
        return (int)$this->getRequest()->getParam('id');
    }

    /**
     * Returns post data by id
     *
     * @return DataObject $result
     */
    public function getPost() : DataObject
    {
        if ($this->post === null) {
            try {
                $this->post = $this->blogRepository->getById($this->getBlogId());
            } catch (NoSuchEntityException $e) {
                $this->_logger->warning($e);
            }
        }

        return $this->post;
    }

    /**
     * Returns url
     *
     * @return string
     */
    public function getBackUrl() : string
    {
        return $this->redirect->getRedirectUrl();
    }
}
