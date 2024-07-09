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

	GLOBAL $arrFilter;
	$arrFilter[">CATALOG_QUANTITY"] = 0;
}
if ($arResult["VARIABLES"]["SECTION_CODE"] == 'outlet-sunglasses') {
	$arResult["VARIABLES"]["SECTION_CODE_PATH"] = 'outlet-sunglasses';
	$arResult["VARIABLES"]["SMART_FILTER_PATH"] = 'sale-is-y';
	$arResult["VARIABLES"]["SECTION_ID"] = 774;
	$arParams["IBLOCK_ID"] = 14;

	GLOBAL $arrFilter;
	$arrFilter[">CATALOG_QUANTITY"] = 0;
}
$_banner_html = \PDV\Tools::getBannerCatalog();
$_glasses_data = array(
	'vision-glasses' => 'Очки для зрения',
	'progressive-glasses' => 'Прогрессивные очки',
	'multifocal-glasses' => 'Мультифокальные очки',
	'photochromic-glasses' => 'Фотохромные очки',
);
if (in_array($arResult["VARIABLES"]["SECTION_CODE"], array_keys($_glasses_data)))
{
	$arResult["VARIABLES"]["ORIGINAL_SECTION_CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	$arResult["VARIABLES"]["SECTION_CODE"] = 'eyeglass-frames';
	$_banner_html = str_replace(
		'любую оправу',
		'любые '.mb_strtolower($_glasses_data[$arResult["VARIABLES"]["ORIGINAL_SECTION_CODE"]], 'utf-8'),
		$_banner_html
	);
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



<?=$_banner_html;?>

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

	if (!$arResult["VARIABLES"]["ORIGINAL_SECTION_CODE"])
		$filterParam = \PDV\Tools::getParamFilterBySectId($arParams['IBLOCK_ID'], $arSect['ID']);
}

$dir = $APPLICATION->GetCurDir();

if ( $dir != $arSect['SECTION_PAGE_URL'] ) {
	$arSect['DESCRIPTION'] = '';
	$arSect['UF_DESCRIPTION_TOP'] = '';
}

$QA = "";
$arrSeoData = \PDV\Tools::getSeoFilter($dir);
if ( !empty($arrSeoData) ) {
	$arSect['UF_DESCRIPTION_TOP'] = $arrSeoData['PREVIEW_TEXT'];
	$arSect['DESCRIPTION'] = $arrSeoData['DETAIL_TEXT'];

	CModule::IncludeModule("energosoft.utils");
	$arEsItem = ESIBlock::GetByID($arrSeoData["ID"]);
	foreach($arEsItem["PROPERTIES"]["QA"]["VALUES"] as $k=>$v)
	{
		if($v != "") $QA .= '<div class="description"><div class="toggle-qa"><span>'.$v.'</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewBox="0 0 13 14"><defs><path id="pjuoa" d="M327 1064v-2h13v2z"></path><path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path></defs><g><g transform="translate(-327 -1056)"><g><use fill="#797979" xlink:href="#pjuoa"></use></g><g><use fill="#797979" xlink:href="#pjuob"></use></g></g></g></svg></div><div class="description-inner" style="display: none;"><div class="description-list"><div class="description-list" style="font-size: 18px;">'.htmlspecialchars_decode($arEsItem["PROPERTIES"]["QAA"]["VALUES"][$k]["TEXT"]).'</div></div></div></div>';
	}
	if($QA != "") $QA = '<div class="description-faq">'.$QA.'</div>';
}

if($arResult["VARIABLES"]["SECTION_CODE_PATH"] != "" && $arResult["VARIABLES"]["SMART_FILTER_PATH"] != "")
{
    $mainDir = "/".$arResult["VARIABLES"]["SECTION_CODE_PATH"]."/";
	$arrSeoMain = \PDV\Tools::getSeoFilter($mainDir);
	if(!empty($arrSeoData))
	{
		$APPLICATION->AddChainItem($arrSeoMain['NAME'], $mainDir);
	}
}
?>
<?
$year = date('Y');
$years = range(2015, $year);
?>
<style>
	#tags-tiles-top { overflow: hidden; }
	#tags-tiles-bottom { overflow: hidden; }
    #tags-tiles-seo { overflow: hidden; }
    #tags-tiles-seo-bottom { overflow: hidden; }
	.more-link {
		display: block;
		width: 100%;
		padding: 0px 8px 8px 0px;
		text-align: left;
		text-decoration: none;
	}
	.more-link:after {
		content: "\2193";
		margin-left: 8px;
		font-size: .8em;
	}
	.more-link.open:after { content: "\2191"; }
</style>
<script>
	function MoreLinkInit(id, ml, ch)
	{
		var closeHeight = '70px';
		var moreText 	= 'Подробнее';
		var lessText	= 'Свернуть';
		var duration	= '1500';
		var easing = 'linear';
		var collapsElement = id;
		var current = $(collapsElement);
        if (!ch) closeHeight = '0px';
		if (!ch || current.height() > parseInt(closeHeight)){
			current.data('fullHeight', current.height()).css('height', closeHeight);
			current.after('<a href="javascript:void(0);" class="more-link more-link-'+ml+' closed">' + moreText + '</a>');
			var openSlider = function() {
				link = $(this);
				var openHeight = link.prev(collapsElement).data('fullHeight') + 'px';
				link.prev(collapsElement).animate({'height': openHeight}, {duration: duration }, easing);
				link.text(lessText).addClass('open').removeClass('closed');
				link.unbind('click', openSlider);
				link.bind('click', closeSlider);
			}
			var closeSlider = function() {
				link = $(this);
				link.prev(collapsElement).animate({'height': closeHeight}, {duration: duration }, easing);
				link.text(moreText).addClass('closed').removeClass('open');
				link.unbind('click');
				link.bind('click', openSlider);
			}
			$('.more-link-'+ml).bind('click', openSlider);
		}
	};
</script>
<?if(intval($_GET["PAGEN_1"]) > 0):?>
    <script>
        $(document).ready(function(){
            MoreLinkInit("#tags-tiles-top", "top", true);
            MoreLinkInit("#tags-tiles-bottom", "bottom", true);
        });
    </script>
<?endif;?>
<?if ( !empty($arrSeoData['PROPERTY_DESCRIPTION_HIDDEN_VALUE']) ):?>
	<script>
        $(document).ready(function(){
            MoreLinkInit("#tags-tiles-seo", "seo", false);
            $("#tags-tiles-seo").show();
        });
	</script>
<?endif;?>
<?if ( !empty($arrSeoData['PROPERTY_BOTTOM_TEXT_VALUE']) ):?>
    <script>
        $(document).ready(function(){
            MoreLinkInit("#tags-tiles-seo-bottom", "seo-bottom", false);
            $("#tags-tiles-seo-bottom").show();
        });
    </script>
<?endif;?>
    <section class="catalog">
        <div class="container js-catalog_sort">
            <h1 class="section-title"><?=$APPLICATION->ShowTitle(false);?></h1>
			<?if ( !empty($arSect['UF_DESCRIPTION_TOP']) ):?>
                <div style="margin: 10px 0 0 0;">
                    <div class="text-content" id="tags-tiles-top"><?=str_replace($years, $year, $arSect['UF_DESCRIPTION_TOP']);?></div>
                </div>
			<?endif;?>
			<?if ( !empty($arrSeoData['PROPERTY_DESCRIPTION_HIDDEN_VALUE']) ):?>
				<div style="margin:0 0 10px 0;">
					<div class="text-content" id="tags-tiles-seo" style="display: none;"><?=$arrSeoData['PROPERTY_DESCRIPTION_HIDDEN_VALUE'];?></div>
				</div>
			<?endif;?>
			<?if ( !empty($filterParam) ):?>
                <div class="filter-elements d-xl-none"><a href="#filter-side" class="filter-btn">Фильтр</a>
                    <div class="horizontal-filter-sort">
                        <p>Сортировать по:</p>

                        <span data-href="<?=$APPLICATION->GetCurPageParam('sort=price_'.$price_order, array('sort'))?>" class="linkReplace js-filter<?if($price_order == 'asc'){?> active<?}?>"><span>Цене</span>
							<?if ( strpos($sort, 'price_') !== false ):?><!-- сверху вниз -->
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 9H14M6.28125 5H14M1 1H14" stroke="#691BE7" stroke-linecap="round"/>
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
							<?if ( strpos($sort, 'price_') !== false ):?><!-- снизу вверх -->
                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 9H14M6.28125 5H14M1 1H14" stroke="#691BE7" stroke-linecap="round"/>
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
	if ($arResult["VARIABLES"]["ORIGINAL_SECTION_CODE"]
		&& $_replace = $_glasses_data[$arResult["VARIABLES"]["ORIGINAL_SECTION_CODE"]])
		$APPLICATION->AddChainItem($_replace, '');
	else
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