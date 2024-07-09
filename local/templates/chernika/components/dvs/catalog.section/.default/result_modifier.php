<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

$colors = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR);
//$arrUrls = \PDV\Tools::getDetailPageUrl($arResult, $arParams['IBLOCK_ID']);

$arBrands = \PDV\Tools::getBrands();

$boolConvert = isset($arResult["CONVERT_CURRENCY"]["CURRENCY_ID"]);
$strBaseCurrency = '';

foreach ($arResult['ITEMS'] as $itemKey => $arItem) {
    $offersCount = count($arItem['OFFERS']);

    if (!empty($arItem['OFFERS']) && $offersCount > 1) {
        $emptyRoll = 0;

        foreach ($arItem['OFFERS'] as $offerKey => $arOffer) {
            if (intval($arOffer['CATALOG_QUANTITY']) < 1) {
                $emptyRoll++;
            }
        }
        unset($offerKey, $arOffer);

        // если не все ТП с кол-вом 0, то удаялем с кол-вом 0
        foreach ($arItem['OFFERS'] as $offerKey => $arOffer) {
            if (intval($arOffer['CATALOG_QUANTITY']) < 1 && $offersCount != $emptyRoll) {
                unset($arResult['ITEMS'][$itemKey]['OFFERS'][$offerKey]);
            }
        }
    }
}
unset($itemKey, $offerKey, $arItem, $arOffer);

foreach ($arResult['ITEMS'] as $key => & $arItem) {
    $arItem['NAME'] = str_replace('Оправа', 'Очки для зрения', $arItem['NAME']);
    $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['ID'], $arItem);

    $arItem['OFFERS_COLORS'] = \PDV\Tools::getOffersColors($arItem['OFFERS'], $colors);

    if (!empty($arItem['OFFERS'])) {
        $arItem['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromOffers(
            $arItem['OFFERS'],
            $boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency
        );
    }

    if ($arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
        $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] = $arItem['MIN_PRICE']['VALUE'];

    if (!empty($arItem['OFFERS_COLORS'])) {
        $offer = current($arItem['OFFERS_COLORS']);
        if (!empty($offer['PICTURE'])) {
            $arItem['PICTURE'] = $offer['PICTURE'][0];
        }

//        $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] = $offer['OLD_PRICE'];
//        $arItem['ITEM_PRICES'][0]['PRICE'] = $offer['PRICE'];

        $arItem['CATALOG_QUANTITY'] = $offer['QUANTITY'];
    }

    //    $arItem['DETAIL_PAGE_URL'] = $arrUrls[$arItem['ID']];
    $iblockId = $arItem['IBLOCK_ID'];
    $sectionCode = 'eyeglass-frames';
    if ($iblockId == IBLOCK_ID__CATALOG_2)
        $sectionCode = 'sunglasses';
    elseif ($iblockId == IBLOCK_ID__LENSES)
        $sectionCode = 'lenses';

    $arItem['DETAIL_PAGE_URL'] = '/' . $sectionCode . '/' . $arItem['CODE'] . '/';

    //    if (!\PDV\Tools::showPrice($arItem))
    //        $arItem['ORDER_PRICE'] = true;

    //    $productAvailable = 'PRE_ORDER';
    //    if ($arItem['CATALOG_QUANTITY'] > 0) {
    //        $productAvailable = 'IN_STOCK';
    //    }
    //
    //    if ((int)$arItem['PRICES'][PRICE_BASE__CODE]['VALUE'] > 0) {
    //        $productType = 'PRICE';
    //
    //        if ((int)$arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > 0) {
    //            $productType = 'OLD_PRICE';
    //        }
    //    } else {
    //        $productType = $productAvailable = 'NOT_SHOW_PRICE';
    //    }
    //
    //    $dbBrandProp = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], ['sort' => 'asc'], ['CODE' => 'BRAND']);
    //    if ($arBrandProp = $dbBrandProp->Fetch()) {
    //        if (!empty($arBrands[$arBrandProp['VALUE']]['PROPERTY_NOT_SHOW_PRICE_VALUE'])) {print_r($arBrands[$intBrandId]);
    //            $productType = $productAvailable = 'NOT_SHOW_PRICE';
    //        }
    //    }
    //
    //    $arItem['PRODUCT_PRICE_TYPE'] = $productType;
    //    $arItem['PRODUCT_AVAILABLE'] = $productAvailable;

    $productAvailable = 'PRE_ORDER';
    if ($arItem['CATALOG_QUANTITY'] > 0) {
        $productAvailable = 'IN_STOCK';
        if (SUB_DOMAIN == 'ufa' && count($arItem['OFFERS']))
        {
            $offer_ids = [];
            
            foreach ($arItem['OFFERS'] as $offer)
                $offer_ids[] = $offer['ID'];

            $rsStore = CCatalogStoreProduct::GetList(
                array(),
                array(
                    'PRODUCT_ID' => $offer_ids,
                    'STORE_ID' => UFA_STORE_IDS
                ),
                false,
                false,
                array('AMOUNT'),
            );
            
            $q = 0;
            
            while ($store = $rsStore->Fetch())
                $q += (int) $store['AMOUNT'];

            if (!$q)
                $productAvailable = 'IN_STORE';
        }
    } elseif ($arItem['PROPERTIES']['DELIVERY_DELAY']['VALUE'] === 'Y') {
        $productAvailable = 'DELAY';
    }

    if ((int)$arItem['MIN_PRICE']['VALUE'] > 0) {
        $productType = 'PRICE';

        if ((int)$arItem['MIN_PRICE']['DISCOUNT_VALUE'] > 0) {
            $productType = 'OLD_PRICE';
        }
    } else {
        $productType = 'NOT_SHOW_PRICE';
    }

    $dbBrandProp = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], ['sort' => 'asc'], ['CODE' => 'BRAND']);
    if ($arBrandProp = $dbBrandProp->Fetch()) {
        if (!empty($arBrands[$arBrandProp['VALUE']]['PROPERTY_NOT_SHOW_PRICE_VALUE'])) {print_r($arBrands[$intBrandId]);
            $productType = 'NOT_SHOW_PRICE';
        }
    }

    $arItem['PRODUCT_PRICE_TYPE'] = $productType;
    $arItem['PRODUCT_AVAILABLE'] = $productAvailable;
}
//unset($colors);
?>