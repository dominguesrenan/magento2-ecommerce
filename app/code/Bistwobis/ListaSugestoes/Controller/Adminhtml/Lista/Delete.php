<?php
namespace Bistwobis\ListaSugestoes\Controller\Adminhtml\Lista;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action
{
    protected $resourceConnection;

    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection
    ) {
        parent::__construct($context);
        $this->resourceConnection = $resourceConnection;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('id');

        if ($id) {
            try {
                $connection = $this->resourceConnection->getConnection();
                
                // Get table names
                $listaTable = $this->resourceConnection->getTableName('bistwobis_lista_sugestoes');
                $produtosTable = $this->resourceConnection->getTableName('bistwobis_lista_sugestoes_produtos');
                $categoriasTable = $this->resourceConnection->getTableName('bistwobis_lista_sugestoes_categorias');

                // Begin transaction
                $connection->beginTransaction();

                try {
                    // Delete related records first
                    $connection->delete($produtosTable, ['lista_id = ?' => $id]);
                    $connection->delete($categoriasTable, ['lista_id = ?' => $id]);
                    
                    // Delete the main record
                    $result = $connection->delete($listaTable, ['lista_id = ?' => $id]);

                    if ($result) {
                        $connection->commit();
                        $this->messageManager->addSuccessMessage(__('The lista has been deleted.'));
                    } else {
                        $connection->rollBack();
                        $this->messageManager->addErrorMessage(__('Unable to delete the lista.'));
                    }
                } catch (\Exception $e) {
                    $connection->rollBack();
                    throw $e;
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while deleting the lista: %1', $e->getMessage())
                );
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a lista to delete.'));
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bistwobis_ListaSugestoes::lista_delete');
    }
} 