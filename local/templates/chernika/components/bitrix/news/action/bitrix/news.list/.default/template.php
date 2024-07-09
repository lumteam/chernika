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

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

<div class="row">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="sales-page-item-new">
                <?if ( !empty($arItem['PREVIEW_PICTURE']) ):?>
                    <img class="sales-page-item-img lazyload"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                         data-src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                    <noscript>
                        <img class="sales-page-item-img"
                             src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                             width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>"
                             height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>"
                             alt="<?= $arItem['NAME'] ?>">
                    </noscript>
                <?endif;?>
                <div class="sales-page-item-text"><span><?=$arItem['NAME']?></span></div>
            </a>
        </div>
    <?endforeach;?>
</div>

<?foreach($arResult["ITEMS"] as $arItem):?>
    <div id="sales-modal<?=$arItem['ID']?>" class="mfp-hide actions__container">
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
        <? if (!empty($arItem['DETAIL_PICTURE'])): ?>
            <div class="sales-container-img"><img class="lazyload"
                                                  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                  data-src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"
                                                  alt="<?= $arItem['NAME'] ?>"></div>
        <? elseif (!empty($arItem['PREVIEW_PICTURE'])): ?>
            <div class="sales-container-img"><img class="lazyload"
                                                  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                  data-src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                                  alt="<?= $arItem['NAME'] ?>"></div>
        <?endif;?>
        <div class="sales-container-text">
            <h3><?=$arItem['NAME']?></h3>
            <p><?=$arItem['DETAIL_TEXT']?></p>
        </div>
    </div>
<?endforeach;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>