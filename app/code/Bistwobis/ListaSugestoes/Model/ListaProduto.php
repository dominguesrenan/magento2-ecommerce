<?php
namespace Bistwobis\ListaSugestoes\Model;

use Magento\Framework\Model\AbstractModel;

class ListaProduto extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Bistwobis\ListaSugestoes\Model\ResourceModel\ListaProduto::class);
    }
} 