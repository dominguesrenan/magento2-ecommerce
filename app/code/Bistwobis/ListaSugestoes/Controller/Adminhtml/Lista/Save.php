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
        
        try {
            $rawData = $this->getRequest()->getPostValue();
            $this->logger->info('Raw POST Data: ' . print_r($rawData, true));

            // Extrai os dados do formulário
            $data = $rawData['data'] ?? $rawData;
            $this->logger->info('Processed Form Data: ' . print_r($data, true));

            if (empty($data)) {
                throw new LocalizedException(__('Invalid form data.'));
            }

            $model = $this->listFactory->create();

            if (!empty($data['lista_id'])) {
                $model->load($data['lista_id']);
                if (!$model->getId()) {
                    throw new LocalizedException(__('Esta lista não existe.'));
                }
            }

            // Prepara os dados para salvar
            $saveData = [
                'titulo' => $data['titulo'] ?? '',
                'description' => $data['description'] ?? '',
            ];

            if (isset($data['customer_groups'])) {
                $saveData['customer_groups'] = is_array($data['customer_groups']) 
                    ? implode(',', $data['customer_groups']) 
                    : $data['customer_groups'];
            }

            $this->logger->info('Save Data: ' . print_r($saveData, true));

            $model->addData($saveData);
            $this->logger->info('Model Data Before Save: ' . print_r($model->getData(), true));

            $model->save();
            $this->logger->info('Model Data After Save: ' . print_r($model->getData(), true));

            $this->messageManager->addSuccessMessage(__('Lista salva com sucesso.'));
            $this->dataPersistor->clear('lista_sugestoes');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['lista_id' => $model->getId()]);
            }
            return $resultRedirect->setPath('*/*/');

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->logger->error('LocalizedException: ' . $e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Ocorreu um erro ao salvar a lista.'));
            $this->logger->error('Exception: ' . $e->getMessage());
            $this->logger->error('Stack trace: ' . $e->getTraceAsString());
        }

        $this->dataPersistor->set('lista_sugestoes', $data ?? []);
        return $resultRedirect->setPath('*/*/edit', ['lista_id' => $this->getRequest()->getParam('lista_id')]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bistwobis_ListaSugestoes::lista_manage');
    }
} 