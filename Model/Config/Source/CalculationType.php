<?php
/**
 * Classe de menu para o módulo de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class CalculationType implements ArrayInterface
{
    /**
     * Tipos de cálculo
     */
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    /**
     * Retorna as opções de tipo de cálculo
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::TYPE_FIXED, 'label' => __('Valor Fixo')],
            ['value' => self::TYPE_PERCENT, 'label' => __('Percentual')]
        ];
    }

    /**
     * Retorna as opções como array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::TYPE_FIXED => __('Valor Fixo'),
            self::TYPE_PERCENT => __('Percentual')
        ];
    }
}
