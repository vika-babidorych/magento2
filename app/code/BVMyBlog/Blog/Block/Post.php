<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use BVMyBlog\Blog\Model\BlockRepository;
use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Returns post data
 */
class Post extends Template implements ArgumentInterface
{
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * @var BlockRepository $blockRepository
     */
    private $blockRepository;

    /**
     * @inheritdoc
     *
     * @param RequestInterface $request
     * @param BlockRepository $blockRepository
     */
    public function __construct(
        RequestInterface $request,
        BlockRepository $blockRepository
    ) {
        $this->request = $request;
        $this->blockRepository = $blockRepository;
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
        return $this->blockRepository->getById($id);
    }
}
