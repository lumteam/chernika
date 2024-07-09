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

<?/*
$create = date_format(date_create($arResult['DATE_CREATE']), 'd-m-Y H:i:s');
$now = new DateTime();
$now = $now->format('d-m-Y H:i:s');
$daysAgo = date_diff(new DateTime($now), new DateTime($create))->days;
*/?>

<?if ( !empty($arResult['IMAGES']) ):?>
    <div id="zoom-gallery">
        <div class="container">
            <div class="zoom-gallery">
                <div class="zoom-gallery__thumbs">
                    <? foreach ($arResult['IMAGES'] as $pic) { ?>
                        <div data-img="<?= CFile::GetPath($pic) ?>" class="zoom-gallery__item zoom-gallery__item_active">
                            <img class="lazyload"
                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="<?= CFile::GetPath($pic) ?>"
                                 alt="<?= $arResult['NAME'] ?>">
                        </div>
                    <? } ?>
                </div>
                <div class="zoom-gallery__screen">
                    <img class="lazyload"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                         data-src="<?= CFile::GetPath($arResult['IMAGES'][0]) ?>"
                         alt="<?= $arResult['NAME'] ?>">
                </div>
                <div class="zoom-gallery__close"><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/close.svg" alt=""></a></div>
            </div>
        </div>
    </div>
<?endif;?>


