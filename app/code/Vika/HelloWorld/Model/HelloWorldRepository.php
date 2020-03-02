<?php
declare(strict_types=1);

namespace Vika\HelloWorld\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vika\HelloWorld\Model\ResourceModel\HelloWorld as ResourceHelloWorld;
use Vika\HelloWorld\Model\ResourceModel\HelloWorld\Collection;
use Vika\HelloWorld\Model\ResourceModel\HelloWorld\CollectionFactory as HelloWorldCollectionFactory;
use Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterface;
use Vika\HelloWorldAPI\Api\HelloWorldAPIRepositoryInterface;

/**
 * Model HelloWorld Repository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HelloWorldRepository implements HelloWorldAPIRepositoryInterface
{
    /**
     * @var ResourceHelloWorld
     */
    private $resource;

    /**
     * @var HelloWorldFactory
     */
    private $helloWorldFactory;

    /**
     * @var HelloWorldCollectionFactory
     */
    private $helloWorldCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceHelloWorld $resource
     * @param HelloWorldFactory $helloWorldFactory
     * @param HelloWorldCollectionFactory $helloWorldCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceHelloWorld $resource,
        HelloWorldFactory $helloWorldFactory,
        HelloWorldCollectionFactory $helloWorldCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->helloWorldFactory = $helloWorldFactory;
        $this->helloWorldCollectionFactory = $helloWorldCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save data
     *
     * @param HelloWorldAPIInterface $helloWorld
     * @return HelloWorldAPIInterface $helloWorld
     * @throws CouldNotSaveException
     */
    public function save(HelloWorldAPIInterface $helloWorld) : HelloWorldAPIInterface
    {
        try {
            $this->resource->save($helloWorld);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $helloWorld;
    }

    /**
     * Load data by given Identity
     *
     * @return HelloWorldAPIInterface
     * @throws NoSuchEntityException
     */
    public function get() : HelloWorldAPIInterface
    {
        $helloWorld = $this->helloWorldFactory->create();
        $this->resource->load($helloWorld, 1);
        if (!$helloWorld->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.'));
        }
        return $helloWorld;
    }

    /**
     * Load data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria) : SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->helloWorldCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
