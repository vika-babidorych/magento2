<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Image in grid
 */
class Thumbnail extends Column
{
    const ALT_FIELD = 'name';

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $filename = $item['image_path'];
                $item[$fieldName . '_src'] = $this->context->getUrl('', ['_direct' => '']) . $filename;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_orig_src'] = $this->context->getUrl('', ['_direct' => '']) . $filename;
            }
        }

        return $dataSource;
    }

    /**
     * Get Alt
     *
     * @param array $row
     * @return string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? '';
    }
}
