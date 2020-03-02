<?php
declare(strict_types=1);

namespace Vika\HelloWorldStorefrontUi\Block;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vika\HelloWorld\Model\HelloWorldRepository;

/**
 * Renders index page
 */
class Index extends Template
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
     * @var HelloWorldRepository $helloWorldRepository
     */
    private $helloWorldRepository;

    /**
     * @param Context $context
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param HelloWorldRepository $helloWorldRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        HelloWorldRepository $helloWorldRepository,
        array $data = []
    ) {
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helloWorldRepository = $helloWorldRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get by field id
     *
     * @return string
     */
    public function getHello() : string
    {
        $this->sortOrderBuilder->setField('id');
        $this->sortOrderBuilder->setAscendingDirection();
        $this->searchCriteriaBuilder->addSortOrder($this->sortOrderBuilder->create());
        $this->searchCriteriaBuilder->setPageSize(1);
        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->helloWorldRepository->getList(($this->searchCriteriaBuilder->create()));
        $item = $searchResult->getItems();
        return $item[1]->getTitle();
    }
}
