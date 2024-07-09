<?
$CITY_NAME = $_SESSION['GEO_IP']['NAME'];

if (!in_array($CITY_NAME, $arResult["PROPERTIES"]["CITY"]["VALUE"]))
{
	$cp = $this->__component;
	if (is_object($cp))
		$cp->abortResultCache();
	if (Bitrix\Main\Loader::includeModule("iblock"))
		Bitrix\Iblock\Component\Tools::process404(
			''
			,true
			,true
			,true
		);
}

$CITY_ID = $_SESSION['GEO_IP']['ID'];
$QA = "";
$WARRANTY = "";

if($CITY_ID == 84)
{
	if($arResult["PROPERTIES"]["WARRANTY"]["~VALUE"]["TEXT"] != "")
	{
		$WARRANTY = $arResult["PROPERTIES"]["WARRANTY"]["~VALUE"]["TEXT"];
	}
	foreach($arResult["PROPERTIES"]["QA"]["VALUE"] as $k=>$v)
	{
		if($v != "") $QA .= '<div class="description"><div class="toggle-qa"><span>'.$v.'</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewBox="0 0 13 14"><defs><path id="pjuoa" d="M327 1064v-2h13v2z"></path><path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path></defs><g><g transform="translate(-327 -1056)"><g><use fill="#797979" xlink:href="#pjuoa"></use></g><g><use fill="#797979" xlink:href="#pjuob"></use></g></g></g></svg></div><div class="description-inner" style="display: none;"><div class="description-list"><div class="description-list" style="font-size: 18px;">'.$arResult["PROPERTIES"]["QAA"]["~VALUE"][$k]["TEXT"].'</div></div></div></div>';
	}
}
elseif($CITY_ID == 85)
{
	if($arResult["PROPERTIES"]["WARRANTY_SPB"]["~VALUE"]["TEXT"] != "")
	{
		$WARRANTY = $arResult["PROPERTIES"]["WARRANTY_SPB"]["~VALUE"]["TEXT"];
	}
	foreach($arResult["PROPERTIES"]["QA_SPB"]["VALUE"] as $k=>$v)
	{
		if($v != "") $QA .= '<div class="description"><div class="toggle-qa"><span>'.$v.'</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewBox="0 0 13 14"><defs><path id="pjuoa" d="M327 1064v-2h13v2z"></path><path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path></defs><g><g transform="translate(-327 -1056)"><g><use fill="#797979" xlink:href="#pjuoa"></use></g><g><use fill="#797979" xlink:href="#pjuob"></use></g></g></g></svg></div><div class="description-inner" style="display: none;"><div class="description-list"><div class="description-list" style="font-size: 14px;">'.$arResult["PROPERTIES"]["QAA_SPB"]["~VALUE"][$k]["TEXT"].'</div></div></div></div>';
	}
}
elseif($CITY_ID == 2)
{
	if($arResult["PROPERTIES"]["WARRANTY_UFA"]["~VALUE"]["TEXT"] != "")
	{
		$WARRANTY = $arResult["PROPERTIES"]["WARRANTY_UFA"]["~VALUE"]["TEXT"];
	}
	foreach($arResult["PROPERTIES"]["QA_UFA"]["VALUE"] as $k=>$v)
	{
		if($v != "") $QA .= '<div class="description"><div class="toggle-qa"><span>'.$v.'</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewBox="0 0 13 14"><defs><path id="pjuoa" d="M327 1064v-2h13v2z"></path><path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path></defs><g><g transform="translate(-327 -1056)"><g><use fill="#797979" xlink:href="#pjuoa"></use></g><g><use fill="#797979" xlink:href="#pjuob"></use></g></g></g></svg></div><div class="description-inner" style="display: none;"><div class="description-list"><div class="description-list" style="font-size: 14px;">'.$arResult["PROPERTIES"]["QAA_UFA"]["~VALUE"][$k]["TEXT"].'</div></div></div></div>';
	}
}
if($QA != "") $QA = '<div class="description-faq">'.$QA.'</div>';

$arResult['DETAIL_TEXT'] = str_replace("#ES_QA_BLOCK#", $QA, $arResult['DETAIL_TEXT']);
$arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_SPB']['DISPLAY_VALUE'] = str_replace("#ES_QA_BLOCK#", $QA, $arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_SPB']['DISPLAY_VALUE']);
$arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_UFA']['DISPLAY_VALUE'] = str_replace("#ES_QA_BLOCK#", $QA, $arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_UFA']['DISPLAY_VALUE']);

$cp = $this->__component;
if(is_object($cp))
{
	$cp->arResult['WARRANTY'] = $WARRANTY;
	$cp->SetResultCacheKeys(array('WARRANTY'));
}
?>