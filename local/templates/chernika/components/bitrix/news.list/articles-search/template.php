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
?>

<?if ( !empty($arResult["ITEMS"]) ):?>
    <div class="row" style="margin-bottom: 50px;">
        <?foreach($arResult["ITEMS"] as $i => $arItem):?>
            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                <div class="article">
                    <p class="article-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></p>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="article-title"><?=$arItem['NAME']?></a>
                </div>
            </div>
        <?endforeach;?>
        <a href="<?=$arResult["ITEMS"][0]['LIST_PAGE_URL']?>" class="search-show-all-btn">Все статьи</a>
    </div>
<?endif;?>