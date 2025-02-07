<?php
namespace Bistwobis\ListaSugestoes\Controller\Lista;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Bistwobis\ListaSugestoes\Model\ListaFactory;

class View extends Action
{
    protected $resultPageFactory;
    protected $listaFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ListaFactory $listaFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->listaFactory = $listaFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $listaId = $this->getRequest()->getParam('id');
        $lista = $this->listaFactory->create()->load($listaId);

        if (!$lista->getId()) {
            $this->messageManager->addErrorMessage(__('Lista não encontrada.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($lista->getTitulo());
        return $resultPage;
    }
} 