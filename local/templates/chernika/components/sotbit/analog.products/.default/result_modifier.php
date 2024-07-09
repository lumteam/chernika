<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

$sizes = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES);

$arResult['ELEMENT_ID'] = $arResult['ID'];
$arResult['IMAGES'] = \PDV\Tools::getAllPictureIds($arResult['ID'], $arResult, 'detail');

$arResult['BRAND'] = [];
if (!empty($arResult['PROPERTIES'][PROP_CODE__BRAND]['VALUE'])) {
    $rsElem = \CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => IBLOCK_ID__BRAND, '=ID' => $arResult['PROPERTIES'][PROP_CODE__BRAND]['VALUE']],
        false,
        ['nPageSize' => 1],
        ['NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_NOT_SHOW_PRICE']
    );
    if ($arElem = $rsElem->GetNext())
        $arResult['BRAND'] = $arElem;
}

$arResult['SALOON'] = \PDV\Tools::getSaloon($arParams['CITY_NAME']);

$arResult['OFFERS_COLORS'] = \PDV\Tools::getOffersColors($arResult['OFFERS'], [], $sizes);

$arResult['SIZES'] = [];
foreach ($arResult['PROPERTIES']['SIZES']['VALUE'] as $size) {
    $arResult['SIZES'][$size] = $sizes[$size];
}

if ($arResult['ITEM_PRICES'][0]['PRICE'] < $arResult['ITEM_PRICES'][0]['BASE_PRICE'])
    $arResult['PROPERTIES']['OLD_PRICE']['VALUE'] = $arResult['ITEM_PRICES'][0]['BASE_PRICE'];

foreach ($arResult['OFFERS_COLORS'] as $key => $offer) {
    if (empty($offer['PICTURE'])) {
        $arResult['OFFERS_COLORS'][$key]['PICTURE_ID'][0] = $arResult['IMAGES'][0];
        $arResult['OFFERS_COLORS'][$key]['PICTURE'][0] = CFile::GetPath($arResult['IMAGES'][0]);
    }
}

if (!empty($arResult['OFFERS_COLORS'])) {
    $offer = current($arResult['OFFERS_COLORS']);
    if (!empty($offer['PICTURE'])) {
        unset($arResult['IMAGES']);
        $arResult['IMAGES'] = $offer['PICTURE_ID'];
    }

    $arResult['PROPERTIES']['OLD_PRICE']['VALUE'] = $offer['OLD_PRICE'];
    $arResult['ITEM_PRICES'][0]['PRICE'] = $offer['PRICE'];

    $arResult['SIZES'] = $offer['SIZES'];
    $arResult['CATALOG_QUANTITY'] = $offer['QUANTITY'];

    $arResult['ELEMENT_ID'] = $offer['ID'];
}

//if (!\PDV\Tools::showPrice($arResult))
//    $arResult['ORDER_PRICE'] = true;

$productAvailable = 'PRE_ORDER';
if ($arResult['CATALOG_QUANTITY'] > 0) {
    $productAvailable = 'IN_STOCK';
}

if ((int)$arResult['ITEM_PRICES'][0]['PRICE'] > 0) {
    $productType = 'PRICE';

    if ((int)$arResult['PROPERTIES']['OLD_PRICE']['VALUE'] > 0) {
        $productType = 'OLD_PRICE';
    }
} else {
    $productType = 'NOT_SHOW_PRICE';
}

if (!empty($arResult['BRAND']['PROPERTY_NOT_SHOW_PRICE_VALUE'])) {
    $productType = 'NOT_SHOW_PRICE';
}

$arResult['PRODUCT_PRICE_TYPE'] = $productType;
$arResult['PRODUCT_AVAILABLE'] = $productAvailable;
//print_r($productType);print_r($productAvailable);
//$arResult['PRODUCT_PRICE_TYPE'] = \PDV\Tools::getProductType($arItem);

$arResult['ALL_SALOON'] = [];
if (!in_array($arParams['CITY_NAME'], ['Москва', 'Санкт-Петербург'])) {
    $arResult['ALL_SALOON'] = \PDV\Tools::getAllSaloons();
}
