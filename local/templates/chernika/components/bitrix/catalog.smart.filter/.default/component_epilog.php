<?php

use Bitrix\Main\Page\Asset;

if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;

// CJSCore::Init(array('fx', 'popup'));

$asset = Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH . '/js/bitrix/bx.min.js', true);
$asset->addJs(SITE_TEMPLATE_PATH . '/js/bitrix/core_ajax.min.js', true);

if (isset($templateData['TEMPLATE_THEME'])) {
    $APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}

if($_SERVER["REQUEST_METHOD"] == "GET" && preg_match("/\/sunglasses\/filter\/(.*?)\/apply\/.*?/", $arResult["FORM_ACTION"], $match))
{
	if(preg_match("/[A-Z]/", $match[1]))
	{
		LocalRedirect(ToLower($arResult["FORM_ACTION"]), false, "301 Moved Permanently");
	}
}

// if ($arResult['FILTER_PATH_INCORRECT'] === 'Y')
// {
//     CHTTP::SetStatus("404 Not Found");
//     @define("ERROR_404","Y");
// }
