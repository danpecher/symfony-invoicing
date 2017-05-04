<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter($price, $currency)
    {
        $currencies  = [
            'CZK' => [
                'symbol' => 'Kč',
                'before' => false
            ],
            'EUR' => [
                'symbol' => '€',
                'before' => false
            ],
            'USD' => [
                'symbol' => '$',
                'before' => true
            ],
        ];
        $currencyDef = isset($currencies[$currency]) ? $currencies[$currency] : null;
        if (!$currencyDef) {
            return $price . ' ???';
        }
        $formatted = $currencyDef['before'] ? $currencyDef['symbol'] : '';
        $formatted .= $price;
        $formatted .= !$currencyDef['before'] ? ' ' . $currencyDef['symbol'] : '';


        return $formatted;
    }
}