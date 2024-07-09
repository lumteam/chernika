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
?>

<div class="row">
    <div class="col-1 d-none d-md-block"></div>
    <div class="col-12 col-md-10">
        <h2 class="page-title"><?=$name?></h2>
    </div>
</div>

<div class="row">
    <div class="col-1 d-none d-md-block"></div>
    <div class="col-12 col-md-10">
        <div class="article">
            <?if ( !empty($arResult['DETAIL_PICTURE']) ):?>
                <div class="article-img mb-40"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""></div>
            <?endif;?>
            <div class="article-content">
                <?=$arResult['DETAIL_TEXT']?>
            </div>
        </div>
    </div>
</div>
