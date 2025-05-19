<?php
/**
 * Classe de configuração para o módulo de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * Caminhos de configuração
     */
    const XML_PATH_ENABLED = 'extended_warranty/general/enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Construtor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Verifica se o módulo está habilitado
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
