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
        //unset($arResult['IMAGES']);
        //$arResult['IMAGES'] = $offer['PICTURE_ID'];
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
    if (SUB_DOMAIN == 'ufa' && count($arResult['OFFERS']))
    {
        foreach ($arResult['OFFERS'] as $offer)
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
} elseif ($arResult['PROPERTIES']['DELIVERY_DELAY']['VALUE'] === 'Y') {
    $productAvailable = 'DELAY';
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
if (!in_array($arParams['CITY_NAME'], ['Москва', 'Санкт-Петербург', 'Уфа'])) {
    $arResult['ALL_SALOON'] = \PDV\Tools::getAllSaloons();
}

$empty_prop = [];

foreach ($arResult['PRODUCT_PROPERTIES'] as $prop_code => $prop_value)
{
    if ($prop_value['SET'] || ($prop_value['SELECTED'] && $prop_code !== 'BRAND'))
    {
        foreach ($prop_value['VALUES'] as $val_id => $val_value)
        {
            if (intval($val_id))
            {
                $res = CIBlockProperty::GetPropertyEnum($prop_code, array(), array('ID' => $val_id));
                $v = $res->Fetch();
                if ($v && $v['EXTERNAL_ID'])
                {
                    $arResult['PRODUCT_PROPERTIES'][$prop_code]['VALUES'][$v['EXTERNAL_ID']] = $val_value;
                    unset($arResult['PRODUCT_PROPERTIES'][$prop_code]['VALUES'][$val_id]);
                }
            }
        }
    }
    else
        $empty_prop[] = $prop_code;
}

foreach ($empty_prop as $prop_code)
    unset($arResult['PRODUCT_PROPERTIES'][$prop_code]);

if ($arResult['PROPERTIES']['MODEL_WITH_COLORS'] && $arResult['PROPERTIES']['MODEL_WITH_COLORS']['VALUE'])
{
    $model_colors = [];
    $all_color_ids = [];
    $rsElem = \CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'PROPERTY_MODEL_WITH_COLORS' => $arResult['PROPERTIES']['MODEL_WITH_COLORS']['VALUE'],
        ],
        false,
        false,
        [ 'ID', 'IBLOCK_ID', 'CODE', 'PROPERTY_COLOR', 'DETAIL_PAGE_URL' ]
    );
    
    while ($color_item = $rsElem->Fetch())
    {
        if (isset($model_colors[$color_item['ID']]))
        {
            $model_colors[$color_item['ID']]['COLORS'][$color_item['PROPERTY_COLOR_VALUE']] = NULL;
        }
        else
        {
            $model_colors[$color_item['ID']] = [
                'COLORS' => [ $color_item['PROPERTY_COLOR_VALUE'] => NULL ],
                'DETAIL_PAGE_URL' => str_replace('#ELEMENT_CODE#', $color_item['CODE'] , $color_item['DETAIL_PAGE_URL']),
            ];
        }
        $all_color_ids[] = $color_item['PROPERTY_COLOR_VALUE'];
    }

    if (count($model_colors))
    {
        $colors_data = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR, array_unique($all_color_ids));

        foreach ($model_colors as $color_item_id => $color_item)
        {
            foreach ($color_item['COLORS'] as $color_id => $color_data)
            {
                $model_colors[$color_item_id]['COLORS'][$color_id] = $colors_data[$color_id];
                $model_colors[$color_item_id]['COLORS_STR'][] = $colors_data[$color_id]['UF_NAME'];
            }
            $model_colors[$color_item_id]['COLORS_STR'] = join(' / ', $model_colors[$color_item_id]['COLORS_STR']);
        }

        $arResult['MODEL_COLORS'] = $model_colors;
    }
}