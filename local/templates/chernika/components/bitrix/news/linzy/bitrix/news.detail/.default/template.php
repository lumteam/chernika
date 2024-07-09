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
$this->setFrameMode(true);

$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];

$CITY_ID = $_SESSION['GEO_IP']['ID'];
?>
<!--div class="row">
    <div class="col-1 d-none d-md-block"></div>
</div>

<div class="row">
    <div class="col-1 d-none d-md-block"></div>
    <div class="col-12 col-md-10 "-->
        <div class="article">
            <?if ( !empty($arResult['DETAIL_PICTURE']) ):?>
                <div class="article-img mb-40"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""></div>
            <?endif;?>
            <div class="article-content">
<? if ($CITY_ID == 84) { ?>
    <!--МСК-->
    <?= $arResult['DETAIL_TEXT']; ?>
    <?if ( !empty($arResult['DISPLAY_PROPERTIES']['FILE']['VALUE']) ):?>
        <a href="<?=CFile::GetPath($arResult['DISPLAY_PROPERTIES']['FILE']['VALUE'])?>" class="pdf_dwnld" target="_blank"><div class="icon"><img src="/local/templates/chernika/img/excel.svg" alt=""></div> Скачать прайс лист</a>
    <?endif;?>
<?} elseif ($CITY_ID == 85){?> 
    <!--СПБ-->
    <?= $arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_SPB']['DISPLAY_VALUE']; ?>
    <?if ( !empty($arResult['DISPLAY_PROPERTIES']['FILESPB']['VALUE']) ):?>
        <a href="<?=CFile::GetPath($arResult['DISPLAY_PROPERTIES']['FILESPB']['VALUE'])?>" class="pdf_dwnld" target="_blank"><div class="icon"><img src="/local/templates/chernika/img/excel.svg" alt=""></div> Скачать прайс лист</a>
    <?endif;?>
<? } elseif ($CITY_ID == 2) { ?>
    <!--УФА-->
    <?= $arResult['DISPLAY_PROPERTIES']['DETAIL_TEXT_UFA']['DISPLAY_VALUE']; ?>
    <? if (!empty($arResult['DISPLAY_PROPERTIES']['FILEUFA']['VALUE'])): ?>
        <a href="<?=CFile::GetPath($arResult['DISPLAY_PROPERTIES']['FILEUFA']['VALUE'])?>" class="pdf_dwnld" target="_blank"><div class="icon"><img src="/local/templates/chernika/img/excel.svg" alt=""></div>Скачать прайс лист</a>
    <? endif; ?>
<?}?>

  
            </div>
        </div>
    <!--/div>
</div-->
<!--<? //print_r($arResult);?> -->
