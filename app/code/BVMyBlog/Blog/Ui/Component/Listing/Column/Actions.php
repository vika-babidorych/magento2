<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Actions edit and delete in grid
 */
class Actions extends Column
{
    /**
     * Get data
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->context->getUrl('bvmyblog_blog/post/edit', ['id' => $item['post_id']]),
                    'label' => __('Edit'),
                    'hidden' => false
                ];
                $item[$this->getData('name')]['delete'] = [
                    'href' => $this->context->getUrl('bvmyblog_blog/post/delete', ['id' => $item['post_id']]),
                    'label' => __('Delete'),
                    'hidden' => false
                ];
            }
        }
        return $dataSource;
    }
}
