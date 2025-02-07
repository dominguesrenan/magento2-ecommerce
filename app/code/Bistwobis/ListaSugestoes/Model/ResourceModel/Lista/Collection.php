<?php
namespace Bistwobis\ListaSugestoes\Model\ResourceModel\Lista;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'lista_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Bistwobis\ListaSugestoes\Model\Lista::class,
            \Bistwobis\ListaSugestoes\Model\ResourceModel\Lista::class
        );
    }
} 