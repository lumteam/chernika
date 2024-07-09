<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult))
{?>
    <div class="viewed-header">
        <div class="viewed-title">Популярные товары</div>
        <div class="viewed-nav">
            <span class="viewed-nav popular-nav-prev" style="margin-right: 27px"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                <defs>
                    <path id="8bs0a" d="M1545.66 2312l1.34-1.32-8.75-8.68 8.75-8.68-1.34-1.32-9.66 10z"></path>
                </defs>
                <g>
                    <g transform="translate(-1536 -2292)">
                        <use fill="#7e7e7e" xlink:href="#8bs0a"></use>
                    </g>
                </g>
            </svg></span>
            <span class="viewed-nav popular-nav-next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                <defs>
                    <path id="vpwia" d="M1575.34 2312l-1.34-1.32 8.75-8.68-8.75-8.68 1.34-1.32 9.66 10z"></path>
                </defs>
                <g>
                    <g transform="translate(-1574 -2292)">
                        <use fill="#7e7e7e" xlink:href="#vpwia"></use>
                    </g>
                </g>
            </svg></span>
        </div>
    </div>	
	
<div class="popular-slider">
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
        <span class="product-title js-name"><?=$arItem['NAME']?></span>
        <span class="product-price js-prod_price">
            <?if ( $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > 0 ) {
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