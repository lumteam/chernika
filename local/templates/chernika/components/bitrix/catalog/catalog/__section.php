<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

use Bitrix\Main\Loader;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$sort = htmlspecialchars($request->get('sort'));

Loader::includeModule("iblock");

if ($arResult["VARIABLES"]["SECTION_CODE"] == 'outlet') {
    $arResult["VARIABLES"]["SECTION_CODE_PATH"] = 'outlet';
    $arResult["VARIABLES"]["SMART_FILTER_PATH"] = 'sale-is-y';
    $arResult["VARIABLES"]["SECTION_ID"] = 612;
}
if ($arResult["VARIABLES"]["SECTION_CODE"] == 'outlet-sunglasses') {
    $arResult["VARIABLES"]["SECTION_CODE_PATH"] = 'outlet-sunglasses';
    $arResult["VARIABLES"]["SMART_FILTER_PATH"] = 'sale-is-y';
    $arResult["VARIABLES"]["SECTION_ID"] = 774;
    $arParams["IBLOCK_ID"] = 14;
}

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

		if(defined("BX_COMP_MANAGED_CACHE"))
		{
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache("/iblock/catalog");

			if ($arCurSection = $dbRes->Fetch())
				$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

			$CACHE_MANAGER->EndTagCache();
		}
		else
		{
			if(!$arCurSection = $dbRes->Fetch())
				$arCurSection = array();
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
		$arCurSection = array();
}
?>



<?=\PDV\Tools::getBannerCatalog();?>

<?$APPLICATION->IncludeComponent(
    "bitrix:breadcrumb",
    "main",
    Array(
        "PATH" => "",
        "SITE_ID" => "s1",
        "START_FROM" => "0"
    )
);?>

<?
$price_order = 'asc';
$name_order = 'asc';
if ( stripos($sort, 'price_asc') !== false )
    $price_order = 'desc';
if ( stripos($sort, 'name_asc') !== false )
    $name_order = 'desc';

$arSect = [];
$filterParam = [];
if ( !empty($arResult['VARIABLES']['SECTION_CODE']) ) {
    $rsSect = CIBlockSection::GetList(
        array(),
        array('IBLOCK_ID' => $arParams['IBLOCK_ID'], '=CODE' => $arResult['VARIABLES']['SECTION_CODE']),
        false,
        array('ID', 'NAME', 'DESCRIPTION', 'SECTION_PAGE_URL', 'UF_DESCRIPTION_TOP')
    );
    $arSect = $rsSect->GetNext();

    $filterParam = \PDV\Tools::getParamFilterBySectId($arParams['IBLOCK_ID'], $arSect['ID']);
}

$dir = $APPLICATION->GetCurDir();

if ( $dir != $arSect['SECTION_PAGE_URL'] ) {
    $arSect['DESCRIPTION'] = '';
    $arSect['UF_DESCRIPTION_TOP'] = '';
}

