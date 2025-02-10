<?php
namespace Bistwobis\ListaSugestoes\Controller\Adminhtml\Lista;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bistwobis\ListaSugestoes\Model\ListaProdutoFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Request\Http;

class SaveProducts extends Action
{
    protected $listaProdutoFactory;
    protected $resultJsonFactory;
    protected $request;

    public function __construct(
        Context $context,
        ListaProdutoFactory $listaProdutoFactory,
        JsonFactory $resultJsonFactory,
        Http $request
    ) {
        parent::__construct($context);
        $this->listaProdutoFactory = $listaProdutoFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        try {
            $postData = $this->request->getPostValue();
            $listaId = $this->request->getParam('lista_id');
            $selected = $this->request->getParam('selected', []);

            if (!$listaId) {
                throw new \Exception(__('Lista ID is required.'));
            }

            if (empty($selected)) {
                throw new \Exception(__('No products selected.'));
            }

            // Remove existing products for this lista
            $collection = $this->listaProdutoFactory->create()->getCollection();
            $collection->addFieldToFilter('lista_id', $listaId);
            foreach ($collection as $item) {
                $item->delete();
            }

            // Add new products
            foreach ($selected as $productId) {
                $listaProduto = $this->listaProdutoFactory->create();
                $listaProduto->setData([
                    'lista_id' => $listaId,
                    'product_id' => $productId
                ])->save();
            }

            return $result->setData([
                'success' => true,
                'message' => __('Products have been saved successfully.')
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bistwobis_ListaSugestoes::lista_manage');
    }
} 