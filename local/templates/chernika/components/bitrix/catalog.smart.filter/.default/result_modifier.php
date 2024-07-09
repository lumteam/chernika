<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

$FILTER_NAME = (string) $arParams["FILTER_NAME"];
global ${$FILTER_NAME};
// echo '<pre>';
// var_dump(explode('/', $arParams["SMART_FILTER_PATH"]));
// echo '</pre>';
// echo '<pre>';
// var_dump(count(${$FILTER_NAME}));
// echo '</pre>';
if ($arParams["SMART_FILTER_PATH"] && count(explode('/', $arParams["SMART_FILTER_PATH"])) > count(${$FILTER_NAME}))
{
	$cp = $this->__component;
	if (is_object($cp))
	{
		$cp->abortResultCache();
		// $cp->arResult['FILTER_PATH_INCORRECT'] = 'Y';
		// $cp->SetResultCacheKeys(array('FILTER_PATH_INCORRECT'));
	}
	if (Loader::includeModule("iblock"))
	{
			Iblock\Component\Tools::process404(
				''
				,true
				,true
				,true
			);
	}
}

//сортировка значений - вместо js
foreach ($arResult["ITEMS"] as &$arItem) {

    if ($arItem["CODE"] === "BRAND") {//бренды по Сортировка

        uasort($arItem["VALUES"], function($a, $b) {
            return $a["SORT"] - $b["SORT"];
        });
    }
    else{ //все остальные параметры - по алфавиту
        uasort($arItem["VALUES"], function($a, $b) {
            return strcmp($a["VALUE"], $b["VALUE"]);
        });

    }
}
