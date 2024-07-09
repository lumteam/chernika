<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 */
$this->setFrameMode(true);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_CPV_TPL_ELEMENT_DELETE_CONFIRM'));
?>

<?
if ( !empty($arResult['ITEMS']) )
{
?>

    <div class="viewed-header">
        <?/*?><h3 class="viewed-title">Просмотренные товары</h3><?*/?>
        <div class="viewed-title">Просмотренные товары</div>
        <div class="viewed-nav">
            <span class="viewed-nav viewed-nav-prev"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                <defs>
                    <path id="8bs0a" d="M1545.66 2312l1.34-1.32-8.75-8.68 8.75-8.68-1.34-1.32-9.66 10z"></path>
                </defs>
                <g>
                    <g transform="translate(-1536 -2292)">
                        <use fill="#7e7e7e" xlink:href="#8bs0a"></use>
                    </g>
                </g>
            </svg></span>
            <span class="viewed-nav viewed-nav-next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
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
    <div class="viewed-slider">
        <?
        foreach ( $arResult['ITEMS'] as $arItem )
        {
            $uniqueId = $arItem['ID'].'_'.md5($this->randString().$component->getAction());
            $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
            $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
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
                <?/*?><span class="product-like js-favorite" data-id="<?=$arItem['ID']?>">
                    <span class="tile">Добавить в избранное</span>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="10" viewbox="0 0 12 10">
                        <defs>
                            <path id="9k9za" d="M602.73 2368c-1.06 0-2.05.45-2.73 1.23a3.62 3.62 0 0 0-2.73-1.23c-.87-.02-1.72.3-2.34.9-.61.6-.95 1.41-.93 2.26.08.96.46 1.88 1.1 2.63 1.26 1.78 4.33 3.98 4.46 4.07.26.19.61.19.87 0 .14-.09 3.21-2.29 4.48-4.07a4.71 4.71 0 0 0 1.09-2.63 3.02 3.02 0 0 0-.93-2.26 3.25 3.25 0 0 0-2.34-.9z"></path>
                        </defs>
                        <g>
                            <g transform="translate(-594 -2368)">
                                <use fill="#bbb" xlink:href="#9k9za"></use>
                            </g>
                        </g>
                    </svg>
                </span>
                <div class="product-fast-view">
                    <span class="product-fast-view-btn<?if(empty($arItem['OFFERS_COLORS'])) echo ' product-fast-view-btn_clear';?> js-quick_see" data-id="<?=$arItem['ID']?>">Быстрый просмотр</span>
                    <?if ( !empty($arItem['OFFERS_COLORS']) ):?>
                        <ul class="product-fast-view-colors js-view-colors">
                            <?
                            $i = 0;
                            foreach ( $arItem['OFFERS_COLORS'] as $color ){?>
                                <li
                                    data-pic="<?=$color['PICTURE'][0]?>"
                                    data-price="<?=$color['PRICE']?>"
                                    data-oldprice="<?=$color['OLD_PRICE']?>"
                                    <?if($i==0)echo ' class="active"';?>
                                >
                                    <?if ( !empty($color['COLOR']['FILE']) ){?>
                                        <a href="#" style="background: url('<?=CFile::GetPath($color['COLOR']['FILE'])?>') no-repeat center center;"></a>
                                    <?}else{?>
                                        <a href="#" style="background-color: #<?=trim($color['COLOR']['UF_RGB'])?>;"></a>
                                    <? } ?>
                                </li>
                                <?
                                $i++;
                            } ?>
                        </ul>
                    <?endif;?>
                </div><?*/?>
            </div>
        <? } ?>
    </div>

<? } ?>