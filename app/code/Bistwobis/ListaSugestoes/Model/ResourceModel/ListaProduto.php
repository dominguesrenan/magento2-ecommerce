<?php
namespace Bistwobis\ListaSugestoes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ListaProduto extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bistwobis_lista_sugestoes_produtos', 'entity_id');
    }
} 