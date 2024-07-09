<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
$this->setFrameMode(true);

$arResult['CAN_BUY'] = $arResult['CATALOG_QUANTITY'] > 0 && $arResult['ITEM_PRICES'][0]['PRICE'] > 0;
?>

<div class="fast-view-left">
    <div class="voblers">
        <?if ( empty($arResult['PROPERTIES']['SALE_60']['VALUE']) && empty($arResult['PROPERTIES']['SALE_70']['VALUE']) && empty($arResult['PROPERTIES']['SALE_50']['VALUE']) && empty($arResult['PROPERTIES']['SALE_40']['VALUE']) && !empty($arResult['PROPERTIES']['SALE']['VALUE']) ) {?>
            <div class="sale"><p>SALE</p></div>
        <? } ?>
        <?if ( !empty($arResult['PROPERTIES']['SALE_50']['VALUE']) ) {?>
            <div class="sale"><p>SALE - 50%</p></div>
        <? } ?>
        <?if ( !empty($arResult['PROPERTIES']['SALE_60']['VALUE']) ) {?>
            <div class="sale"><p>SALE - 60%</p></div>
        <? } ?>
        <?if ( !empty($arResult['PROPERTIES']['SALE_70']['VALUE']) ) {?>
            <div class="sale"><p>SALE - 70%</p></div>
        <? } ?>
		<?if ( !empty($arResult['PROPERTIES']['SALE_40']['VALUE']) ) {?>
            <div class="sale"><p>SALE - 40%</p></div>
        <? } ?>
        <? if ( !empty($arResult['PROPERTIES']['HIT']['VALUE']) ) {?>
            <div class="sale top"><p>Хит продаж</p></div>
        <? } ?>
        <? if ( !empty($arResult['PROPERTIES']['NEW']['VALUE']) ) {?>
            <div class="sale fragment"><p>новинка</p></div>
        <? } ?>
        <? if ( !empty($arResult['PROPERTIES']['WOBBLERS']['VALUE']) ) {?>
            <div class="sale<?if(empty($arResult['PROPERTIES']['WOBBLERS']['DESCRIPTION']))echo ' fragment';?>"<?if(!empty($arResult['PROPERTIES']['WOBBLERS']['DESCRIPTION']))echo ' style="background-color: #'.$arResult['PROPERTIES']['WOBBLERS']['DESCRIPTION'].';"';?>><p><?=$arResult['PROPERTIES']['WOBBLERS']['VALUE']?></p></div>
        <? } ?>
        <? if ($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER') { ?>
            <div class="sale preorder"><p>Под заказ</p></div>
        <? } ?>
    </div>

    <div class="js-product_page_slider">
        <?if ( !empty($arResult['IMAGES']) ):?>
            <div class="product-page-slider-fast">
                <?foreach ( $arResult['IMAGES'] as $pic){?>
                    <div class="product-page-slider-item">
                        <img class="img-responsive js-prod_img lazyload"
                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                             data-src="<?= CFile::GetPath($pic) ?>"
                             alt="<?=$arResult['NAME']?>">
                     </div>
                <? } ?>
            </div>
            <?if ( count($arResult['IMAGES']) > 1 ){?>
                <div class="product-page-slider-thumbs-fast">
                    <?foreach ( $arResult['IMAGES'] as $pic){?>
                        <div class="product-page-slider-thumbs-item">
                            <img class="js-prod_img_thumb lazyload"
                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="<?= CFile::GetPath($pic) ?>"
                                 alt="<?=$arResult['NAME']?>">
                        </div>
                    <? } ?>
                </div>
            <? } ?>
        <?else:?>
            <div class="product-page-slider-fast"><div style="background-image: url('<?=SITE_TEMPLATE_PATH?>/img/no_photo.png')" class="product-page-slider-item"></div></div>
        <?endif;?>
    </div>
    <div class="subrow">
        <?/*?><div class="add-to-favorite d-lg-none">
            <span class="js-favorite" data-id="<?=$arResult['ID']?>">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21" height="19" viewbox="0 0 21 19">
                    <defs>
                        <path id="kw75a" d="M519.82 23c-1.67 0-3.25.45-4.32 1.73-1.07-1.28-2.65-1.72-4.32-1.73a5.05 5.05 0 0 0-5.18 5.18 7.88 7.88 0 0 0 1.73 4.32c2 2.92 6.87 6.53 7.08 6.68.4.3.96.3 1.37 0 .22-.15 5.09-3.76 7.1-6.68.99-1.23 1.59-2.74 1.72-4.32a5.05 5.05 0 0 0-5.18-5.18z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-505 -22)">
                            <use fill="#fff" fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="2" xlink:href="#kw75a"></use>
                        </g>
                    </g>
                </svg><span class="tile">Добавить в избранное</span>
            </span>
        </div><?*/?>
        <? /*if ( !empty($arResult['OFFERS_COLORS']) ) { ?>
            <div class="colors-cheker ">
                <p>Доступные цвета</p>
                <ul class="colors js-view-colors">
                    <?
                    $i = 0;
                    foreach ( $arResult['OFFERS_COLORS'] as $code => $color ){?>
                        <li
                            data-code="<?=$code?>"
                            class="colors-item-radio <?if($i==0)echo ' active';?>"
                            title="<?=$color['COLOR']['UF_NAME']?>"
                        >
                            <?if ( !empty($color['COLOR']['FILE']) ){?>
                                <span style="background: url('<?=CFile::GetPath($color['COLOR']['FILE'])?>') no-repeat center center;"></span>
                            <?}else{?>
                                <span style="background-color: #<?=trim($color['COLOR']['UF_RGB'])?>;"></span>
                            <? } ?>
                        </li>
                        <?
                        $i++;
                    } ?>
                </ul>
                <ul class="colors-img js-view-colors">
                    <?
                    $i = 0;
                    foreach ( $arResult['OFFERS_COLORS'] as $code => $color ){
                        if ( empty($color['PICTURE']) ) continue;
                        ?>
                        <li
                            data-code="<?=$code?>"
                            class="colors-img-item <?if($i==0)echo ' active';?>"
                            title="<?=$color['COLOR']['UF_NAME']?>"
                        >
                            <span style="background-image: url(<?=$color['PICTURE'][0]?>)" class="black"></span>
                        </li>
                        <?
                        $i++;
                    } ?>
                </ul>
            </div>
        <? }*/ ?>
    </div>
