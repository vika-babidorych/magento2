<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Block;

use BVMyBlog\Blog\Model\BlogRepository;
use Magento\Framework\App\RequestInterface;
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
     * @var DataObject $post
     */
    private $post;
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * @var BlogRepository $blogRepository
     */
    private $blogRepository;

    /**
     * @inheritdoc
     *
     * @param BlogRepository $blogRepository
     * @param RequestInterface $request
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        BlogRepository $blogRepository,
        RequestInterface $request,
        Context $context,
        array $data = []
    ) {
        $this->blogRepository = $blogRepository;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    /**
     * Returns post id
     *
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->request->getParam('id');
    }

    /**
     * Returns post data by id
     *
     * @param string $id
     * @return DataObject $result
     * @throws NoSuchEntityException
     */
    public function getPostById($id)
    {
        if (isset($this->post)) {
            return $this->post;
        } else {
            return $this->blogRepository->getById($id);
        }
    }
}
