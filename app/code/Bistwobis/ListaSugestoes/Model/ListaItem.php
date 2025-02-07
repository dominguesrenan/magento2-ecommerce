<?php
namespace Bistwobis\ListaSugestoes\Model;

use Magento\Framework\Model\AbstractModel;

class ListaItem extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Bistwobis\ListaSugestoes\Model\ResourceModel\ListaItem::class);
    }

    public function getItemId()
    {
        return $this->getData('item_id');
    }

    public function setItemId($itemId)
    {
        return $this->setData('item_id', $itemId);
    }

    public function getListaId()
    {
        return $this->getData('lista_id');
    }

    public function setListaId($listaId)
    {
        return $this->setData('lista_id', $listaId);
    }

    public function getProductId()
    {
        return $this->getData('product_id');
    }

    public function setProductId($productId)
    {
        return $this->setData('product_id', $productId);
    }

    public function getPosition()
    {
        return $this->getData('position');
    }

    public function setPosition($position)
    {
        return $this->setData('position', $position);
    }
}
