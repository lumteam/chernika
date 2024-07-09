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
    <?foreach($arResult["ITEMS"] as $i => $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="brands-page-item">
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <img class="brands-page-item-img lazyload"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                         data-src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                         alt="<?= $arItem['NAME'] ?>">
                    <noscript>
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                             width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>"
                             height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>"
                             alt="<?= $arItem['NAME'] ?>">
                    </noscript>
                </a>
                <div class="brands-page-item-text d-none d-md-block">
                    <p><?=$arItem['PREVIEW_TEXT']?></p>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
