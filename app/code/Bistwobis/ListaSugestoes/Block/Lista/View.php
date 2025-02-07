<?php
namespace Bistwobis\ListaSugestoes\Block\Lista;

use Magento\Framework\View\Element\Template;
use Bistwobis\ListaSugestoes\Model\ListaFactory;
use Magento\Framework\Registry;

class View extends Template
{
    protected $listaFactory;
    protected $registry;

    public function __construct(
        Template\Context $context,
        ListaFactory $listaFactory,
        Registry $registry,
        array $data = []
    ) {
        $this->listaFactory = $listaFactory;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getLista()
    {
        $listaId = $this->getRequest()->getParam('id');
        return $this->listaFactory->create()->load($listaId);
    }

    public function getListaItems()
    {
        $lista = $this->getLista();
        return $lista ? $lista->getItems() : [];
    }
}
