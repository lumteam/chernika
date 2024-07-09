<?php

namespace DVS\Provider;

// use Bitrix\Catalog\Product\QuantityControl;
use Bitrix\Iblock\ORM\Query;

class Custom extends \Bitrix\Catalog\Product\CatalogProvider
{

    public function getProductData(array $products)
    {
        /** @var \Bitrix\Sale\Result $result */
        $result = parent::getProductData($products);
        // if (in_array(SITE_ID, MARKET_SITE_ID)) {
        //     return $result;
        // }

        $productData = $result->getData();
        $products    = $productData['PRODUCT_DATA_LIST'];

        if (empty($products)) {
            return $result;
        }

        // $priceId = \Bitrix\Catalog\GroupTable::getList([
        //     'select' => ['ID'],
        //     'filter' => Query::filter()
        //         ->where('NAME', PRICE_BASE__CODE)
        //     ,
        //     'cache'  => [
        //         'ttl' => 86400, // 24 hours
        //     ],
        // ])->fetch()['ID'];

        $prices = \Bitrix\Catalog\PriceTable::getList([
            'select' => ['PRODUCT_ID', 'PRICE'],
            'filter' => Query::filter()
                ->whereIn('PRODUCT_ID', array_keys($products))
                ->whereIn('CATALOG_GROUP_ID', [PRICE_BASE__CODE_ID, PRICE_BASE_SPEC__CODE_ID])
            ,
        ])->fetchAll();

        $priceResult = [];
        foreach ($prices as $price) {
            $priceResult[$price['PRODUCT_ID']][] = $price['PRICE'];
        }

        $resultList = [];
        foreach ($products as $productId => $productData) {
            foreach ($productData['PRICE_LIST'] as &$listItem) {
                $listItem['BASE_PRICE'] = min($priceResult[$productId]);
            }

            $resultList[$productId] = $productData;
        }

        if ( ! empty($resultList)) {
            $result->set('PRODUCT_DATA_LIST', $resultList);
        }

        return $result;
    }

}