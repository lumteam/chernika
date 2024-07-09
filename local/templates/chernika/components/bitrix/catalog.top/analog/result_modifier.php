<?
//$colors = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR);
//$arrUrls = \PDV\Tools::getDetailPageUrl( $arResult, $arParams['IBLOCK_ID'] );
$sizes = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES);

foreach ($arResult['ITEMS'] as $key => & $arItem) {
    usort($arItem['OFFERS'], function ($a, $b) {
        return $b['ID'] <=> $a['ID'];
    });
}
unset($key, $arItem);

foreach ($arResult['ITEMS'] as $key => $arItem) {
    $arResult['ITEMS'][$key]['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['ID'], $arItem);

//    $arResult['ITEMS'][$key]['OFFERS_COLORS'] = \PDV\Tools::getOffersColors($arItem['OFFERS'], $colors);
    $arResult['ITEMS'][$key]['OFFERS_COLORS'] = \PDV\Tools::getOffersColors($arItem['OFFERS'], [], $sizes);

    if ($arResult['ITEMS'][$key]['ITEM_PRICES'][0]['PRICE'] < $arResult['ITEMS'][$key]['ITEM_PRICES'][0]['BASE_PRICE'])
        $arResult['ITEMS'][$key]['PROPERTIES']['OLD_PRICE']['VALUE'] = $arResult['ITEMS'][$key]['ITEM_PRICES'][0]['BASE_PRICE'];

    if (!empty($arResult['ITEMS'][$key]['OFFERS_COLORS'])) {
        $offer = current($arResult['ITEMS'][$key]['OFFERS_COLORS']);
        if (!empty($offer['PICTURE']))
            $arResult['ITEMS'][$key]['PICTURE'] = $offer['PICTURE'][0];

        $arResult['ITEMS'][$key]['PROPERTIES']['OLD_PRICE']['VALUE'] = $offer['OLD_PRICE'];
        $arResult['ITEMS'][$key]['ITEM_PRICES'][0]['PRICE'] = $offer['PRICE'];
    }

    //    $arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = $arrUrls[ $arItem['ID'] ];
    $iblockId = $arItem['IBLOCK_ID'];

    $sectionCode = 'eyeglass-frames';
    if ($iblockId == IBLOCK_ID__CATALOG_2)
        $sectionCode = 'sunglasses';
    elseif ($iblockId == IBLOCK_ID__LENSES)
        $sectionCode = 'lenses';

    $arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = '/' . $sectionCode . '/' . $arItem['CODE'] . '/';
}
unset($arrUrls, $colors);
?>