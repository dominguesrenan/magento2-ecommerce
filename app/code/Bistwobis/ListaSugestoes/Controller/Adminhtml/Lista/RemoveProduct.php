<?php
namespace Bistwobis\ListaSugestoes\Controller\Adminhtml\Lista;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Bistwobis\ListaSugestoes\Model\ListaProdutoFactory;

class RemoveProduct extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ListaProdutoFactory
     */
    protected $listaProdutoFactory;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ListaProdutoFactory $listaProdutoFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ListaProdutoFactory $listaProdutoFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->listaProdutoFactory = $listaProdutoFactory;
    }

    /**
     * Remove product from list
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $listaId = $this->getRequest()->getParam('lista_id');
        $productId = $this->getRequest()->getParam('product_id');
        $result = $this->resultJsonFactory->create();

        try {
            $this->listaProdutoFactory->create()
                ->getCollection()
                ->addFieldToFilter('lista_id', $listaId)
                ->addFieldToFilter('product_id', $productId)
                ->walk('delete');

            return $result->setData(['success' => true]);
        } catch (\Exception $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
    }
} 