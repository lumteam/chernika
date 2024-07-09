<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$CITY_ID = $_SESSION['GEO_IP']['ID'];

if ($CITY_ID == 84 || $CITY_ID == 85 || $CITY_ID == 2)
{
	if($arResult["WARRANTY"] != "")
	{
		$this->initComponentTemplate();
		unset($APPLICATION->__view["ES_WARRANTY"]);
		$this->__template->SetViewTarget("ES_WARRANTY");
		echo $arResult["WARRANTY"];
		$this->__template->EndViewTarget();
	}
}
