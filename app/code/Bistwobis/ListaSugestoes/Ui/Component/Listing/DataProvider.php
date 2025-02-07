<?php
namespace Bistwobis\ListaSugestoes\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiDataProvider;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResultFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var SearchResultFactory
     */
    private $searchResultFactory;

    /**
     * @var \Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\Collection
     */
    protected $collection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        
        $items = $this->getCollection()->getItems();
        $result = [
            'items' => []
        ];
        
        foreach ($items as $item) {
            $result['items'][] = $item->getData();
        }

        return $result;
    }

    /**
     * @return SearchResultInterface
     */
    public function getSearchResult()
    {
        return $this->collection;
    }
} 