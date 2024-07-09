<?php

global $APPLICATION;
\Bitrix\Main\Loader::includeModule('highloadblock');

$hlblock            = \Bitrix\Highloadblock\HighloadBlockTable::getById(HIGHBLOCK_ID__REDIRECT)->fetch();
$hlentity           = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$strEntityDataClass = $hlentity->getDataClass();

$rsData = $strEntityDataClass::getList([
    'select' => ['UF_LINK'],
    'filter' => ['=UF_NAME' => $APPLICATION->GetCurPage(false)],
]);
if ($arItem = $rsData->Fetch()) {
    LocalRedirect($arItem['UF_LINK'], false, '301 Moved permanently');
}