<section class="product-page js-prod_card" itemscope itemtype="http://schema.org/Product">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-lg-7 with-border">
                <h1 class="product-page-title d-md-none js-name" itemprop="name"><?=$arResult['NAME']?></h1>
                <?if ( !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) ){?>
                    <p class="product-page-articul d-md-none">Артикул: <span><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span></p>
                <? } ?>

                <?/*?><div class="voblers">
                    <?if ( empty($arResult['PROPERTIES']['SALE_60']['VALUE']) && empty($arResult['PROPERTIES']['SALE_70']['VALUE'])  && empty($arResult['PROPERTIES']['SALE_50']['VALUE']) && !empty($arResult['PROPERTIES']['SALE']['VALUE']) ) {?>
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
                </div><?*/?>
                <div class="js-product_page_slider">
                    <div class="voblers">
                        
        <?if ( $arResult['PROPERTIES']['LIMITED_QUANTITY']['VALUE'] == "Y" ) {?>
            <div class="sale"><p>Ограниченное предложение</p></div>
        <? } ?>

        <?
        if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {
            $perc = '33';
        } else {
            $perc = '25';
        }
        ?>
        <? if ($arResult['BRAND']['NAME'] == 'Ray Ban' && $arResult['IBLOCK_ID'] == '12'
         || $arResult['BRAND']['NAME'] == 'Silhouette' && $arResult['IBLOCK_ID'] == '12') { ?>
            <div class="sale"><p>-<?=$perc;?>% на линзы для очков</p></div>
        <? } ?>
                        <?/*?>
                        <?if ( empty($arResult['PROPERTIES']['SALE_60']['VALUE']) && empty($arResult['PROPERTIES']['SALE_70']['VALUE']) && empty($arResult['PROPERTIES']['SALE_50']['VALUE']) && empty($arResult['PROPERTIES']['SALE_40']['VALUE']) && !empty($arResult['PROPERTIES']['SALE']['VALUE']) ) {?>
                            <div class="sale"><p>SALE</p></div>
                        <? } ?>
                        <?if ( !empty($arResult['PROPERTIES']['SALE_50']['VALUE']) ) {?>
                            <div class="sale"><p>SALE</p></div>
                        <? } ?>
                        <?if ( !empty($arResult['PROPERTIES']['SALE_60']['VALUE']) ) {?>
                            <div class="sale"><p>SALE</p></div>
                        <? } ?>
                        <?if ( !empty($arResult['PROPERTIES']['SALE_70']['VALUE']) ) {?>
                            <div class="sale"><p>SALE</p></div>
                        <? } ?>
                        <?if ( !empty($arResult['PROPERTIES']['SALE_40']['VALUE']) ) {?>
                            <div class="sale"><p>SALE</p></div>
                        <? } ?>
                        <?*/?>

                        <?if ( !empty($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT']) ) {?>
                            <div class="sale"><p>
                                <?=($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] <= 50) ? '- '.$arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] : 'SALE '.$arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'];?>
                            %</p></div>
                            <?}?>
                            
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
                    <?if ( !empty($arResult['IMAGES']) ):?>
                        <div class="product-page-slider">
                            <?foreach ( $arResult['IMAGES'] as $pic){?>
                                <div class="product-page-slider-item">
                                    <img class="img-responsive js-prod_img lazyload"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         data-src="<?= CFile::GetPath($pic) ?>"
                                         alt="<?= $arResult['NAME'] ?>">
                                </div>
                            <? } ?>
                            <noscript>
                                <img src="<?= CFile::GetPath($arResult['IMAGES'][0]) ?>" alt="<?= $arResult['NAME'] ?>">
                            </noscript>
                        </div>
                        <?if ( count($arResult['IMAGES']) > 1 ){?>
                            <div class="product-page-slider-thumbs">
                                <?foreach ( $arResult['IMAGES'] as $pic){?>
                                    <div class="product-page-slider-thumbs-item initializable">
                                        <img class="js-prod_img_thumb lazyload"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             data-src="<?= CFile::GetPath($pic) ?>"
                                             alt="<?= $arResult['NAME'] ?>">
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
                            </svg>
                            <span class="tile">Добавить в избранное</span>
                        </span>
                    </div><?*/?>
                    <? /*if ( !empty($arResult['OFFERS_COLORS']) && count($arResult['OFFERS_COLORS']) > 1 ) { ?>
                        <div class="colors-cheker ">
                            <p>Доступные цвета</p>
                            <ul class="colors js-view-colors">
                                <?
                                $i = 0;
                                foreach ( $arResult['OFFERS_COLORS'] as $code => $color ){?>
                                    <li data-code="<?=$code?>" class="colors-item-radio<?if($i==0)echo ' active';?>" title="<?=$color['COLOR']['UF_NAME']?>">
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
                                    <li data-code="<?=$code?>" class="colors-img-item <?if($i==0)echo ' active';?>" title="<?=$color['COLOR']['UF_NAME']?>"
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
            <div class="col-xs-12 col-lg-5">
                <div class="title">
                    <div class="title-block">
                        <h1 class="product-page-title d-none d-lg-block"><?=$arResult['NAME']?></h1>
                        <? if (!empty($arResult['BRAND']['PREVIEW_PICTURE'])) { ?>
                            <?
                            $brandLogo = CFile::GetFileArray($arResult['BRAND']['PREVIEW_PICTURE']);
                            $brandLogoRatio = $brandLogo['WIDTH'] / 100;
                            $brandLogoWidth = round($brandLogo['WIDTH'] / $brandLogoRatio);
                            $brandLogoHeight = round($brandLogo['HEIGHT'] / $brandLogoRatio);
                            ?>
                            <div class="title-brand d-none d-xl-block" style="width:<?= $brandLogoWidth ?>px;height:<?= $brandLogoHeight ?>px">
                                <a href="<?=$arResult['BRAND']['DETAIL_PAGE_URL']?>">
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
                        <p class="product-page-articul d-none d-lg-block">
                            <?if ( !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) ){?>
                                Артикул: <span class="js-article"><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span>
                            <? } ?>
                        </p>
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
                                </svg>
                                <span class="tile">Добавить в избранное</span>
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
                        <? } */?>
                    </div>
                    <? /*if (!empty($arResult['BRAND']['PREVIEW_PICTURE'])) { ?>
                        <div class="title-brand d-none d-xl-block">
                            <a href="<?=$arResult['BRAND']['DETAIL_PAGE_URL']?>">
                                <img class="js-prod_img_thumb lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src="<?= CFile::GetPath($arResult['BRAND']['PREVIEW_PICTURE']) ?>"
                                     alt="<?= $arResult['BRAND']['NAME'] ?>"
                                     style="width:100px">
                            </a>
                        </div>
                    <? }*/ ?>
                </div>

                <div class="prices">
                    <div class="prices-block js-prod_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <link itemprop="availability" href="http://schema.org/<?=$arResult['CAN_BUY']?'In':'OutOf'?>Stock">
                        <meta itemprop="price" content="<?=$arResult['ITEM_PRICES'][0]['PRICE']?>">
                        <meta itemprop="priceCurrency" content="RUB">
                        <?
                        switch ($arResult['PRODUCT_PRICE_TYPE']) {
                            case 'NOT_SHOW_PRICE':?>
                                <div class="price">
                                    <p>уточнить стоимость</p>
                                </div>
                            <?break;

                            case 'OLD_PRICE':?>
                                <?if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                                    <?if(SITE_ID!='m1') {?>
                                    <?if(SITE_ID!='m2') {?>
                                        <div class="price">
                                            <?
                                            $priceTitle = 'Старая цена:';
                                            if ($arParams['CITY_NAME'] == 'Санкт-Петербург' ||  $arParams['CITY_NAME'] == 'Москва') {
                                                $priceTitle = 'Цена в салоне :';
                                            }
                                            ?>
                                            <p><span class="price-title"><?=$priceTitle?></span><span class="price-before"><?= number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', ' ') ?> <span>₽</span></span></p>
                                        </div>
                                    <?}?>
                                    <?}?>
                                <?}?>
                                <!--
                                <div class="price">
                                    <p><span class="price-title">Цена со скидкой:</span><span class="price-after js-prod_price_value"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span></p>
                                </div>
                                -->

    <?
        $withoutLenzes = $arResult['PROPERTIES']['DISCONT_WITHOUT_LENZES']['VALUE'];
        if ($withoutLenzes =='Y') {
            $fullPrice = number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', '');
            $priceBest =  ceil($fullPrice/2);?>
            <div class="price">
                <p><span class="price-title">Цена со скидкой: </span><span class="price-before js-prod_price_value" style='text-decoration: none;'><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span></p>
            </div>

            <div class="price">
                <p><span class="price-title">Спеццена<span class="bigAsterisk">*</span>:</span><span class="price-after"><?=number_format($priceBest, 0, '', ' ')?> <span>₽</span></span></p>
            </div>

        <?} else {?>
            <div class="price">
                <p><span class="price-title">Цена со скидкой:</span><span class="price-after js-prod_price_value"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span></p>
            </div>
        <?}
    ?>

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
                        <?} elseif ( $arResult['PROPERTIES']['OLD_PRICE']['VALUE'] > 0 && $arResult['CATALOG_QUANTITY'] > 0 ) {?>
                            <div class="price">
                                <p><span class="price-title">Цена в салоне:</span><span class="price-before"><?=number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'],0,'',' ')?> <span>₽</span></span></p>
                            </div>
                            <div class="price">
                                <p><span class="price-title">Цена со скидкой:</span><span class="price-after js-prod_price_value"><?=number_format($arResult['ITEM_PRICES'][0]['PRICE'],0,'',' ')?> <span>₽</span></span></p>
                            </div>
                        <? } elseif ( $arResult['ITEM_PRICES'][0]['PRICE'] > 0 && $arResult['CATALOG_QUANTITY'] > 0 ) { ?>
                            <div class="price">
                                <p>Цена:<span class="price-current js-prod_price_value"><?=number_format($arResult['ITEM_PRICES'][0]['PRICE'],0,'',' ')?> <span>₽</span></span></p>
                            </div>
                        <? } else { ?>
                            <div class="price">
                                <p>Предзаказ</p>
                            </div>
                        <? }*/ ?>
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
<?switch ($arResult['PRODUCT_PRICE_TYPE']) {
    case 'OLD_PRICE':
    if(SITE_ID=='m1' || SITE_ID=='m2') {?>
    <?$phoneNumber = \PDV\Tools::getDataByCity($arParams['CITY_PARAMS']['ID'])['PHONE_HEADER'][0];?>
    <p style="margin-top: 0;">Цена действительна по промокоду: <strong>ОСЕНЬ</strong> и при предварительной записи по телефону: <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr></p>
    <?}
break;
}?>


<div class="info-blocks">
    <?
    $infoFileName = 'info-blocks.php';
    if (CSite::InDir('/lenses/')) {
        $infoFileName = 'info-blocks-lenses.php';
    }
    include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/'.$infoFileName);
    ?>
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
    <!-- 						
    <?if ($arParams['CITY_NAME'] == 'Санкт-Петербург') {?>           
    <p><strong>Салоны открыты! Посещение только по записи.</strong><br/>
    Мы заботимся о вашем здоровье и безопасности, поэтому ведем прием по записи <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></p>
    <?} else {};?>
    -->

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

<?if (CSite::InDir('/eyeglass-frames/')) {?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            ".default",
            array(
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "eyeglass-frames_inc",
                "EDIT_TEMPLATE" => "",
                "COMPONENT_TEMPLATE" => ".default",
                "AREA_FILE_RECURSIVE" => "Y",
                "PRODUCT_BRAND" => $arResult['BRAND']['NAME'],
                "PRODUCT_BRAND_IBLOCK_ID" => $arResult['IBLOCK_ID']
            ),
            false
        );?>
    </div>
<?}?>




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

                <?//$propsValues = \PDV\Tools::getPropsValues($arResult);?>
                <?if( !empty($arResult['DETAIL_TEXT']) || !empty($arResult['PRODUCT_PROPERTIES']) ):?>
                    <div class="description">
                        <div class="toggle">
                            <span>Характеристики и описание</span>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewbox="0 0 13 14">
                              <defs>
                                <path id="pjuoa" d="M327 1064v-2h13v2z"></path>
                                <path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path>
                              </defs>
                              <g>
                                <g transform="translate(-327 -1056)">
                                  <g>
                                    <use fill="#797979" xlink:href="#pjuoa"></use>
                                  </g>
                                  <g>
                                    <use fill="#797979" xlink:href="#pjuob"></use>
                                  </g>
                                </g>
                              </g>
                            </svg>
                        </div>

                            <div class="description-inner">
                            <div class="description-list">
                                <div class="description-list">
                                    <? foreach ($arResult['PRODUCT_PROPERTIES'] as $propCode => $arValues) { ?>
                                        <div class="description-list__item" itemprop="description">
                                            <p class="label"><?= $arResult['PROPERTIES'][$propCode]['NAME'] ?>:</p>
                                            <p class="value"><?= implode(' / ', $arValues['VALUES']); ?></p>
                                        </div>
                                    <? } ?>

                                    <?
                                     	if ($arParams['IBLOCK_ID'] == '42') {
						                        		$lenses_char = array("LENSES_INDEX","LENSES_SURFACE_DESIGN","LENSES_MATERIAL","LENSES_DESIGN","LENSES_FEATURES");

						                        		foreach($lenses_char as $char) {
						                        			if ( !empty($arResult['PROPERTIES'][$char]['VALUE']) ){?>
																						<div class="description-list__item" itemprop="description">
																						    <p class="label"><?= $arResult['PROPERTIES'][$char]['NAME'] ?>:</p>
																						    <p class="value">
																						    	<?
																						    if ( is_array($arResult['PROPERTIES'][$char]['VALUE']) ) {
																						    	foreach ($arResult['PROPERTIES'][$char]['VALUE'] as $param) {
																						    		echo $param . '; ';
																						    	}
																						    }
																						    else if ($arResult['PROPERTIES'][$char]['USER_TYPE']=='directory'){
																										if (!CModule::IncludeModule('highloadblock'))
																										   continue;

																										$ID = 4; //highloadblock Brendshl
																										$matname = $arResult['PROPERTIES'][$char]['VALUE'];
																										//сначала выбрать информацию о ней из базы данных
																										$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
																										//затем инициализировать класс сущности
																										$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
																										$hlDataClass = $hldata['NAME'].'Table';
																										$result = $hlDataClass::getList(array(
																										     'select' => array('ID', 'UF_NAME'),
																										     'order' => array('UF_NAME' =>'ASC'),
																										     'filter' => array('UF_XML_ID' => $matname),
																										));
																										while($res = $result->fetch())
																										{
																										  echo $res['UF_NAME'];
																										}
																						    }
																						  	else {
																						  		echo $arResult['PROPERTIES'][$char]['VALUE'];
																						  	}
																						    ?></p>
																						</div>
						                        			<?}
						                        		}
						                        	}?>
                                </div>
                            </div>
                            <?=$arResult['DETAIL_TEXT']?>
                        </div>
                    </div>
                <?endif;?>
                <?if ( in_array($arParams['CITY_NAME'], ['Москва','Санкт-Петербург']) ) {?>
                    <div class="description">
                        <div class="toggle">
						<?if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
                            <span>Запись в салон и доставка</span>
						<?} else {?><span>Запись в салон и доставка</span><?}; ?>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewbox="0 0 13 14">
                              <defs>
                                <path id="pjuoa" d="M327 1064v-2h13v2z"></path>
                                <path id="pjuob" d="M332.5 1056.5h2v13h-2z"></path>
                              </defs>
                              <g>
                                <g transform="translate(-327 -1056)">
                                  <g>
                                    <use fill="#797979" xlink:href="#pjuoa"></use>
                                  </g>
                                  <g>
                                    <use fill="#797979" xlink:href="#pjuob"></use>
                                  </g>
                                </g>
                              </g>
                            </svg>
                        </div>
                        <div class="description-inner">
                            <div class="description-list">
                                <div class="description-list" style="font-size: 13px;">
								<?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>
								<strong>Запись в салон.</strong><br/>
								Скидки распространяется на все модели, которые представлены в салоне - только при предварительной записи по телефону
								<a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>" style="text-decoration: underline !important; text-transform: none; display: inline;padding: 0; line-height: normal; color: #000; font-weight: normal; font-size: 13px;"><?=$phoneNumber?></a>
								<br/>
								<br/>
								<?};?>
								<?if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
                                <strong>Запись в салон.</strong><br/>
								Скидки распространяется на все модели, которые представлены в салоне - только при предварительной записи по телефону <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>" style="text-decoration: underline !important; text-transform: none; display: inline;padding: 0; line-height: normal; color: #000; font-weight: normal; font-size: 13px;"><?=$phoneNumber?></a>
                                <br/>
                                <br/>
								<?};?>
