<?
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$redirectUrl = '/personal/order/';
$redirectUrl .= $arResult['ORDER_ID'];
$redirectUrl .= '/';

if (!empty($arResult['PAY_SYSTEM'])) {	
    foreach ($arResult['PAY_SYSTEM'] as $arPaySystem) {
        if ($arPaySystem['CHECKED'] === 'Y' && $arPaySystem['PSA_HAVE_RESULT_RECEIVE'] === 'Y') {
            $redirectUrl .= '?payment=1';
        }
    }
}

if (!empty($arResult['ORDER_ID'])) {?>
    <div id="redirect"><?=$redirectUrl?></div>
<?}?>
