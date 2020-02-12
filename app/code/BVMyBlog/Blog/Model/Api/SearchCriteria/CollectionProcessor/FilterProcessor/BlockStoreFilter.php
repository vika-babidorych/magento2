<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use BVMyBlog\Blog\Model\ResourceModel\Block\Collection;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Block Store Filter
 *
 * Model Post Store Filter
 */
class BlockStoreFilter implements CustomFilterInterface
{
    /**
     * Apply custom store filter to collection
     *
     * @param Filter $filter
     * @param AbstractDb $collection
     * @return bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        /** @var Collection $collection */
        $collection->addStoreFilter($filter->getValue(), false);
        return true;
    }
}
