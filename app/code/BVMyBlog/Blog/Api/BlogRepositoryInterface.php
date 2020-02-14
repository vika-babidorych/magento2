<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Api;

use BVMyBlog\Blog\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Repository interface post data.
 */
interface BlogRepositoryInterface
{
    /**
     * Save post.
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog);

    /**
     * Retrieve post.
     *
     * @param string $blogId
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($blogId);

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete post.
     *
     * @param BlogInterface $blog
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog);

    /**
     * Delete post by ID.
     *
     * @param string $blogId
     * @return bool true on success
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId);
}
