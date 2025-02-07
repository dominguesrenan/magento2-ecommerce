<?php
namespace Bistwobis\ListaSugestoes\Block\Adminhtml\Lista\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveProductsButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save Products'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
} 