<?php
/**
 *
 * @package Lillik\PriceDecimal\Model\Plugin
 *
 * @author  Lilian Codreanu <lilian.codreanu@gmail.com>
 */


namespace Lillik\PriceDecimal\Model\Plugin;

use Lillik\PriceDecimal\Model\ConfigInterface;
use Lillik\PriceDecimal\Model\PricePrecisionConfigTrait;
use Magento\Framework\Locale\ResolverInterface;

abstract class PriceFormatPluginAbstract
{

    use PricePrecisionConfigTrait;

    /** @var ConfigInterface  */
    protected $moduleConfig;

    protected $_localeResolver;

    /**
     * @param \Lillik\PriceDecimal\Model\ConfigInterface $moduleConfig
     */
    public function __construct(
        ConfigInterface $moduleConfig,
        ResolverInterface $localeResolver
    ) {
        $this->moduleConfig  = $moduleConfig;
        $this->_localeResolver = $localeResolver;
    }
}
