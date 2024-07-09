<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $arAnalogFilter;
$arAnalogFilter = $arResult;
if(!empty($arResult))
{?>
    <div class="viewed-header">
        <div class="viewed-title"><?=GetMessage("SBT_ANALOG_TITLE")?></div>
        <div class="viewed-nav">
            <span class="viewed-nav analog-nav-prev" style="margin-right: 27px"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                <defs>
                    <path id="8bs0a" d="M1545.66 2312l1.34-1.32-8.75-8.68 8.75-8.68-1.34-1.32-9.66 10z"></path>
                </defs>
                <g>
                    <g transform="translate(-1536 -2292)">
                        <use fill="#7e7e7e" xlink:href="#8bs0a"></use>
                    </g>
                </g>
            </svg></span>
            <span class="viewed-nav analog-nav-next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                <defs>
                    <path id="vpwia" d="M1575.34 2312l-1.34-1.32 8.75-8.68-8.75-8.68 1.34-1.32 9.66 10z"></path>
                </defs>
                <g>
                    <g transform="translate(-1574 -2292)">
                        <use fill="#7e7e7e" xlink:href="#vpwia"></use>
                    </g>
                </g>
            </svg></span>
        </div>
    </div>	
	<?$APPLICATION->IncludeComponent("bitrix:catalog.top", "analog", array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
	    "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
	    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
	    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	    "FILTER_NAME" => "arAnalogFilter",
	    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
	    "ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
	    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
	    "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
	    "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
	    "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
	    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
	    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
	    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
	    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
	    "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
	    "SECTION_URL" => $arParams["SECTION_URL"],
	    "DETAIL_URL" => $arParams["DETAIL_URL"],
	    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
	    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
	    "CACHE_TIME" => $arParams["CACHE_TIME"],
	    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	    "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
	    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
	    "PRICE_CODE" => $arParams["PRICE_CODE"],
	    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
	    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
	    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
	    "BASKET_URL" => $arParams["BASKET_URL"],
	    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
	    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
	    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
	    "ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
	    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
	    "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
	    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
	    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
	    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"]
		),
		$component
	);

}
