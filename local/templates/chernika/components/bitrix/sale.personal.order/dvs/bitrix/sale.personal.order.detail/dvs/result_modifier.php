<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult['BASKET'] as & $basketItem) {
    $basketItem['PICTURE'] =
        \PDV\Tools::resizeImageForRetina($basketItem['DETAIL_PICTURE'], 80, 80, BX_RESIZE_IMAGE_PROPORTIONAL);
}

foreach ($arResult['BASKET'] as & $arItem) {
    $iblockId = 0;
    $dbResultElement = CIBlockElement::GetByID($arItem['PRODUCT_ID']);
    if ($arResultElement = $dbResultElement->GetNext()) {
        $iblockId = $arResultElement['IBLOCK_ID'];
    }
    unset($arResultElement, $dbResultElement);

    $dbResultElement = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => $iblockId, '=ID' => $arItem['PRODUCT_ID']],
        false,
        false,
        ['IBLOCK_ID', 'ID', 'CODE', 'DETAIL_PAGE_URL', 'PROPERTY_CML2_LINK.DETAIL_PAGE_URL']
    );
    if ($arResultElement = $dbResultElement->GetNext()) {
        $arItem['DETAIL_PAGE_URL'] = $arResultElement['DETAIL_PAGE_URL'];

        if (!empty($arResultElement['PROPERTY_CML2_LINK_DETAIL_PAGE_URL'])) {
            $arItem['DETAIL_PAGE_URL'] = $arResultElement['PROPERTY_CML2_LINK_DETAIL_PAGE_URL'];
        }
    }
}