</div>
<div class="fast-view-right">
    <div class="title">
        <div class="title-block">
            <h2 class="product-page-title d-none d-lg-block js-name"><?=$arResult['NAME']?></h2>
            <? if (!empty($arResult['BRAND']['PREVIEW_PICTURE'])) { ?>
                <?
                $brandLogo = CFile::GetFileArray($arResult['BRAND']['PREVIEW_PICTURE']);
                $brandLogoRatio = $brandLogo['WIDTH'] / 100;
                $brandLogoWidth = round($brandLogo['WIDTH'] / $brandLogoRatio);
                $brandLogoHeight = round($brandLogo['HEIGHT'] / $brandLogoRatio);
                ?>
                <div class="title-brand d-none d-xl-block"
                     style="width:<?= $brandLogoWidth ?>px;height:<?= $brandLogoHeight ?>px">
                    <a href="<?= $arResult['BRAND']['DETAIL_PAGE_URL'] ?>">
                        <img class="js-prod_img_thumb brand-logo lazyload"
                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                             data-src="<?= $brandLogo['SRC'] ?>"
                             alt="<?= $arResult['BRAND']['NAME'] ?>"
                             width="<?= $brandLogoWidth ?>"
                             height="<?= $brandLogoHeight ?>">
                    </a>
                </div>
            <? } ?>
        </div>
        <div class="product-page-status flb fl-jc_sb">
            <?if ( !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) ){?>
                <p class="product-page-articul d-none d-lg-block">Артикул: <span class="js-article"><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span></p>
            <? } ?>

            <?/*?><div class="add-to-favorite d-none d-lg-block">
                <span class="js-favorite" data-id="<?=$arResult['ID']?>">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21" height="19" viewbox="0 0 21 19">
                    <defs>
                        <path id="kw75a" d="M519.82 23c-1.67 0-3.25.45-4.32 1.73-1.07-1.28-2.65-1.72-4.32-1.73a5.05 5.05 0 0 0-5.18 5.18 7.88 7.88 0 0 0 1.73 4.32c2 2.92 6.87 6.53 7.08 6.68.4.3.96.3 1.37 0 .22-.15 5.09-3.76 7.1-6.68.99-1.23 1.59-2.74 1.72-4.32a5.05 5.05 0 0 0-5.18-5.18z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-505 -22)">
                            <use fill="#fff" fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="2" xlink:href="#kw75a"></use>
                        </g>
                    </g>
                    </svg><span class="tile">Добавить в избранное</span>
                </span>
            </div><?*/?>
            <? if ($arResult['PRODUCT_AVAILABLE'] == 'IN_STOCK') { ?>
                <p class="nalichie js-prod_nalichie">Есть в наличии</p>
            <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER') { ?>
                <p class="nalichie nalichie_preorder js-prod_nalichie">Под заказ</p>
            <? } else { ?>
                <p class="nalichie nalichie_no js-prod_nalichie">Нет в наличии</p>
            <? } ?>
            <?/*if ( $arResult['CAN_BUY'] ){?>
                <p class="nalichie js-prod_nalichie">Есть в наличии</p>
            <? } else { ?>
                <p class="nalichie nalichie_no js-prod_nalichie">Нет в наличии</p>
            <? }*/?>
        </div>
    </div>
    <div class="prices">
        <div class="prices-block js-prod_price">
            <?
            switch ($arResult['PRODUCT_PRICE_TYPE']) {
                case 'NOT_SHOW_PRICE':?>
                    <div class="price">
                        <p>уточнить стоимость</p>
                    </div>
                <?break;

                case 'OLD_PRICE':?>
                    <?if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                    <div class="price">
                        <?
                        $priceTitle = 'Старая цена:';
                        if ($arParams['CITY_NAME'] == 'Санкт-Петербург' ||  $arParams['CITY_NAME'] == 'Москва') {
                            $priceTitle = 'Цена в салоне:';
                        }
                        ?>
                        <p><span class="price-title"><?=$priceTitle?></span><span class="price-before"><?= number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', ' ') ?> <span>₽</span></span></p>
                    </div>
                    <?}?>
                    <div class="price">
                        <p><span class="price-title">Цена со скидкой:</span><span class="price-after js-prod_price_value"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span></p>
                    </div>
                <?break;

                case 'PRICE':?>
                    <div class="price">
                        <p>Цена:&nbsp;&nbsp;<span class="price-current js-prod_price_value"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span></p>
                    </div>
                <?break;

                default:?>
                    <div class="price">
                        <p>Предзаказ</p>
                    </div>
                <?break;
            }
            ?>
            <?/*if ( $arResult['ORDER_PRICE'] ){?>
                <div class="price">
                    <p>уточнить стоимость</p>
                </div>
            <?}elseif ( $arResult['PROPERTIES']['OLD_PRICE']['VALUE'] > 0 ) {?>
                <div class="price">
                    <p><span class="price-title">Цена в салоне:</span><span class="price-before"><?=number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'],0,'',' ')?> <span>₽</span></span></p>
                </div>
                <div class="price">
                    <p><span class="price-title">Цена со скидкой:</span><span class="price-after js-prod_price_value"><?=number_format($arResult['ITEM_PRICES'][0]['PRICE'],0,'',' ')?> <span>₽</span></span></p>
                </div>
            <? } elseif ( $arResult['ITEM_PRICES'][0]['PRICE'] > 0 ) { ?>
                <div class="price">
                    <p>Цена:<span class="price-current js-prod_price_value"><?=number_format($arResult['ITEM_PRICES'][0]['PRICE'],0,'',' ')?><span>₽</span></span></p>
                </div>
            <? } else { ?>
                <div class="price">
                    <p>Предзаказ</p>
                </div>
            <? } */?>
        </div>

        <div class="addons-block">
            <?if ( !in_array($arParams['CITY_NAME'], ['Москва','Санкт-Петербург']) > 0):?>
                <div class="cart-item-price-qty cart-item-price-qty_cart js-count_wrap" data-count="<?=$arResult['CATALOG_QUANTITY']?>"<?if(!$arResult['CAN_BUY'])echo ' style="display:none"'?>>
                    <button class="qty-minus">
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
                    <input type="text" name="count" value="1">
                    <button class="qty-plus">
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
            <?endif;?>

            <div class="js-prod_buy_wrap<?= (in_array($arParams['CITY_NAME'], ['Москва', 'Санкт-Петербург'])) ? ' order' : '' ?><?= $arResult['PRODUCT_PRICE_TYPE'] == 'NOT_SHOW_PRICE' ? ' orderprice' : '' //$arResult['ORDER_PRICE'] ? ' orderprice' : '' ?>">
                <?
                switch ($arResult['PRODUCT_PRICE_TYPE']) {
                    case 'NOT_SHOW_PRICE':?>
                        <div class="buy-btn js-prod_orderprice" data-id="<?=$arResult['ELEMENT_ID']?>">
                            <span>Уточнить стоимость</span>
                        </div>
                    <?break;

                    case 'OLD_PRICE':
                    case 'PRICE':
                        if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                            <?/*?><div class="buy-btn buy-btn_short js-buy" data-id="<?=$arResult['ELEMENT_ID']?>"><?*/?>
                            <div class="buy-btn js-buy" data-id="<?=$arResult['ELEMENT_ID']?>">
                                <span>В корзину</span>
                            </div>
                        <?} else {?>
                            <div class="buy-btn js-prod_preorder" data-id="<?=$arResult['ELEMENT_ID']?>">
                                <span>Заказать</span>
                            </div>
                        <?}?>
                    <?break;

                    default:?>
                        <div class="buy-btn js-prod_preorder" data-id="<?=$arResult['ELEMENT_ID']?>">
                            <span>Заказать</span>
                        </div>
                    <?break;
                }
                ?>
                <?/*if ( $arResult['ORDER_PRICE'] ){?>
                    <div class="buy-btn js-prod_orderprice" data-id="<?=$arResult['ELEMENT_ID']?>">
                        <span>Уточнить стоимость</span>
                    </div>
                <?}elseif ( $arResult['CAN_BUY'] ){?>
                    <?if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
                        <div class="buy-btn js-prod_order_spb" data-id="<?=$arResult['ELEMENT_ID']?>">
                            <span>Купить со скидкой</span>
                        </div>
                    <?} elseif ( $arParams['CITY_NAME'] == 'Москва' ){?>
                        <div class="buy-btn js-prod_order" data-id="<?=$arResult['ELEMENT_ID']?>">
                            <span>Купить со скидкой</span>
                        </div>
                    <?} else {?>
                        <div class="buy-btn buy-btn_short js-buy" data-id="<?=$arResult['ELEMENT_ID']?>">
                            <span>Купить</span>
                        </div>
                    <? } ?>
                <? } else { ?>
                    <div class="buy-btn js-prod_preorder" data-id="<?=$arResult['ELEMENT_ID']?>">
                        <span>Оформить предзаказ</span>
                    </div>
                <? } */?>
            </div>
        </div>
    </div>

    <?if ( !empty($arResult['SALOON']) ):?>
        <div class="invitements">
            <?/*if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                <?
                $itemType = 'Данную оправу';
                if ($arParams['IBLOCK_ID'] == IBLOCK_ID__CATALOG_2) {
                    $itemType = 'Данные очки';
                }
                ?>
                <h3><?=$itemType?> можно примерить и&nbsp;купить<sup>*</sup> в&nbsp;наших салонах оптики, в&nbsp;<?=$arParams['CITY_PARAMS']['NAME_DECLENSION']?>:</h3>
            <?} else {*/?>
			
