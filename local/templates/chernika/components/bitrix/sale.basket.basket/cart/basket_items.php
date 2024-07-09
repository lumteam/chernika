<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Main\Localization\Loc;
?>

<div class="js-cart_wrapper">
    <div class="cart-wrapper">
<?
if (!empty($arResult["ERROR_MESSAGE"]))
    ShowError($arResult["ERROR_MESSAGE"]);

$normalCount = count($arResult['ITEMS']['AnDelCanBuy']);
if ( $normalCount > 0 ):
    $arrModalRecept = [];
    foreach ( $arResult["GRID"]["ROWS"] as $k => & $arItem ):
        if ( $arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y" ):
            $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['PRODUCT_ID']);
            $arItem['ARTICLE'] = \PDV\Tools::getArticleProduct($arItem['PRODUCT_ID']);
    ?>
<div style="color:red"><b>Цена со скидкой действительна только при заказе очков вместе с линзами</b><br/>
Ожидайте подтверждения резерва от менеджера</div>
<br/>
        <div class="cart-item">
            <div class="cart-item-img">
                <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?}?>
                    <img class="js-prod_img_thumb lazyload"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                         data-src="<?= $arItem['PICTURE'] ?>"
                         alt="<?= $arItem['NAME'] ?>">
                    <noscript>
                        <img src="<?= $arItem['PICTURE'] ?>" alt="<?= $arItem['NAME'] ?>">
                    </noscript>
                <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {?></a><?}?>
            </div>
            <div class="cart-item-text">
                <div class="cart-item-info">
                    <p class="cart-item-info-title"><?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?}?><?=$arItem['PREVIEW_TEXT'] /*<-NAME*/?><?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {?></a><?}?></p>
                    <?if (!empty($arItem['ARTICLE']) ){?>
                        <p class="cart-item-info-articul">Артикул: <?=$arItem['ARTICLE']?></p>
                    <? } ?>
                    <?
                    $size = [];
                    $color = '';
                    $receptData = [];
                    foreach ( $arItem['PROPS'] as $prop ) {
                        if ( in_array($prop['CODE'], ['DUZHKA','MOST','LINZA','HEIGHT']))
                            $size[] = $prop['VALUE'];
                        elseif ( $prop['CODE'] == 'COLOR' )
                            $color = $prop['VALUE'];
                        elseif ( $prop['CODE'] == 'RECEPT_ID' ) {
                            $rsElem = \CIBlockElement::GetList(
                                [],
                                ['IBLOCK_ID' => 28, 'ID' => $prop['VALUE']],
                                false,
                                ['nPageSize' => 1]
                            );
                            if ( $arElemObj = $rsElem->GetNextElement() ) {
                                $arElem = $arElemObj->GetFields();
                                $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                                $receptData = $arElem;
                                $arrModalRecept[] = $receptData;
                            }
                        }
                    }
                    if ( !empty($size) ){?>
                        <p class="cart-item-info-size">Размер: <?=implode('-',$size)?></p>
                    <? } ?>
                    <?
                    foreach ( $arItem['PROPS'] as $prop ) {
                        if ( in_array($prop['CODE'], ['COLOR','RECEPT_TYPE','LINSES','LINSES_COLOR','POKRYTIE']) ){
                            if ( $prop['CODE'] == 'RECEPT_TYPE' && !empty($receptData) ) {
                                echo '<p class="cart-item-info-color">'.$prop['NAME'].': <a href="#recept'.$arElem['ID'].'" class="popup-link" style="text-decoration:underline;">'.$arElem['NAME'].'</a></p>';
                            }
                            else {
                    ?>
                        <p class="cart-item-info-color"><?=$prop['NAME']?>: <?=$prop['VALUE']?></p>
                    <?
                            }
                        }
                    }
                    ?>
                </div>
                <div class="cart-item-price">
                    <div class="cart-item-price-value">
                        <?if (!empty($arItem['DISCOUNT_PRICE_PERCENT'])) {
                    if(SITE_ID!='m1') {
                    if(SITE_ID!='m2') {
                        ?>
                        <strike><small><?=number_format($arItem['FULL_PRICE'],0,'',' ')?>&nbsp;<span>₽</span></small></strike><br>
                        <?
                    }
                    }
                        }
                        ?>
                        <div><?=number_format($arItem['PRICE'],0,'',' ')?>&nbsp;<span>₽</span></div>
                        <div class="cart-item-info-color">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_PRICE_FOR')?> <?=isset($arItem['MEASURE_RATIO']) ? $arItem['MEASURE_RATIO'] : 1?> <?=$arItem['MEASURE_TEXT']?>
                        </div>
                    </div>

                    <div class="cart-item-price-qty" data-id="<?=$arItem['ID']?>">
                        <button class="qty-minus js-basket_minus">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="2" viewbox="0 0 12 2">
                                <defs>
                                    <path id="2lima" d="M141.85 270.9v-1.4h10.42v1.4z"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-141 -269)">
                                        <use fill="#7e7e7e" xlink:href="#2lima"></use>
                                    </g>
                                </g>
                            </svg>
                        </button>
                        <input type="text" value="<?=$arItem['QUANTITY']?>" class="js-basket_count">
                        <button class="qty-plus js-basket_plus">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                                <defs>
                                    <path id="1bu7a" d="M201.87 270.9v-1.4h10.42v1.4z"></path>
                                    <path id="1bu7b" d="M206.38 264.99h1.4v10.42h-1.4z"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-201 -264)">
                                        <g>
                                            <use fill="#7e7e7e" xlink:href="#1bu7a"></use>
                                        </g>
                                        <g>
                                            <use fill="#7e7e7e" xlink:href="#1bu7b"></use>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="cart-item-price-value h3">
                        <?=number_format($arItem['SUM_VALUE'],0,'',' ')?>&nbsp;<span>₽</span>
                    </div>
                </div>
            </div><span class="cart-item-delete js-basket_remove" data-id="<?=$arItem['ID']?>">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                    <defs>
                        <path id="lqdxa" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-343 -19)">
                            <use fill="#202020" xlink:href="#lqdxa"></use>
                        </g>
                    </g>
                </svg></span>
        </div>
        <?
        endif;
    endforeach;
    ?>

    <div class="cart-total">
        <?$showTotalPrice = (float)$arResult["DISCOUNT_PRICE_ALL"] > 0;?>
        <?if ($showTotalPrice) {
if(SITE_ID!='m1') {
if(SITE_ID!='m2') {
        ?>
        <strong>Экономия: <span><?=number_format($arResult["DISCOUNT_PRICE_ALL"],0,'',' ')?>&nbsp;<span>₽</span></span></strong>
        <?
}
}
        }?>
        <h2>Итого: <span><?=number_format($arResult['allSum'],0,'',' ')?>&nbsp;<span>₽</span></span></h2>
    </div>
    <a href="/personal/order/make/" class="send-btn">Оформить заказ</a>

    <?foreach ( $arrModalRecept as $item){?>
    <div id="recept<?=$item['ID']?>" class="mfp-hide">
        <div class="city-container" style="max-width: 90%;">
            <div class="modal-header">
                <div class="h4"><?=$item['NAME']?></div>
                <button class="mfp-close">
                    <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
                </button>
            </div>
            <div class="feedbacks-modal-body">
                <?if ( !empty($item['PREVIEW_TEXT']) ):?>
                    <p>Информация о рецепте: <?=$item['PREVIEW_TEXT']?></p>
                <?endif;?>
                <?
                foreach ($item['PROPERTIES'] as $code => $prop){
                    if ( $code == 'USER_ID' || empty($prop['VALUE']) ) continue;
                ?>
                    <p><?=$prop['NAME']?>: <?=$prop['VALUE']?></p>
                <?}?>
            </div>
        </div>
    </div>
    <? } ?>
<?
else:
?>
    <div id="basket_items_list"><?=GetMessage("SALE_NO_ITEMS");?></div>
<?endif;?>
</div>
</div>