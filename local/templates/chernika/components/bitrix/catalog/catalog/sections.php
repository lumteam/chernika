<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

$this->setFrameMode(true);
?>

<?
//$CITY_NAME = \Bitrix\Main\Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME');
$CITY_NAME = $_SESSION['GEO_IP']['NAME'];
$GLOBALS['arrFilterSlider'] = ['ID' => \PDV\Tools::getSliderIdsByCity($CITY_NAME)];
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "slider-home",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "Y",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("DETAIL_PICTURE", ""),
        "FILTER_NAME" => "arrFilterSlider",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => IBLOCK_ID__SLIDER,
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "100",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "DESC",
        "STRICT_SECTION_CHECK" => "N",
        "IS_MOBILE" => IS_MOBILE,
        "IS_TABLET" => IS_TABLET,
    )
);?>


<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "brands",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "Y",
        "CHECK_DATES" => "N",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("", ""),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => IBLOCK_ID__BRAND,
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "24",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("LINK", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "NAME",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    )
);?>


<div class="container">
    <section class="categories">
        <?$APPLICATION->IncludeComponent(
            "bitrix:advertising.banner",
            "",
            Array(
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "Y",
                "NOINDEX" => "N",
                "QUANTITY" => "1",
                "TYPE" => "HOME_BIG",
                "SITE_ID" => SITE_ID,
            )
        );?>
        <div class="categories-column">
            <?$APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "Y",
                    "NOINDEX" => "N",
                    "QUANTITY" => "1",
                    "TYPE" => "HOME_RIGHT_1",
                    "SITE_ID" => SITE_ID,
                )
            );?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "Y",
                    "NOINDEX" => "N",
                    "QUANTITY" => "1",
                    "TYPE" => "HOME_RIGHT_2",
                    "SITE_ID" => SITE_ID,
                )
            );?>
        </div>
    </section>
    <div class="clearfix"></div>
<?if(IS_MOBILE):?>
<?else:?>
    <section class="categories sales">
        <div class="categories-item sales-item">
            <?$APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "Y",
                    "NOINDEX" => "N",
                    "QUANTITY" => "1",
                    "TYPE" => "HOME_LABEL_1",
                    "SITE_ID" => SITE_ID,
                )
            );?>
        </div>
        <div class="categories-item sales-item">
            <?$APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "Y",
                    "NOINDEX" => "N",
                    "QUANTITY" => "1",
                    "TYPE" => "HOME_LABEL_2",
                    "SITE_ID" => SITE_ID,
                )
            );?>
        </div>
        <div class="categories-item sales-item">
            <?$APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "Y",
                    "NOINDEX" => "N",
                    "QUANTITY" => "1",
                    "TYPE" => "HOME_LABEL_3",
                    "SITE_ID" => SITE_ID,
                )
            );?>
        </div>
    </section>
    <div class="clearfix"></div>
<?endif;?>

    <?//include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/home-viewed.php');?>

    <section class="text_subscribe">
        <div class="text_subscribe-left">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                ".default",
                array(
                    "AREA_FILE_SHOW" => "page",
                    "AREA_FILE_SUFFIX" => "home_inc",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default"
                ),
                false
            );?>
        </div>
        <div class="text_subscribe-right">
            <?include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/subscribe.php');?>
        </div>
    </section>
</div>