<?$phoneNumber = \PDV\Tools::getDataByCity($arParams['CITY_PARAMS']['ID'])['PHONE_HEADER'][0];?> 
<?if ($arParams['CITY_NAME'] == 'Санкт-Петербург') {?>            
<p><strong>Салоны открыты! Посещение только по записи.</strong><br/>
Мы заботимся о вашем здоровье и безопасности, поэтому ведем прием по записи <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></p>
<?} else {};?>
                <h3>Адреса салонов оптики в <?=$arParams['CITY_PARAMS']['NAME_DECLENSION']?>:</h3>
            <?//}?>
            <div class="invitements-block">
                <?foreach ( $arResult['SALOON'] as $item ){?>
                    <div class="invitement">
                        <?=$item['PREVIEW_TEXT']?>
                        <?if ( !empty($item['PROPERTY_MAP_VALUE']) ){?>
                            <?/*?><span class="on-map js-openmap" data-coord="<?=$item['PROPERTY_MAP_VALUE']?>" data-name="<?=$item['NAME']?>"><?*/?>
                            <p>
                                <a href="/contacts/#salon-map">
                                    <span class="on-map-img">
                                        <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>Показать на&nbsp;карте
                                </a>
                            </p>
                        <?}?>
                    </div>
                <? } ?>
            </div>
            <?/*if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {
                $phoneNumber = \PDV\Tools::getDataByCity($arParams['CITY_PARAMS']['ID'])['PHONE_HEADER'][0];?>
                <p><small><sup>*</sup>&nbsp;&mdash; позвоните по&nbsp;телефону: <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a> и&nbsp;мы&nbsp;отложим данную оправу для вас. Предварительный звонок обязателен.</small></p>
            <?}*/?>
        </div>
    <?endif;?>

    <div class="info-blocks">
        <?
        $infoFileName = 'info-blocks.php';
        if (CSite::InDir('/lenses/')) {
            $infoFileName = 'info-blocks-lenses.php';
        }
        include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/'.$infoFileName);
        ?>
    </div>

    <div class="sizes-table js-sizes_table">
        <?if ( !empty($arResult['SIZES']) ):?>
            <div class="table">
                <div class="table-row table-header">
                    <div class="table-cell"></div>
                    <div class="table-cell">
                        <p>Длина дужки</p>
                    </div>
                    <div class="table-cell">
                        <p>Ширина моста</p>
                    </div>
                    <div class="table-cell">
                        <p>Ширина линзы</p>
                    </div>
                    <div class="table-cell">
                        <p>Высота</p>
                    </div>
                    <div class="table-cell"></div>
                </div>
                <?
                $firstCheck = false;
                foreach ( $arResult['SIZES'] as $id => $size ) {
                    $checked = '';
                    if ( !$firstCheck && $size['UF_AVAIL'] ) {
                        $firstCheck = true;
                        $checked = ' checked';
                    }
                    ?>
                    <div class="table-row<?=($size['UF_AVAIL'])?'':' disabled'?>">
                        <div class="table-cell">
                            <label class="checkbox">
                                <input type="checkbox" name="type" value="<?=$id?>"<?=$checked?>>
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div class="table-cell">
                            <p><?=$size['UF_DUZHKA']?></p>
                        </div>
                        <div class="table-cell">
                            <p><?=$size['UF_MOST']?></p>
                        </div>
                        <div class="table-cell">
                            <p><?=$size['UF_LINZA']?></p>
                        </div>
                        <div class="table-cell">
                            <p><?=$size['UF_HEIGHT']?></p>
                        </div>
                        <div class="table-cell">
                            <p><?=$size['UF_TOTAL']?></p>
                        </div>
                    </div>
                <? } ?>
            </div>
        <?endif;?>
    </div>
</div>

<? /*if ( !empty($arResult['OFFERS_COLORS']) ) {?>
    <script type="text/javascript">var offerParams = "<?=CUtil::PhpToJSObject($arResult['OFFERS_COLORS'], false, true); ?>";</script>
<? }*/ ?>
