<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Api;

use BVMyBlog\Blog\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

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
    public function save(BlogInterface $blog) : BlogInterface;

    /**
     * Retrieve post.
     *
     * @param string $blogId
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($blogId) : BlogInterface;

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResultsInterface;

    /**
     * Delete post.
     *
     * @param BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog) : bool;

    /**
     * Delete post by ID.
     *
     * @param string $blogId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById($blogId) : bool;
}
