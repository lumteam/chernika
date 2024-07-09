<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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

<section class="brands d-md-block">
    <div class="container">
        <div class="row">
            <? foreach ($arResult["ITEMS"] as $i => $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                ?>

                <? if ($i && $i % 6 == 0) { ?>
                </div>
                <div class="row">
                <? } ?>

                <?  // miv brands
$resize_image = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'],
Array("width" => 220, "height" => 220),
BX_RESIZE_IMAGE_PROPORTIONAL, false);
?>

                <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                    <a href="<?= (!empty($arItem['PROPERTIES']['LINK']['VALUE'])) ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem['DETAIL_PAGE_URL'] ?>" class="brands-item">
                        <img class="lazyload"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                            data-src="<?= $resize_image['src'] ?>"
                            width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>"
                            height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>"
                            alt="<?= $arItem['NAME'] ?>"
                            id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <noscript>
                            <img src="<?= $resize_image['src'] ?>" width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>" height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>" alt="<?= $arItem['NAME'] ?>">
                        </noscript>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
<?if(CSite::InDir("/index.php")):?>
        <?if (!isset($arParams['SITE_DIR'])) {?>
        <div class="row has-text-centered">
            <a href="/brands/" class="brands-all-btn js-show_brands">Смотреть все бренды</a>
        </div>
        <?}?>
<?endif;?>
    </div>
	<?if(CSite::InDir("/index.php")):?><h1 class="h1_title">Сеть фирменных салонов и интернет-магазин "Черника-Оптика"</h1><?endif;?>
</section>
