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
     * @inheritdoc
     *
     * @param RedirectInterface $redirect
     * @param BlogRepository $blogRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        RedirectInterface $redirect,
        BlogRepository $blogRepository,
        Context $context,
        array $data = []
    ) {
        $this->redirect = $redirect;
        $this->blogRepository = $blogRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns post id
     *
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * Returns post data by id
     *
     * @return DataObject $result
     * @throws NoSuchEntityException
     */
    public function getPost()
    {
        if ($this->post === null) {
            $this->post = $this->blogRepository->getById($this->getBlogId());
        }

        return $this->post;
    }

    /**
     * Returns url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->redirect->getRedirectUrl();
    }
}
