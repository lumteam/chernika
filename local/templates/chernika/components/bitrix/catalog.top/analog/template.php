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

<div class="analog-slider">
<?foreach($arResult["ITEMS"] as $key => $arItem):
	$strRowID = 'cat-top-'.$key.'_'.$randID;
	$arRowIDs[] = $strRowID;
	$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
		? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
		: $arItem['NAME']
	);
	?>
		<div class="product js-prod_card">
    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product-link" rel="nofollow">
        <div class="product-img-wrapper">
            <img class="product-img js-prod_img lazyload"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
            data-src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
            alt="<?= $arItem['NAME'] ?>"
            width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>"
            height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>">
            <noscript>
                <img class="product-img js-prod_img" src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>" height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>" alt="<?= $arItem['NAME'] ?>">
            </noscript>
        </div>
        <span class="product-title js-name">
            <?//=$arItem['NAME']?>
            <?if($arItem['PROPERTIES']['BRAND']['VALUE'] == "250857") {
                echo str_replace("Оправа CT","Оправа Cartier CT",$arItem['NAME']);
            } else {echo $arItem['NAME'];}?> 
        </span>
        <span class="product-price js-prod_price">
            <?if ( $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > 0  ) {
                if(SITE_ID!='m1') {
                    if(SITE_ID!='m2') {
                        ?>
                        <span class="product-price_old"><?=number_format($arItem['PROPERTIES']['OLD_PRICE']['VALUE'],0,'',' ')?> ₽</span>
                        <?
                    }
                }
                $withoutLenzes = $arItem['PROPERTIES']['DISCONT_WITHOUT_LENZES']['VALUE'];
                            if ($withoutLenzes =='Y') {
                                $fullPrice = number_format($arItem['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', '');
                                $priceBest =  ceil($fullPrice/2);?>
                                <span class="product-price_current"><?=number_format($priceBest,0,'',' ')?> ₽</span><?
                            } else {?>
                                <span class="product-price_current"><?=number_format($arItem['ITEM_PRICES'][0]['PRICE'],0,'',' ')?> ₽</span>
                            <?}
                            ?>

                <? } elseif ( $arItem['ITEM_PRICES'][0]['PRICE'] > 0 ) { ?>
                    <span><b><?=number_format($arItem['ITEM_PRICES'][0]['PRICE'],0,'',' ')?> ₽</b></span>
                <? } else { ?>
                    <span class="product-price_single">предзаказ</span>
                <? } ?>
            </span>
        </a>
    </div>
<?
	$boolFirst = false;
endforeach;?>
</div>
