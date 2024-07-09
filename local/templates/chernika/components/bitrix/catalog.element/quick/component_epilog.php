<?
if (CModule::IncludeModule('sale')) {
    \Bitrix\Catalog\CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());
}
?>