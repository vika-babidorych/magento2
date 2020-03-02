<?php
declare(strict_types=1);

namespace Vika\HelloWorldAPI\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * Repository interface data.
 */
interface HelloWorldAPIRepositoryInterface
{
    /**
     * Save post.
     *
     * @param HelloWorldAPIInterface $helloWorld
     * @return HelloWorldAPIInterface
     * @throws CouldNotSaveException
     */
    public function save(HelloWorldAPIInterface $helloWorld) : HelloWorldAPIInterface;

    /**
     * Retrieve.
     *
     * @return HelloWorldAPIInterface
     * @throws NoSuchEntityException
     */
    public function get() : HelloWorldAPIInterface;

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResultsInterface;
}
