<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class DataProvider
 *
 * Model DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $pathToFile;
    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blogCollectionFactory
     * @param \Magento\Framework\Filesystem\Io\File $pathToFile
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        \Magento\Framework\Filesystem\Io\File $pathToFile,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blogCollectionFactory->create();
        $this->pathToFile = $pathToFile;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $record) {
            $recordData = $record->getData();
            $path_parts = $this->pathToFile->getPathInfo($recordData['url_key']);
            $record_img = [
                ['type'=>'image',
                    'name' => $path_parts['filename'],
                    'url' => $recordData['url_key']
                ]
            ];
            $recordData['url_key'] = $record_img;
            $this->_loadedData[$record->getId()] = $recordData;
        }
        return $this->_loadedData;
    }
}
