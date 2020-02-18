<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Api\BlogRepositoryInterface;
use BVMyBlog\Blog\Api\Data\BlogInterface;
use BVMyBlog\Blog\Model\ResourceModel\Blog as ResourceBlog;
use BVMyBlog\Blog\Model\ResourceModel\Blog\Collection;
use BVMyBlog\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Model Blog Repository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var ResourceBlog
     */
    private $resource;

    /**
     * @var BlogFactory
     */
    private $blogFactory;

    /**
     * @var BlogCollectionFactory
     */
    private $blogCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceBlog $resource
     * @param BlogFactory $blogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceBlog $resource,
        BlogFactory $blogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Post data
     *
     * @param BlogInterface $blog
     * @return BlogInterface $blog
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog) : BlogInterface
    {
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Load Post data by given Blog Identity
     *
     * @param string $blogId
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($blogId) : BlogInterface
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $blogId);
        if (!$blog->getPostId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $blogId));
        }
        return $blog;
    }

    /**
     * Load Post data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria) : SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->blogCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Post
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog) : BlogInterface
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Delete Post by given Blog Identity
     *
     * @param string $blogId
     * @return BlogInterface
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId) : BlogInterface
    {
        return $this->delete($this->getById($blogId));
    }
}
