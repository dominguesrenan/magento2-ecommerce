<?php
namespace Bistwobis\ListaSugestoes\Controller\Adminhtml\Lista;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bistwobis\ListaSugestoes\Model\ListaFactory;

class Delete extends Action
{
    /**
     * @var ListaFactory
     */
    protected $listaFactory;

    /**
     * @param Context $context
     * @param ListaFactory $listaFactory
     */
    public function __construct(
        Context $context,
        ListaFactory $listaFactory
    ) {
        parent::__construct($context);
        $this->listaFactory = $listaFactory;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        
        if ($id) {
            try {
                // Init model and delete
                $model = $this->listaFactory->create();
                $model->load($id);
                $model->delete();
                
                // Display success message
                $this->messageManager->addSuccessMessage(__('A lista foi excluída.'));
                
                // Redirect to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // Go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        // Display error message
        $this->messageManager->addErrorMessage(__('Não foi possível encontrar a lista para excluir.'));
        
        // Redirect to grid
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check delete permission
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bistwobis_ListaSugestoes::lista_delete');
    }
} 