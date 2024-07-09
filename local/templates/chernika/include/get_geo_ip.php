<?php

if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if ( ! isset($_SESSION['CITIES_LIST'])) {
    $_SESSION['CITIES_LIST'][84] = [
        'ID'              => 84,
        'NAME'            => 'Москва',
        'NAME_DECLENSION' => 'Москве',
        'SUB_DOMAIN'      => '',
        'DEFAULT'         => 'Y',
    ];
    $_SESSION['CITIES_LIST'][85] = [
        'ID'              => 85,
        'NAME'            => 'Санкт-Петербург',
        'NAME_DECLENSION' => 'Санкт-Петербурге',
        'SUB_DOMAIN'      => 'spb',
    ];
	$_SESSION['CITIES_LIST'][2] = [
		'ID'              => 2,
		'NAME'            => 'Уфа',
		'NAME_DECLENSION' => 'Уфе',
		'SUB_DOMAIN'      => 'ufa',
	];

//    if (in_array(SITE_ID, ['m1', 'm2'])) {
//        $_SESSION['CITIES_LIST'][84]['SUB_DOMAIN'] = 'market';
//        $_SESSION['CITIES_LIST'][85]['SUB_DOMAIN'] = 'market-spb';
//    }
}

$mskSubDomain = $_SESSION['CITIES_LIST'][84]['SUB_DOMAIN'];
$spbSubDomain = $_SESSION['CITIES_LIST'][85]['SUB_DOMAIN'];

if ( ! isset($_SESSION['IS_IP_GEO_BASE'])) {
    $_SESSION['IS_IP_GEO_BASE'] = false;
}

$isRedirect = false;

function clearSelectedCities(&$arResult)
{
    foreach ($arResult as & $arValue) {
        $arValue['SELECTED'] = '';
    }
}

clearSelectedCities($_SESSION['CITIES_LIST']);

foreach ($_SESSION['CITIES_LIST'] as $key => $city) {
    if ($city['SUB_DOMAIN'] === SUB_DOMAIN) {
        $_SESSION['CITIES_LIST'][$key]['SELECTED'] = 'Y';

        $_SESSION['GEO_IP'] = $_SESSION['CITIES_LIST'][$key];
    }

    if ($mskSubDomain === SUB_DOMAIN && false === $_SESSION['IS_IP_GEO_BASE']) {
        $arGeo = \PDV\Altasib::GetAddr();

        if ('САНКТ-ПЕТЕРБУРГ' === mb_strtoupper($arGeo['city'])) {
            clearSelectedCities($_SESSION['CITIES_LIST']);
            $_SESSION['CITIES_LIST'][85]['SELECTED'] = 'Y';
            $isRedirect                              = true;
        }

        $_SESSION['IS_IP_GEO_BASE'] = true;

        break;
    }

    if ($spbSubDomain === SUB_DOMAIN) {
        $_SESSION['IS_IP_GEO_BASE'] = true;
    }
}
unset($key, $city);

if (true === $isRedirect) {
    LocalRedirect(PROTOCOL . $spbSubDomain . '.' . CUSTOM_HTTP_HOST . CURRENT_DIR);
}

$CITY_NAME = $_SESSION['GEO_IP']['NAME'];
$CITY_ID   = $_SESSION['GEO_IP']['ID'];

///