<?if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>								
                                <strong>Курьерская доставка.</strong><br/>
								Примерьте понравившиеся модели дома или на работе.<br/>
								При покупке оправы от 6000 руб. — <strong>доставка бесплатно.</strong><br/>
                                • Заказать с доставкой можно до 5 оправ одновременно;<br/>
                                • Оплата после примерки;<br/>
                                • Если ни одна оправа не подошла — оплачивается только доставка (399 рублей);<br/>
                                • Доставляем по всем районам Санкт-Петербурга.<br/>
                                <br/>
								<strong>Выездная оптика</strong><br/>
								Примерьте дома до 30 брендовых оправ!</br>
								Примерку сопровождает оптик-стилист. <a href="/viezdnaja-optika" title="Выездная оптика" style="text-decoration: underline !important; text-transform: none; display: inline;padding: 0; line-height: normal; color: #000; font-weight: normal; font-size: 13px;">Подробнее</a>
								<br/><br/>
                                <strong>Доставка по России</strong><br/>
                                Курьерская служба СДЭК (от 400 рублей), пункты выдачи СДЭК (от 350 рублей), Почта России.<br/>
                                Возможна предоплата и оплата при получении.<br/>
                                Стоимость доставки рассчитывается индивидуально для каждого города.  Возможна предоплата и оплата при получении.
