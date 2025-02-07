<?php
namespace Bistwobis\ListaSugestoes\Model\ResourceModel\ListaItem;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Bistwobis\ListaSugestoes\Model\ListaItem::class,
            \Bistwobis\ListaSugestoes\Model\ResourceModel\ListaItem::class
        );
    }
} 