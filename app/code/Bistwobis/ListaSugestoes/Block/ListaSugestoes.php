<?php
namespace Bistwobis\ListaSugestoes\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\CollectionFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Bistwobis\ListaSugestoes\Api\Data\ListaInterface;

class ListaSugestoes extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $listaCollectionFactory;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param CollectionFactory $listaCollectionFactory
     * @param CustomerSession $customerSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $listaCollectionFactory,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->listaCollectionFactory = $listaCollectionFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Get listas de sugestões
     *
     * @return \Bistwobis\ListaSugestoes\Model\ResourceModel\Lista\Collection
     */
    public function getListas()
    {
        $collection = $this->listaCollectionFactory->create();
        $collection->addFieldToSelect('*');
        $collection->setOrder('created_at', 'DESC');
        return $collection;
    }

    /**
     * Get lista URL
     *
     * @param \Bistwobis\ListaSugestoes\Model\Lista $lista
     * @return string
     */
    public function getListaUrl($lista)
    {
        return $this->getUrl('listasugestoes/lista/view', ['id' => $lista->getId()]);
    }

    /**
     * Get categorias das listas cadastradas
     *
     * @return array
     */
    public function getCategorias()
    {
        $collection = $this->listaCollectionFactory->create();
        $collection->addFieldToSelect(['lista_id', 'tipo_cliente']);
        
        $categorias = [];
        foreach ($collection as $lista) {
            $tipo = $lista->getData('tipo_cliente');
            if ($tipo && !empty(trim($tipo))) {
                $categorias[$tipo] = $tipo;
            }
        }
        
        return $categorias;
    }

    /**
     * Get add to cart URL
     *
     * @param int $productId
     * @return string
     */
    public function getAddToCartUrl($productId)
    {
        return $this->getUrl('checkout/cart/add', ['product' => $productId]);
    }

    /**
     * Get lista title
     *
     * @param \Bistwobis\ListaSugestoes\Model\Lista $lista
     * @return string
     */
    public function getListaTitle($lista)
    {
        return $lista->getTitulo() ?: __('Lista sem título');
    }
} 