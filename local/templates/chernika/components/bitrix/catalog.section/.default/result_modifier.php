<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

$colors = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR);
//$arrUrls = \PDV\Tools::getDetailPageUrl($arResult, $arParams['IBLOCK_ID']);

$arBrands = \PDV\Tools::getBrands();

$_glasses_data = array(
    'vision-glasses' => 'Очки для зрения',
    'progressive-glasses' => 'Прогрессивные очки',
    'multifocal-glasses' => 'Мультифокальные очки',
    'photochromic-glasses' => 'Фотохромные очки',
    'sports-glasses' => 'Спортивные очки'
);
$_code = trim($arParams["CURRENT_BASE_PAGE"], "/");
$_do_replace = in_array($_code, array_keys($_glasses_data));

foreach ($arResult['ITEMS'] as $key => & $arItem) {
    if ($_do_replace)
        $arItem['NAME']
            = ($_code === 'sports-glasses')
            ? str_replace('Солнцезащитные очки', $_glasses_data[$_code], $arItem['NAME'])
            : str_replace('Оправа', $_glasses_data[$_code], $arItem['NAME']);
        
    $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['ID'], $arItem);

    $arItem['OFFERS_COLORS'] = \PDV\Tools::getOffersColors($arItem['OFFERS'], $colors);
//    $arItem['OFFERS_COLORS'] = [];

    if ($arItem['ITEM_PRICES'][0]['PRICE'] < $arItem['ITEM_PRICES'][0]['BASE_PRICE'])
        $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] = $arItem['ITEM_PRICES'][0]['BASE_PRICE'];

    if (!empty($arItem['OFFERS_COLORS'])) {
        $offer = current($arItem['OFFERS_COLORS']);
        if (!empty($offer['PICTURE']))
            $arItem['PICTURE'] = $offer['PICTURE'][0];

        $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] = $offer['OLD_PRICE'];
        $arItem['ITEM_PRICES'][0]['PRICE'] = $offer['PRICE'];

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

    if ((int)$arItem['ITEM_PRICES'][0]['PRICE'] > 0) {
        $productType = 'PRICE';

        if ((int)$arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > 0) {
            $productType = 'OLD_PRICE';
        }
    } else {
        $productType = 'NOT_SHOW_PRICE';
    }

    if (!empty($arBrands[$arItem['PROPERTIES']['BRAND']['VALUE']]['PROPERTY_NOT_SHOW_PRICE_VALUE'])) {
        $productType = 'NOT_SHOW_PRICE';
    }

    $arItem['PRODUCT_PRICE_TYPE'] = $productType;
    $arItem['PRODUCT_AVAILABLE'] = $productAvailable;
}
//unset($colors);

$cp = $this->__component;
if (is_object($cp))
{
    $cp->arResult['ITEMS_COUNT'] = count($arResult['ITEMS']);
    $cp->SetResultCacheKeys(array('ITEMS_COUNT'));
}
