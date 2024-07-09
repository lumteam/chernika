<?
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var array $arParams */
/** @var array $arResult */

/** @var CBitrixComponentTemplate $this */

use Bitrix\Main\UserTable,
    Bitrix\Main\Context;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$request = Context::getCurrent()->getRequest();

// -----------------------------------------------
//  Свойства заказа
// -----------------------------------------------
$user = null;
$isNewUser = ($USER->IsAuthorized() && empty($arResult['USER_PROFILES']));
if ($isNewUser) {
    $user = UserTable::getList([
        'select' => ['ID', 'NAME', 'EMAIL', 'LOGIN', 'PERSONAL_PHONE'],
        'filter' => ['=ID' => (int)$USER->GetID()],
    ])->fetch();
}

$arResult['ORDER_PROPS'] = [];
foreach ($arResult['ORDER_PROP'] as $key => $properties) {
    foreach ($properties as $property) {
        if (empty($property['CODE'])) {
            continue;
        }

        if (
            $isNewUser
            && empty($property['VALUE'])
            && is_null($request->get('ORDER_PROP_' . $property['ID']))
        ) {
            if ($property['IS_EMAIL'] === 'Y') {
                $property['VALUE'] = $user['EMAIL'];
                $property['VALUE_FORMATED'] = $property['VALUE'];
            } elseif ($property['IS_PAYER'] === 'Y') {
                $property['VALUE'] = $user['NAME'];
                $property['VALUE_FORMATED'] = $property['VALUE'];
            } elseif ($property['IS_PHONE'] === 'Y') {
                $property['VALUE'] = $user['PERSONAL_PHONE'] ?: $user['LOGIN'];
                $property['VALUE_FORMATED'] = $property['VALUE'];
            }
            $property['~VALUE'] = $property['VALUE'];
            $property['~VALUE_FORMATED'] = $user['VALUE_FORMATED'];
        }

        if ($property['IS_PHONE'] === 'Y') {
//            $property['VALUE'] = preg_replace('/\D+/', '', $property['VALUE']);
//            $property['VALUE'] = substr($property['VALUE'], -10);
            $property['VALUE'] = preg_replace('/[^\+\d]/', '', $property['VALUE']);
        }

        $arResult['ORDER_PROPS'][$property['CODE']] = $property;
    }
}

$arResult['JS_LOCATIONS'] = [];
if (!empty($arResult['ORDER_PROPS']['LOCATION']['VARIANTS'])) {
    foreach ($arResult['ORDER_PROPS']['LOCATION']['VARIANTS'] as $location) {
        if (empty($location['CITY_NAME']))
            continue;
        $arResult['JS_LOCATIONS'][] = $location['CITY_NAME'];
    }
}

$arResult['USER_ADRESS1'] = [];
$arResult['USER_ADRESS1'] = $request->get('USER_ADRESS');

unset($arResult['ORDER_PROP']['USER_PROPS_Y'], $arResult['ORDER_PROP']['USER_PROPS_N'], $arResult['ORDER_PROP']['PRINT'], $props);