<?php
namespace Bistwobis\ListaSugestoes\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class TipoCliente implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'varejo', 'label' => __('Varejo')],
            ['value' => 'atacado', 'label' => __('Atacado')],
            ['value' => 'distribuidor', 'label' => __('Distribuidor')]
        ];
    }
} 