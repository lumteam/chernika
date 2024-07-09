<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

// make actual product price
$eventManager->addEventHandler (
    'sale',
    'OnSaleBasketItemRefreshData',
    [
        '\\DVS\\Handlers\\Price',
        'setPriceProvider'
    ]
);

$eventManager->addEventHandler (
    'main',
    'OnBeforeUserRegister',
    [
        '\\PDV\\Handlers\\User',
        'updateUserLogin'
    ]
);
$eventManager->addEventHandler (
    'main',
    'OnBeforeUserUpdate',
    [
        '\\PDV\\Handlers\\User',
        'updateUserLogin'
    ]
);
$eventManager->addEventHandler (
    'main',
    'OnBeforeUserAdd',
    [
        '\\PDV\\Handlers\\User',
        'updateUserLogin'
    ]
);

$eventManager->addEventHandler (
    'catalog',
    'OnPriceAdd',
    array (
        '\\PDV\\Handlers\\Iblock',
        'updatePrice'
    )
);
$eventManager->addEventHandler (
    'catalog',
    'OnPriceUpdate',
    array (
        '\\PDV\\Handlers\\Iblock',
        'updatePrice'
    )
);

$eventManager->addEventHandler (
    'iblock',
    'OnAfterIBlockElementAdd',
    array(
        '\\PDV\\Handlers\\Iblock',
        'updateElement'
    )
);
$eventManager->addEventHandler (
    'iblock',
    'OnAfterIBlockElementUpdate',
    array(
        '\\PDV\\Handlers\\Iblock',
        'updateElement'
    )
);
$eventManager->addEventHandler (
    'iblock',
    'OnAfterIBlockElementSetPropertyValues',
    array(
        '\\PDV\\Handlers\\Iblock',
        'updateElementValues'
    )
);
$eventManager->addEventHandler (
    'iblock',
    'OnAfterIBlockElementSetPropertyValuesEx',
    array(
        '\\PDV\\Handlers\\Iblock',
        'updateElementValues'
    )
);

$eventManager->addEventHandler (
    'catalog',
    'OnProductAdd',
    array (
        '\\PDV\\Handlers\\Iblock',
        'updateCount'
    )
);
$eventManager->addEventHandler (
    'catalog',
    'OnProductUpdate',
    array (
        '\\PDV\\Handlers\\Iblock',
        'updateCount'
    )
);

$eventManager->addEventHandler (
    'iblock',
    'OnBeforeIBlockElementUpdate',
    array (
        '\\PDV\\Handlers\\Iblock',
        'onBeforeIBlockElementUpdate'
    )
);

$eventManager->addEventHandler(
    '',
    'RedirektyOnBeforeAdd',
    array (
        '\\PDV\\Handlers\\Highload',
        'onBeforeAdd'
    )
);

$eventManager->addEventHandler(
    '',
    'PodmenaurlovOnBeforeAdd',
    array (
        '\\PDV\\Handlers\\Highload',
        'onBeforeAdd'
    )
);

$eventManager->addEventHandler(
    '',
    'ModelsWithColorsOnBeforeAdd',
    array (
        '\\PDV\\Handlers\\Highload',
        'onBeforeAdd'
    )
);

$eventManager->addEventHandler(
    '',
    'ModelsWithColorsOnBeforeUpdate',
    array (
        '\\PDV\\Handlers\\Highload',
        'onBeforeAdd'
    )
);

$eventManager->addEventHandler(
    '',
    'PodmenaurlovOnAfterAdd',
    array (
        '\\PDV\\Handlers\\Highload',
        'createPodmenaFile'
    )
);

$eventManager->addEventHandler(
    '',
    'PodmenaurlovOnAfterUpdate',
    array (
        '\\PDV\\Handlers\\Highload',
        'createPodmenaFile'
    )
);

if ( intval($_REQUEST['IBLOCK_ID']) == IBLOCK_ID__CATALOG && !empty($_REQUEST['save']) ) {
    \Bitrix\Main\Loader::includeModule('iblock');
    foreach ( $_REQUEST['IBLOCK_SECTION'] as $id => $arSects ) {
        \CIBlockElement::SetElementSection($id, $arSects);
        \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(IBLOCK_ID__CATALOG, $id);
    }
}

$eventManager->addEventHandler (
    'main',
    'OnAdminListDisplay',
    array (
        '\\PDV\\Handlers\\Iblock',
        'MyOnAdminListDisplay'
    )
);

$eventManager->addEventHandler (
    'catalog',
    'OnSuccessCatalogImport1C',
    array (
        '\\PDV\\Tools',
        'OnSuccessCatalogImport1C'
    )
);

$eventManager->addEventHandler (
    'main',
    'OnEndBufferContent',
    array (
        '\\PDV\\Tools',
        'changeSpbHead'
    )
);

$eventManager->addEventHandler(
    'sale',
    'OnSaleOrderSaved',
    array (
        '\\PDV\\Handlers\\Sale',
        'orderSaved'
    )
);