<?} else {?>
								<strong>Курьерская доставка.</strong><br/>
								Примерьте понравившиеся модели дома или на работе.<br/>
								При покупке оправы от 6000 руб. — <strong>доставка бесплатно.</strong><br/>
                                • Заказать с доставкой можно до 5 оправ одновременно;<br/>
                                • Оплата после примерки;<br/>
                                • Если ни одна оправа не подошла — оплачивается только доставка (250 рублей);<br/>
                                • Доставляем по всем районам Москвы.<br/>
                                <br/>
                                <strong>Доставка по России</strong><br/>
                                Курьерская служба СДЭК (от 400 рублей), пункты выдачи СДЭК (от 350 рублей), Почта России.<br/>
                                Возможна предоплата и оплата при получении.<br/>
                                Стоимость доставки рассчитывается индивидуально для каждого города.  Возможна предоплата и оплата при получении.
<?};?>

                                <!--
                                    При бронировании оправы скидка распространяется на все модели, которые представлены в салоне.<br/>
                                    
									Примерьте понравившиеся модели дома или на работе.<br/>
                                    При покупке оправы от 6000 руб. — <strong>доставка бесплатно</strong>.<br/>
                                    • Заказать с доставкой можно до трех оправ одновременно;<br/>
                                    • Оплата после примерки;<br/>
                                    • Если ни одна оправа не подошла — оплачивается только доставка (250 рублей);<br/>
                                    <?if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
                                    • Доставляем по всем районам Санкт-Петербурга.
                                    <?}?>
                                    <?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>
                                    • Доставляем по всем районам Москвы.<br/>
                                    <br/>
                                    <strong>Доставка по России</strong><br/>
                                    Курьерская служба СДЭК (от 400 рублей), пункты выдачи СДЭК (от 350 рублей), Почта России.<br/>
                                    Возможна предоплата и оплата при получении.<br/>
                                    Стоимость доставки рассчитывается индивидуально для каждого города.  Возможна предоплата и оплата при получении.
                                    <?}?>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <?if ( !empty($arResult['ALL_SALOON'])):?>
                    <div class="description">
                        <div class="toggle">
                            <span>Наша сеть салонов</span>
                            <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="12" viewBox="0 0 15 12"><defs><path id="tf19a" d="M1551 689v-2h13v2z"/><path id="tf19b" d="M1560 693l4-5-4-5"/></defs><g><g transform="translate(-1551 -682)"><g><use fill="#797979" xlink:href="#tf19a"/></g><g><use fill="#fff" fill-opacity="0" stroke="#797979" stroke-miterlimit="50" stroke-width="2" xlink:href="#tf19b"/></g></g></g></svg></span>
                        </div>
                        <div class="description-inner">
                            <?foreach ( $arResult['ALL_SALOON'] as $item ){?>
                                <div class="saloon">
                                    <p><strong><?=$item['PROPERTY_CITY_VALUE']?></strong>, <?=$item['PREVIEW_TEXT']?></p>
                                    <?if ( !empty($item['PROPERTY_MAP_VALUE']) ){?>
                                        <a href="#" class="on-map js-openmap" data-coord="<?=$item['PROPERTY_MAP_VALUE']?>" data-name="<?=$item['NAME']?>">
                                            <div class="on-map-img">
                                                <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                              <g>
                                                  <g>
                                                      <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                                  </g>
                                              </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                            </svg>
                                            </div>Показать на&nbsp;карте
                                        </a>
                                    <?}?>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
</section>

<?if ( !empty($arResult['OFFERS_COLORS']) ):?>
    <script>var offerParams = "<?=CUtil::PhpToJSObject($arResult['OFFERS_COLORS'], false, true); ?>";</script>
<?endif;?>
<? if (!empty($arResult['IMAGES']) && count($arResult['IMAGES']) > 1) { ?>
    <script>
        $(".product-page-slider").slick({
            arrows: !1,
            dots: !0,
            mobileFirst: !0,
            asNavFor: ".product-page-slider-thumbs",
            responsive: [{
                breakpoint: 1023,
                settings: {
                    dots: !1
                }
            }]
        });
        $(".product-page-slider-thumbs").slick({
            arrows: !1,
            dots: !1,
            mobileFirst: !0,
            slidesToShow: 9,
            slidesToScroll: 1,
            focusOnSelect: !0,
            asNavFor: ".product-page-slider"
        });
    </script>
<? } ?>
