<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Block;

use BVMyBlog\Blog\Model\BlogRepository;
use Magento\Catalog\Model\Locator\RegistryLocator;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Returns 5 latest posts
 */
class LastPosts extends Template
{
    /**
     * @var SortOrderBuilder $sortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var BlogRepository $blogRepository
     */
    private $blogRepository;

    /**
     * ScopeConfigInterface $scopeInterface
     */
    private $scopeInterface;

    /**
     * UrlInterface $urlInterface
     */
    private $urlBuilder;

    /**
     * @var RegistryLocator $registryLocator
     */
    private $registryLocator;

    /**
     * @param ScopeConfigInterface $scopeInterface
     * @param UrlInterface $urlBuilder
     * @param RegistryLocator $registryLocator
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BlogRepository $blogRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeInterface,
        UrlInterface $urlBuilder,
        RegistryLocator $registryLocator,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BlogRepository $blogRepository,
        Context $context,
        array $data = []
    ) {
        $this->scopeInterface = $scopeInterface;
        $this->urlBuilder = $urlBuilder;
        $this->registryLocator = $registryLocator;
        $this->sortOrderBuilder=$sortOrderBuilder;
        $this->searchCriteriaBuilder=$searchCriteriaBuilder;
        $this->blogRepository = $blogRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns url by id
     *
     * @param integer $id
     *
     * @return string
     */
    public function getUrlById(int $id)
    {
        return $this->urlBuilder->getUrl('bvmyblog_blog/index/index', ['id' => $id]);
    }

    /**
     * Get last posts by field created_at
     *
     * @return array
     */
    public function getTopBlogs()
    {
        $this->sortOrderBuilder->setField('created_at');
        $this->sortOrderBuilder->setDescendingDirection();
        $this->searchCriteriaBuilder->addSortOrder($this->sortOrderBuilder->create());
        $this->searchCriteriaBuilder->setPageSize(5);
        $searchResult = $this->blogRepository->getList(($this->searchCriteriaBuilder->create()));
        return $searchResult->getItems();
    }

    /**
     * Find currentProductTypes in typesArray
     *
     * @return bool
     * @throws NotFoundException
     */
    public function isMatch()
    {
        $types = $this->scopeInterface->getValue('catalog/blog/blog_applied_to');
        $currentProductTypes = $this->registryLocator->getProduct()->getTypeId();
        $typesArray = explode(',', $types);
        return in_array($currentProductTypes, $typesArray);
    }
}
