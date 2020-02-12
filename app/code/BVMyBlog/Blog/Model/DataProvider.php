<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Model;

use BVMyBlog\Blog\Model\ResourceModel\Block\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Filesystem\Io\File;

/**
 * Model DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var File $pathToFile
     */
    private $pathToFile;

    /**
     * @var ResourceModel\Block\Collection $collection
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
     * @var BlockRepository $blockRepository
     */
    private $blockRepository;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $pathToFile
     * @param CollectionFactory $blogCollectionFactory
     * @param BlockRepository $blockRepository
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
        BlockRepository $blockRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->pathToFile = $pathToFile;
        $this->collection = $blogCollectionFactory->create();
        $this->blockRepository = $blockRepository;
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
        $items = $this->blockRepository->getList(($this->searchCriteriaBuilder->create()))->getItems();

        foreach ($items as $record) {
            $path_parts = $this->pathToFile->getPathInfo($record->getImgPath());
            $record_img = [
                ['type'=>'image',
                    'name' => $path_parts['filename'],
                    'url' => $record->getImgPath()
                ]
            ];
            $loadedData = [$record::POST_ID => $record->getId(),
                $record::TITLE => $record->getTitle(),
                $record::POST_CONTENT => $record->getContent(),
                $record::IMG_PATH => $record_img,
                $record::CREATED_AT => $record->getCreationTime()];
            $this->loadedData[$record->getId()] = $loadedData;
        }
        return $this->loadedData;
    }
}
