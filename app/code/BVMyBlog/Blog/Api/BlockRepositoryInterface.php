<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Api;

use BVMyBlog\Blog\Api\Data\BlockInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Repository interface post data.
 */
interface BlockRepositoryInterface
{
    /**
     * Save post.
     *
     * @param BlockInterface $block
     * @return BlockInterface
     * @throws LocalizedException
     */
    public function save(BlockInterface $block);

    /**
     * Retrieve post.
     *
     * @param string $blockId
     * @return BlockInterface
     * @throws LocalizedException
     */
    public function getById($blockId);

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete post.
     *
     * @param BlockInterface $block
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(BlockInterface $block);

    /**
     * Delete post by ID.
     *
     * @param string $blockId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($blockId);
}