// if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
//     die();
//
// // @TODO: Переделать на получение данных из ИБ 36
// if (!isset($_SESSION['CITIES_LIST'])) {
//     $_SESSION['CITIES_LIST'] = [
// //        'msk' => ['ID' => 84, 'NAME' => 'Москва', 'SUB_DOMAIN' => '', 'DEFAULT' => 'Y'],
// //        'spb' => ['ID' => 85, 'NAME' => 'Санкт-Петербург', 'SUB_DOMAIN' => 'spb'],
//         84 => ['ID' => 84, 'NAME' => 'Москва', 'NAME_DECLENSION' => 'Москве', 'SUB_DOMAIN' => '', 'DEFAULT' => 'Y'],
//         85 => ['ID' => 85, 'NAME' => 'Санкт-Петербург', 'NAME_DECLENSION' => 'Санкт-Петербурге', 'SUB_DOMAIN' => 'spb'],
//     ];
// }
//
// foreach ($_SESSION['CITIES_LIST'] as $cityCode => $arCity) {
//     if (isset($arCity['DEFAULT'])) {
//         define('DEFAULT_CITY_ID', $arCity['ID']); // default in defines.php
//         break;
//     }
// }
// unset($cityCode, $arCity);
//
// function clearSelectedCities(& $arResult) {
//     foreach ($arResult as & $arValue) {
//         if (!empty($arValue['SELECTED'])) {
//             $arValue['SELECTED'] = '';
//         }
//     }
// }
//
// clearSelectedCities($_SESSION['CITIES_LIST']);
//
// if (isset($_SESSION['GEO_IP']) && !empty($_SESSION['GEO_IP'])) {
//     $subDomain = $_SESSION['GEO_IP']['SUB_DOMAIN'] ?? '';
//     if (SUB_DOMAIN != $subDomain && empty(SUB_DOMAIN)) { // зашли не первый раз и решили поменять с spb на основной домен
//         $_SESSION['CITIES_LIST'][DEFAULT_CITY_ID]['SELECTED'] = 'Y';
//         $_SESSION['IS_IP_GEO_BASE'] = 'Y';
//     }
// } elseif (empty(SUB_DOMAIN)) { // зашёл первый раз на основной домен
//     $_SESSION['CITIES_LIST'][DEFAULT_CITY_ID]['SELECTED'] = 'Y';
// }
//
// if (empty(SUB_DOMAIN) && !isset($_SESSION['IS_IP_GEO_BASE'])) { // если не спб и не делался запрос по ip
//     $arGeo = \PDV\Altasib::GetAddr();
//     $isRedirect = $isSelected = false;
//
//     if (is_array($arGeo) && !empty($arGeo['city'])) {
//         clearSelectedCities($_SESSION['CITIES_LIST']);
//
//         $geoCityNameUP = strtoupper($arGeo['city']);
//
//         foreach ($_SESSION['CITIES_LIST'] as $cityCode => & $arCity) {
//             if (strtoupper($arCity['NAME']) == $geoCityNameUP) { // если город найден в списке
//                 $arCity['SELECTED'] = 'Y';
//                 $isSelected = true;
//                 break;
//             }
//         }
//         unset($cityCode, $arCity);
//
//         if (!$isSelected && !isset($_SESSION['CITIES_LIST'][0])) {
//             $arNewCity[] = [ // добавляем город для списка выбора городов
//                 'ID' => 0, 'NAME' => $arGeo['city'], 'SUB_DOMAIN' => '', 'SELECTED' => 'Y', 'DEFAULT' => 'Y'
//             ];
//
//             $_SESSION['CITIES_LIST'] = $arNewCity + $_SESSION['CITIES_LIST'];
//         }
//     }
// } elseif (SUB_DOMAIN == 'spb' && empty($_SESSION['CITIES_LIST'][85]['SELECTED'])) {
//     clearSelectedCities($_SESSION['CITIES_LIST']);
//
//     $_SESSION['CITIES_LIST'][85]['SELECTED'] = 'Y';
// }
//
// if (isset($_REQUEST['changeCityId']) && is_numeric($_REQUEST['changeCityId'])) { // меняем город через ссылку
//     $arCity = $_SESSION['CITIES_LIST'][$_REQUEST['changeCityId']];
//     if (!empty($arCity)) {
//         clearSelectedCities($_SESSION['CITIES_LIST']);
//
//         $_SESSION['CITIES_LIST'][$_REQUEST['changeCityId']]['SELECTED'] = 'Y';
//         $_SESSION['IS_IP_GEO_BASE'] = 'Y';
//     }
// }
//
// foreach ($_SESSION['CITIES_LIST'] as $cityCode => $arCity) {
//     if ($arCity['SELECTED'] == 'Y') {
//         $_SESSION['GEO_IP'] = $_SESSION['CITIES_LIST'][$cityCode];
//
//         $subDomain = $arCity['SUB_DOMAIN'];
//
//         if (SUB_DOMAIN != $subDomain) {
//             $subDomain = trim($subDomain, '.');
//             if (!empty($subDomain)) {
//                 $subDomain .= '.';
//             }
//
//             LocalRedirect(PROTOCOL . $subDomain . CUSTOM_HTTP_HOST . CURRENT_DIR);
//         }
//         break;
//     }
// }
// unset($cityCode, $arCity);
//
// if (empty($_SESSION['GEO_IP'])) {
//     $_SESSION['GEO_IP'] = $_SESSION['CITIES_LIST'][DEFAULT_CITY_ID];
//     $_SESSION['IS_IP_GEO_BASE'] = 'Y';
// }
//
// $CITY_NAME = $_SESSION['GEO_IP']['NAME'];
// $CITY_ID = $_SESSION['GEO_IP']['ID'];