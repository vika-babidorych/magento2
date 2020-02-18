<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Filesystem\Io\File;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Blog form ui Data Provider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var File $pathToFile
     */
    private $pathToFile;

    /**
     * @var ResourceModel\Blog\Collection $collection
     */
    protected $collection;

    /**
     * @var array $loadedData
     */
    private $loadedData;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var BlogRepository $blogRepository
     */
    private $blogRepository;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $pathToFile
     * @param CollectionFactory $blogCollectionFactory
     * @param BlogRepository $blogRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        File $pathToFile,
        CollectionFactory $blogCollectionFactory,
        BlogRepository $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->pathToFile = $pathToFile;
        $this->collection = $blogCollectionFactory->create();
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder=$searchCriteriaBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->blogRepository->getList(($this->searchCriteriaBuilder->create()))->getItems();

        foreach ($items as $record) {
            $recordData = $record->getData();
            $pathParts = $this->pathToFile->getPathInfo($recordData['image_path']);
            $recordImg = [
                ['type'=>'image',
                    'name' => $pathParts['filename'],
                    'url' => $recordData['image_path']
                ]
            ];
            $recordData['image_path'] = $recordImg;
            $this->loadedData[$record->getPostId()] = $recordData;
        }
        return $this->loadedData;
    }
}
