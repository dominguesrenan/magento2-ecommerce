<?php
namespace Bistwobis\ListaSugestoes\Model\Lista;

use Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
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

        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            
            // Convert customer_groups string to array if needed
            if (isset($this->loadedData[$model->getId()]['customer_groups'])) {
                $customerGroups = $this->loadedData[$model->getId()]['customer_groups'];
                if (is_string($customerGroups)) {
                    $this->loadedData[$model->getId()]['customer_groups'] = explode(',', $customerGroups);
                }
            }
        }

        $data = $this->dataPersistor->get('lista_sugestoes');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('lista_sugestoes');
        }

        return $this->loadedData;
    }
} 