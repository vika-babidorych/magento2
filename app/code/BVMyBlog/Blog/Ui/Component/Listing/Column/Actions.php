<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class to build edit and delete link for each item.
 */
class Actions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'bvmyblog_blog/post/edit';
    const URL_PATH_DELETE = 'bvmyblog_blog/post/delete';

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['post_id'])) {
                    $title = $item['title'];
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->context->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['post_id'],
                                ]
                            ),
                            'label' => __('Edit'),
                            '__disableTmpl' => true,
                        ],
                        'delete' => [
                            'href' => $this->context->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['post_id'],
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $title),
                                'message' => __('Are you sure you want to delete a %1 record?', $title),
                            ],
                            'post' => true,
                            '__disableTmpl' => true,
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
