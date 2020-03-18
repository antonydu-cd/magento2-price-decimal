<?php
/**
 *
 * @package package Lillik\PriceDecimal\Model\Plugin\Local
 *
 * @author  Lilian Codreanu <lilian.codreanu@gmail.com>
 */

namespace Lillik\PriceDecimal\Model\Plugin\Local;

use Lillik\PriceDecimal\Model\Plugin\PriceFormatPluginAbstract;

class Format extends PriceFormatPluginAbstract
{
    private const JAPAN_LOCALE_CODE = 'ja_JP';

    /**
     * {@inheritdoc}
     *
     * @param $subject
     * @param $result
     *
     * @return mixed
     */
    public function afterGetPriceFormat($subject, $result)
    {
        $precision = $this->getPricePrecision();

        if ($this->getConfig()->isEnable()) {
            $result['precision'] = $precision;
            $result['requiredPrecision'] = $precision;
        }

        return $result;
    }

    public function aroundGetNumber(
        $subject, 
        \Closure $proceed,
        $value
    ){
        $precision = $this->getPricePrecision();

        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            return (float)$value;
        }

        //trim spaces and apostrophes
        $value = preg_replace('/[^0-9^\^.,-]/m', '', $value);

        $separatorComa = strpos($value, ',');
        $separatorDot = strpos($value, '.');

        if ($separatorComa !== false && $separatorDot !== false) {
            if ($separatorComa > $separatorDot) {
                $value = str_replace(['.', ','], ['', '.'], $value);
            } else {
                $value = str_replace(',', '', $value);
            }
        } elseif ($separatorComa !== false) {
            $locale = $this->_localeResolver->getLocale();
            /**
             * It's hard code for Japan locale.
             * Comma separator uses as group separator: 4,000 saves as 4,000.00
             */
            $value = str_replace(
                ',',
                $locale === self::JAPAN_LOCALE_CODE || $this->getConfig()->isEnable() && $precision == 0 ? '' : '.',
                $value
            );
        }

        return (float)$value;
    }
}
