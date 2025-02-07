<?php
namespace Bistwobis\ListaSugestoes\Model\ResourceModel\ListaProduto;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Bistwobis\ListaSugestoes\Model\ListaProduto::class,
            \Bistwobis\ListaSugestoes\Model\ResourceModel\ListaProduto::class
        );
    }
} 