$arrSeoData = \PDV\Tools::getSeoFilter( $dir );
if ( !empty($arrSeoData) ) {
    $arSect['UF_DESCRIPTION_TOP'] = $arrSeoData['PREVIEW_TEXT'];
    $arSect['DESCRIPTION'] = $arrSeoData['DETAIL_TEXT'];
}
?>
<?
$year = date('Y');
$years = range(2015, $year);
?>
<section class="catalog">
	<div class="container js-catalog_sort">
		<h1 class="section-title"><?=$APPLICATION->ShowTitle(false);?></h1>
        <?if ( !empty($arSect['UF_DESCRIPTION_TOP']) ):?>
            <div style="margin: 10px 0;"><div class="text-content"><?=str_replace($years, $year, $arSect['UF_DESCRIPTION_TOP']);?></div></div>
        <?endif;?>
        <?if ( !empty($filterParam) ):?>
            <div class="filter-elements d-xl-none"><a href="#filter-side" class="filter-btn">Фильтр</a>
                <div class="horizontal-filter-sort">
                    <p>Сортировать по:</p>

                    <span data-href="<?=$APPLICATION->GetCurPageParam('sort=price_'.$price_order, array('sort'))?>" class="linkReplace js-filter<?if($price_order == 'asc'){?> active<?}?>"><span>Цене</span>
                        <?if ( strpos($sort, 'price_') !== false ):?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewbox="0 0 11 10">
                                <g fill-rule="evenodd" transform="translate(.331)">
                                    <rect width="5.052" height="2" x=".447" rx="1"></rect>
                                    <rect width="7.073" height="2" x=".447" y="4" rx="1"></rect>
                                    <rect width="10.104" height="2" x=".447" y="8" rx="1"></rect>
                                </g>
                            </svg>
                        <?endif;?>
                    </span>
                </div>
            </div>
            <div class="horizontal-filter d-none d-xl-flex align-items-center justify-content-between">
                <div class="clear-filter-btn"><a href="#" class="js-filter_reset">Сбросить все параметры <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#ff5050" viewBox="0 0 48 48"><path d="M28.2 24L47.1 5A3 3 0 0 0 47 1a3 3 0 0 0-4.3 0L24 19.7 5 1A3 3 0 0 0 1 .9 3 3 0 0 0 .9 5L19.7 24 1 42.9A3 3 0 1 0 5 47L24 28.2l18.9 18.9a3 3 0 0 0 4.2 0 3 3 0 0 0 0-4.3L28.2 24z"/></svg></a></div>
                <div class="horizontal-filter-sort">
                    <p>Сортировать по:</p>

                    <span data-href="<?=$APPLICATION->GetCurPageParam('', array('sort'))?>" class="linkReplace js-filter<?if(empty($sort)){?> active_line<?}?>"><span>Популярности</span>
                    </span>

                    <span data-href="<?=$APPLICATION->GetCurPageParam('sort=price_'.$price_order, array('sort'))?>" class="linkReplace js-filter<?if($price_order == 'asc'){?> active<?}?>"><span>Цене</span>
                        <?if ( strpos($sort, 'price_') !== false ):?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewbox="0 0 11 10">
                                <g fill-rule="evenodd" transform="translate(.331)">
                                    <rect width="5.052" height="2" x=".447" rx="1"></rect>
                                    <rect width="7.073" height="2" x=".447" y="4" rx="1"></rect>
                                    <rect width="10.104" height="2" x=".447" y="8" rx="1"></rect>
                                </g>
                            </svg>
                        <?endif;?>
                    </span>

                    <span data-href="<?=$APPLICATION->GetCurPageParam('sort=name_'.$name_order, array('sort'))?>" class="linkReplace js-filter<?if($name_order == 'asc'){?> active<?}?>"><span>Названию</span>
                        <?if ( strpos($sort, 'name_') !== false ):?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewbox="0 0 11 10">
                                <g fill-rule="evenodd" transform="translate(.331)">
                                    <rect width="5.052" height="2" x=".447" rx="1"></rect>
                                    <rect width="7.073" height="2" x=".447" y="4" rx="1"></rect>
                                    <rect width="10.104" height="2" x=".447" y="8" rx="1"></rect>
                                </g>
                            </svg>
                        <?endif;?>
                    </span>
                </div>
                <div class="horizontal-filter-chekboxes">
                    <?if ( $filterParam['NEW'] ):?>
                        <label class="checkbox">Новинки
                            <input type="checkbox" class="js-filter" data-filter="<?=($arParams['IBLOCK_ID'] == IBLOCK_ID__CATALOG_2)?'arrFilter_156_1964378601':'arrFilter_137_2626819313'?>"<?if(stripos($dir,'/new-is-y/') !== false)echo ' checked'?>>
                            <div class="control__indicator"></div>
                        </label>
                    <?endif;?>
                    <?if ( $filterParam['POPULAR'] ):?>
                        <label class="checkbox">Популярные товары
                            <input type="checkbox" class="js-filter" data-filter="<?=($arParams['IBLOCK_ID'] == IBLOCK_ID__CATALOG_2)?'arrFilter_157_34683263':'arrFilter_138_94061899'?>"<?if(stripos($dir,'/popular-is-y/') !== false)echo ' checked'?>>
                            <div class="control__indicator"></div>
                        </label>
                    <?endif;?>
                    <?if ( $filterParam['SALE'] ):?>
                        <label class="checkbox">Скидка
                            <input type="checkbox" class="js-filter" data-filter="<?=($arParams['IBLOCK_ID'] == IBLOCK_ID__CATALOG_2)?'arrFilter_158_2602068165':'arrFilter_139_1922856413'?>"<?if(stripos($dir,'/sale-is-y/') !== false)echo ' checked'?>>
                            <div class="control__indicator"></div>
                        </label>
                    <?endif;?>
                </div>
            </div>
        <?endif;?>
	</div>
	<div class="container">
		<?include('section_vertical.php'); ?>
	</div>
</section>

<?
if ( !empty($arrSeoData) ) {
    $APPLICATION->AddChainItem(str_replace($years, $year, $arrSeoData['NAME']), '');

    if ( !empty($arrSeoData['PROPERTY_H1_VALUE']) )
        $APPLICATION->SetTitle(str_replace($years, $year, $arrSeoData['PROPERTY_H1_VALUE']));
    else
        $APPLICATION->SetTitle(str_replace($years, $year, $arrSeoData['NAME']));

    if ( !empty($arrSeoData['PROPERTY_TITLE_VALUE']) )
        $APPLICATION->SetPageProperty('title', str_replace($years, $year, $arrSeoData['PROPERTY_TITLE_VALUE']));
    if ( !empty($arrSeoData['PROPERTY_DESCRIPTION_VALUE']) )
        $APPLICATION->SetPageProperty('description', str_replace($years, $year, $arrSeoData['PROPERTY_DESCRIPTION_VALUE']));
    if ( !empty($arrSeoData['PROPERTY_KEYWORDS_VALUE']) )
        $APPLICATION->SetPageProperty('keywords', str_replace($years, $year, $arrSeoData['PROPERTY_KEYWORDS_VALUE']));
}
else
    $APPLICATION->AddChainItem($arSect['NAME'], $arSect['SECTION_PAGE_URL']);
?>