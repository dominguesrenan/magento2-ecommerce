<?php
namespace Bistwobis\ListaSugestoes\Block\Widget;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use Bistwobis\ListaSugestoes\Model\ListaFactory;
use Magento\Catalog\Model\ProductRepository;

class ListaSugestoes extends Template implements BlockInterface
{
    protected $_template = "widget/lista.phtml";
    protected $listaFactory;
    protected $productRepository;

    public function __construct(
        Template\Context $context,
        ListaFactory $listaFactory,
        ProductRepository $productRepository,
        array $data = []
    ) {
        $this->listaFactory = $listaFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getLista()
    {
        $listaId = $this->getData('lista_id');
        return $this->listaFactory->create()->load($listaId);
    }

    public function getProducts()
    {
        $lista = $this->getLista();
        $products = [];
        
        if ($lista && $lista->getId()) {
            foreach ($lista->getItems() as $item) {
                try {
                    $products[] = $this->productRepository->getById($item->getProductId());
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        
        return $products;
    }
} 