<?php
namespace Bistwobis\ListaSugestoes\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class ProductActions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $listaId = $this->context->getRequestParam('id');
            
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['remove'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'listasugestoes/lista/removeproduct',
                        ['lista_id' => $listaId, 'product_id' => $item['entity_id']]
                    ),
                    'label' => __('Remove'),
                    'confirm' => [
                        'title' => __('Remove Product'),
                        'message' => __('Are you sure you want to remove this product from the list?')
                    ]
                ];
            }
        }

        return $dataSource;
    }
} 