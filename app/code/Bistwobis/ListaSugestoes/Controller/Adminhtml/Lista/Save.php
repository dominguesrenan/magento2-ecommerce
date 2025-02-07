<?php
namespace Bistwobis\ListaSugestoes\Controller\Adminhtml\Lista;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bistwobis\ListaSugestoes\Model\ListaFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    protected $listFactory;
    protected $dataPersistor;
    protected $logger;

    public function __construct(
        Context $context,
        ListaFactory $listFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        $this->listFactory = $listFactory;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        
        if ($data) {
            try {
                $model = $this->_objectManager->create(\Bistwobis\ListaSugestoes\Model\Lista::class);
                
                if (!empty($data['entity_id'])) {
                    $model->load($data['entity_id']);
                }
                
                // Use os setters do model
                $model->setTitle($data['title'])
                      ->setTipoCliente(is_array($data['customer_group_ids']) ? implode(',', $data['customer_group_ids']) : '')
                      ->setDescription($data['description'] ?? '');
                
                $model->save();

                $this->messageManager->addSuccessMessage(__('Lista salva com sucesso.'));
                $this->dataPersistor->clear('lista_sugestoes');

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Ocorreu um erro ao salvar a lista.'));
            }

            $this->dataPersistor->set('lista_sugestoes', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $data['entity_id'] ?? null]);
        }
        
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bistwobis_ListaSugestoes::lista_manage');
    }
} 