<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);

if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

if ($showTopPager) {
    echo $arResult['NAV_STRING'];
}
?>

<?if (!empty($arResult['ITEMS']) ):?>
    <?if ( !empty($arParams['SECTION_TITLE_NAME']) ) {?>
        <div class="row" style="margin-top: 20px;">
            <div class="col-xl-12">
                <h3><?=$arParams['SECTION_TITLE_NAME']?></h3>
            </div>
        </div>
    <? } ?>
    <div class="row">
        <?foreach ( $arResult['ITEMS'] as $arItem )
        {
//            $uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
//            $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
//            $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
        ?>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3<?if($arParams['LINE_ELEMENT_COUNT']==3) echo ' col-xl-4';?>">
                <div class="catalog-item ">
                    <div class="product js-prod_card">
                        <div class="voblers">
                            <?if ( empty($arItem['PROPERTIES']['SALE_50']['VALUE']) && empty($arItem['PROPERTIES']['SALE_40']['VALUE']) && empty($arItem['PROPERTIES']['SALE_60']['VALUE']) && empty($arItem['PROPERTIES']['SALE_70']['VALUE']) && !empty($arItem['PROPERTIES']['SALE']['VALUE']) ) {?>
                                <div class="sale"><p>SALE</p></div>
                            <? } ?>
                            <?if ( !empty($arItem['PROPERTIES']['SALE_50']['VALUE']) ) {?>
                                <div class="sale"><p>SALE - 50%</p></div>
                            <? } ?>
                            <?if ( !empty($arItem['PROPERTIES']['SALE_40']['VALUE']) ) {?>
                                <div class="sale"><p>SALE - 40%</p></div>
                            <? } ?>
                            <?if ( !empty($arItem['PROPERTIES']['SALE_60']['VALUE']) ) {?>
                                <div class="sale"><p>SALE - 60%</p></div>
                            <? } ?>
                            <?if ( !empty($arItem['PROPERTIES']['SALE_70']['VALUE']) ) {?>
                                <div class="sale"><p>SALE - 70%</p></div>
                            <? } ?>
                            <? if ( !empty($arItem['PROPERTIES']['HIT']['VALUE']) ) {?>
                                <div class="sale top"><p>Хит продаж</p></div>
                            <? } ?>
                            <? if ( !empty($arItem['PROPERTIES']['NEW']['VALUE']) ) {?>
                                <div class="sale fragment"><p>новинка</p></div>
                            <? } ?>
                            <? if ( !empty($arItem['PROPERTIES']['WOBBLERS']['VALUE']) ) {?>
                                <div class="sale<?if(empty($arItem['PROPERTIES']['WOBBLERS']['DESCRIPTION']))echo ' fragment';?>"<?if(!empty($arItem['PROPERTIES']['WOBBLERS']['DESCRIPTION']))echo ' style="background-color: #'.$arItem['PROPERTIES']['WOBBLERS']['DESCRIPTION'].';"';?>><p><?=$arItem['PROPERTIES']['WOBBLERS']['VALUE']?></p></div>
                            <? } ?>
                            <? if ($arItem['PRODUCT_AVAILABLE'] == 'PRE_ORDER') { ?>
                                <div class="sale preorder"><p>Под заказ</p></div>
                            <? } elseif ($arItem['PRODUCT_AVAILABLE'] == 'DELAY') { ?>
                                <div class="sale delay"><p><?=$arItem['PROPERTIES']['DELIVERY_DELAY']['NAME'];?></p></div>
                            <? } elseif ($arItem['PRODUCT_AVAILABLE'] == 'IN_STORE') { ?>
                                <div class="sale delay"><p>Товар на складе</p></div>
                            <? } ?>
                        </div>

                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product-link">
                            <div class="product-img-wrapper">
                                <img class="product-img js-prod_img lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src="<?= !empty($arItem['PREVIEW_PICTURE']['SRC']) ? $arItem['PREVIEW_PICTURE']['SRC'] : $arItem['DETAIL_PICTURE']['SRC'] ?>"
                                     width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>"
                                     height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>"
                                     alt="<?= $arItem['NAME'] ?>">
                                <noscript>
                                    <img class="product-img js-prod_img" src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" width="<?= $arItem['PREVIEW_PICTURE']['WIDTH'] ?>" height="<?= $arItem['PREVIEW_PICTURE']['HEIGHT'] ?>" alt="<?= $arItem['NAME'] ?>">
                                </noscript>
                            </div>
                            <span class="product-title js-name"><?=$arItem['NAME']?></span>
                            <span class="product-price js-prod_price">
                                <? switch ($arItem['PRODUCT_PRICE_TYPE']) {
                                    case 'NOT_SHOW_PRICE':
                                        ?>
                                        <span class="product-price_single">уточнить стоимость</span>
                                        <?
                                        break;

                                    case 'OLD_PRICE':
                                        ?>
                                        <?if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                                            <span class="product-price_old"><?=number_format($arItem['MIN_PRICE']['VALUE'],0,'',' ')?>&nbsp;₽</span>
                                        <?}?>
                                        <span class="product-price_current"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'],0,'',' ')?>&nbsp;₽</span>
                                        <?
                                        break;

                                    case 'PRICE':
                                        ?>
                                        <span class="product-price_single"><?=number_format($arItem['MIN_PRICE']['VALUE'],0,'',' ')?>&nbsp;₽</span>
                                        <?
                                        break;

                                    default:
                                        ?>
                                        <span class="product-price_single">предзаказ</span>
                                        <?
                                        break;
                                } ?>
                                <?/*if ( $arItem['ORDER_PRICE'] || empty($arItem['ITEM_PRICES']) ){?>
                                    <span class="product-price_single">уточнить стоимость</span>

                                <?} elseif ( $arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['CATALOG_QUANTITY'] > 0 ) {?>
                                    <span class="product-price_old"><?=number_format($arItem['MIN_PRICE']['VALUE'],0,'',' ')?>&nbsp;₽</span>
                                    <span class="product-price_current"><?=number_format($arItem['MIN_PRICE']['PRICE'],0,'',' ')?>&nbsp;₽</span>

                                <? //} elseif ( $arItem['MIN_PRICE']['PRICE'] > 0 && $arItem['CATALOG_QUANTITY'] > 0 ) { ?>
                                <? } elseif ( $arItem['MIN_PRICE']['PRICE'] > 0 ) { ?>
                                    <span class="product-price_single"><?=number_format($arItem['MIN_PRICE']['PRICE'],0,'',' ')?>&nbsp;₽</span>

                                <? } else { ?>
                                    <span class="product-price_single">предзаказ</span>
                                <? } */?>
                            </span>
                        </a>
                        <?if ( $arParams['FILTER_NAME'] != 'arrFilterFavorites' ) {?>
                            <span class="product-like js-favorite" data-id="<?=$arItem['ID']?>">
                                <span class="tile">Добавить в избранное</span>
                                <?/* <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="10" viewbox="0 0 12 10">
                                    <defs>
                                        <path id="_9k9za" d="M602.73 2368c-1.06 0-2.05.45-2.73 1.23a3.62 3.62 0 0 0-2.73-1.23c-.87-.02-1.72.3-2.34.9-.61.6-.95 1.41-.93 2.26.08.96.46 1.88 1.1 2.63 1.26 1.78 4.33 3.98 4.46 4.07.26.19.61.19.87 0 .14-.09 3.21-2.29 4.48-4.07a4.71 4.71 0 0 0 1.09-2.63 3.02 3.02 0 0 0-.93-2.26 3.25 3.25 0 0 0-2.34-.9z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-594 -2368)">
                                            <use fill="#bbb" xlink:href="#_9k9za"></use>
                                        </g>
                                    </g>
                                </svg> */?>
				<svg data-name="Добавить в избранное" xmlns="http://www.w3.org/2000/svg" width="12.002" height="10.004" viewBox="0 0 12.002 10.004"><path  data-name="9k9za" d="M8.73,0A3.608,3.608,0,0,0,6,1.23,3.62,3.62,0,0,0,3.27,0,3.26,3.26,0,0,0,.93.9,3.065,3.065,0,0,0,0,3.16,4.645,4.645,0,0,0,1.1,5.79,23.577,23.577,0,0,0,5.56,9.86a0.735,0.735,0,0,0,.87,0,23.489,23.489,0,0,0,4.48-4.07A4.71,4.71,0,0,0,12,3.16,3.02,3.02,0,0,0,11.07.9,3.25,3.25,0,0,0,8.73,0Z" transform="translate(0.001 0.001)" fill="#bbb"/></svg>
                            </span>
                        <? } else { ?>
                            <span class="product-like product-delete js-favorite" data-id="<?=$arItem['ID']?>">
                                <span class="tile">Удалить</span>
                               <?/* <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                                    <defs>
                                        <path id="_lqdxa" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-343 -19)">
                                            <use fill="#202020" xlink:href="#_lqdxa"></use>
                                        </g>
                                    </g>
                                </svg> */?>
				<svg  data-name="Удалить" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><title>wish-delete</title><path id="_lqdxa" data-name=" lqdxa" d="M12,10.59l-1.4,1.4L6,7.41,1.41,12l-1.4-1.41L4.59,6,0,1.41l1.41-1.4,4.6,4.58L10.59,0,12,1.41,7.41,6Z" fill="#202020"/></svg>
                            </span>
                            <span class="product-delete-btn d-xl-none js-favorite" data-id="<?=$arItem['ID']?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" viewbox="0 0 30 30">
                                <defs>
                                    <path id="v2toa" d="M20 335a14 14 0 1 1 28 0 14 14 0 0 1-28 0z"></path>
                                    <path id="v2tob" d="M39 338.82L37.83 340 34 336.18 30.18 340 29 338.82l3.83-3.82-3.83-3.82 1.18-1.18 3.82 3.82 3.83-3.82 1.17 1.18-3.82 3.82z"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-19 -320)">
                                        <g>
                                            <use fill="#fff" fill-opacity="0" stroke="#bbb" stroke-miterlimit="50" xlink:href="#v2toa"></use>
                                        </g>
                                        <g>
                                            <use fill="#878787" xlink:href="#v2tob"></use>
                                        </g>
                                    </g>
                                </g>
                            </svg>Удалить
                            </span>
                        <? } ?>
                        <?/*?><div class="product-fast-view">
                            <a herf="#" class="product-fast-view-btn<?if(empty($arItem['OFFERS_COLORS'])) echo ' product-fast-view-btn_clear';?> js-quick_see" data-id="<?=$arItem['ID']?>">Быстрый просмотр</a>
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
                </div>
            </div>
        <?
        }
    ?>
    </div>
<?endif;?>

<?if ( $arParams['SHOW_ERROR'] && empty($arResult['ITEMS']) ) {?>
    <p>По вашему запросу не найдено товаров</p>
<? } ?>

<?
if ($showBottomPager)
{
	?>
		<?=$arResult['NAV_STRING']?>
	<?
}
?>
