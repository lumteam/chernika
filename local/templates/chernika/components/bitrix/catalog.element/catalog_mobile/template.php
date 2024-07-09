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
<?$phoneNumber = \PDV\Tools::getDataByCity($arParams['CITY_PARAMS']['ID'])['PHONE_HEADER'][0];?>
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
                    <? foreach ($arResult['IMAGES'] as $k=>$pic) { ?>
                        <div data-img="<?= CFile::GetPath($pic) ?>" class="zoom-gallery__item<?if($k==0):?> zoom-gallery__item_active<?endif;?>">
                            <img  class="lazyload"
                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="<?= CFile::GetPath($pic) ?>"
                                 alt="<?= $arResult['NAME'] ?>">
                        </div>
                    <? } ?>
                </div>
                <div class="zoom-gallery__screen">
                    <img  class="lazyload"
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
        <div class="fl-row grid">
            <div class="col-xs-12 col-lg-5 grid-title">
                <div class="title-block">
                    <h1 class="product-page-title d-lg-block" itemprop="name">
                        <?//=$arResult['NAME']?>
                        <?if($arResult['BRAND']['NAME'] == "Cartier") {
                            echo str_replace("Оправа CT","Оправа Cartier CT",$arResult['NAME']);
                        } else {echo $arResult['NAME'];}?>
                    </h1>
                    <? if (!empty($arResult['BRAND']['PREVIEW_PICTURE']) && $arResult['IBLOCK_ID']!=42) { ?>
                        <?
                        $brandLogo = CFile::GetFileArray($arResult['BRAND']['PREVIEW_PICTURE']);
                        $brandLogoRatio = $brandLogo['WIDTH'] / 100;
                        $brandLogoWidth = round($brandLogo['WIDTH'] / $brandLogoRatio);
                        $brandLogoHeight = round($brandLogo['HEIGHT'] / $brandLogoRatio);
                        ?>
                        <div class="title-brand d-none d-xl-block" style="width:<?= $brandLogoWidth ?>px;height:<?= $brandLogoHeight ?>px" itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                            <meta itemprop="name" content="<?= $arResult['BRAND']['NAME'] ?>" />
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
                    <?if($arResult['IBLOCK_ID']==42){?>
                        <?if($arResult['PROPERTIES']['BRAND']['VALUE']=='Essilor'){?>
                        <div class="title-brand d-none d-xl-block" style="width:80px;height:56px" itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                            <meta itemprop="name" content="Essilor" />
                            <a href="/lenses/filter/brand-is-essilor/apply/">
                                <img class="js-prod_img_thumb brand-logo lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src="/upload/lenses_files/Essilor_logo.png"
                                     alt="Essilor"
                                     width="80px"
                                     height="56px">
                            </a>
                        </div>
                        <?}?>
                    <?}?>
                </div>
            </div>
            <div class="col-xs-12 col-lg-7 with-border grid-photo">
                <?/*<h1 class="product-page-title d-md-none js-name" itemprop="name">
                <?//=$arResult['NAME']?>
                  <?if($arResult['BRAND']['NAME'] == "Cartier") {
                    echo str_replace("Оправа CT","Оправа Cartier CT",$arResult['NAME']);
                } else {echo $arResult['NAME'];}?>
                </h1> */?>
                <?if ( !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) ){?>
                    <p class="product-page-articul d-md-none hidden-md">Артикул: <span ><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span></p>
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
						<?if($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER'):?>
                            <div class="sale preorder"><p>Под заказ</p></div>
                        <? elseif ($arResult['PRODUCT_AVAILABLE'] == 'DELAY'): ?>
                            <div class="sale delay"><p><?=$arResult['PROPERTIES']['DELIVERY_DELAY']['NAME'];?></p></div>
						<?else:?>
        <?if ( $arResult['PROPERTIES']['LIMITED_QUANTITY']['VALUE'] == "Y" ) {?>
            <div class="sale"><p>Ограниченное предложение</p></div>
        <? } ?>

        <?
        if ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {
            $perc = '50';
        } else {
            $perc = '30';
        }
        ?>
        <? if ($arResult['BRAND']['NAME'] == 'Ray Ban' && $arResult['IBLOCK_ID'] == '12'
         || $arResult['BRAND']['NAME'] == 'Silhouette' && $arResult['IBLOCK_ID'] == '12'
         || $arResult['BRAND']['NAME'] == 'William Morris' && $arResult['IBLOCK_ID'] == '12') { ?>
            <div class="sale"><p>До - <?=$perc;?>% на линзы для очков</p></div>
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
                        <?
                            $perc = 0;
							foreach($arResult['OFFERS'] as $arOffer)
                            {
								foreach($arOffer['ITEM_PRICES'] as $arPrice)
								{
									if($arOffer["CAN_BUY"] && intval($arPrice["PERCENT"]) > 0)
									{
										$perc = $arPrice["PERCENT"];
										if($perc > 0) break;
									}
								}
								if($perc > 0) break;
                            }
							if($perc > 0) $arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] = $perc;
                        ?>
                        <?if ( !empty($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT']) ) {?>
                            <div class="sale"><p><noindex>
                                <?=($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] <= 50) ? '- '.$arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] : 'SALE '.$arResult['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'];?>
                            % <?=\COption::GetOptionString( "askaron.settings", "UF_LABEL_AFTER_PERCENT");?></noindex></p></div>
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
						<?endif;?>
                    </div>
                    <?if ( !empty($arResult['IMAGES']) ):?>
                        <div class="product-page-slider">
                            <?foreach ( $arResult['IMAGES'] as $pic){?>

                                <div class="product-page-slider-item">
                                    <img itemprop="image" class="img-responsive js-prod_img lazyload"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         data-src="<?= CFile::GetPath($pic) ?>"
                                         alt="<?= $arResult['NAME'] ?>">
                                </div>
                            <? } ?>
<?/*
                            <noscript>
                                <img src="<?= CFile::GetPath($arResult['IMAGES'][0]) ?>" alt="<?= $arResult['NAME'] ?>">
                            </noscript>
*/?>
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
<?if ( !empty($arResult['IMAGES']) ):?>
<?foreach ( $arResult['IMAGES'] as $pic){?>
<link itemprop="image" href="<?= CFile::GetPath($pic) ?>" />
  <? } ?>
 <?endif;?>
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
<!-- -->

<!--- -->
 		<div class="col-xs-12 col-lg-5 coll-3 grid-info">
                <div class="title">
                    <div class="product-page-status flb fl-jc_sb">
                        <p class="product-page-articul d-none d-lg-block">
                            <?if ( !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) ){?>
                                Артикул: <span class="js-article" itemprop="sku"><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span>
				<meta itemprop="mpn" content="<?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>" />
                            <? } ?>
                        </p>
                    </div>
                </div>
                <? if ($arResult['MODEL_COLORS']): ?>
                    <? $colors_html = ''; ?>
                    <style>
                        .colors {
                            display: flex;
                            flex-wrap: wrap;
                            margin: 0 0 50px;
                        }
                        .colors-item {
                            display: block;
                            width: 22px;
                            height: 22px;
                            border-radius: 12px;
                            border: 1px solid #fff;
                            box-shadow: 0 0 0 1px #D9D9D9;
                            margin: 5px;
                        }
                        .colors-item.selected {
                            box-shadow: 0 0 0 2px #FF8343;
                        }
                    <? foreach ($arResult['MODEL_COLORS'] as $color_item_id => $color_item): ?>
                        <? $color_css_class = join('-', array_keys($color_item['COLORS'])); ?>
                        <? $is_selected = (int)$color_item_id === (int)$arParams['ELEMENT_ID']; ?>
                        <? $current_class = $is_selected ? 'selected' : ''; ?>
                        <? $color_href = $is_selected ? '' : "href=\"{$color_item['DETAIL_PAGE_URL']}\""; ?>
                        <? $colors_html .= "<a class=\"colors-item {$color_css_class} {$current_class}\"
                                {$color_href}
                                title=\"{$color_item['COLORS_STR']}\"></a>"; ?>
                        .<?=$color_css_class?> {
                            <?
                            switch (count($color_item['COLORS']))
                            {
                                case 1:
                                    $first_color = reset($color_item['COLORS']);
                                    if (intval($first_color['UF_FILE'])): ?>
                                        background: url('<?=CFile::GetPath($first_color['UF_FILE'])?>') no-repeat center center;
                                    <? else: ?>
                                        background-color: #<?=$first_color['UF_RGB']?>;
                                    <? endif;
                                    break;
                                case 2:
                                    $first_color = reset($color_item['COLORS']);
                                    $second_color = end($color_item['COLORS']);
                                    if (intval($first_color['UF_FILE']) && intval($second_color['UF_FILE'])): ?>
                                        background: url('<?=CFile::GetPath($first_color['UF_FILE'])?>') no-repeat 0 50%,
                                                    url('<?=CFile::GetPath($second_color['UF_FILE'])?>') no-repeat -50% 50%;
                                    <? elseif(intval($first_color['UF_FILE']) || intval($second_color['UF_FILE'])): ?>
                                        <? $bg_image = intval($first_color['UF_FILE'])
                                            ? CFile::GetPath($first_color['UF_FILE'])
                                            : CFile::GetPath($second_color['UF_FILE']); ?>
                                        <? $bg_color = intval($first_color['UF_FILE'])
                                            ? $first_color['UF_RGB']
                                            : $second_color['UF_RGB']; ?>
                                        background: #<?=$bg_color?> url('<?=$bg_image?>') no-repeat -50% 50%;
                                    <? else: ?>
                                        background: linear-gradient(to right, #<?=$first_color['UF_RGB']?>, #<?=$first_color['UF_RGB']?>, #<?=$second_color['UF_RGB']?>, #<?=$second_color['UF_RGB']?>);
                                    <? endif;
                                    break;
                                default:
                                    $colors_rgb = [];
                                    foreach ($color_item['COLORS'] as $color)
                                        $colors_rgb[] = '#'.$color['UF_RGB'];
                                    ?>
                                    background: conic-gradient(<?=join(',', $colors_rgb)?>);
                            <? } ?>
                        }
                    <? endforeach; ?>
                    </style>
                    <div class="colors"><?=$colors_html?></div>
                <? endif; ?>
                <div class="prices">
                    <div class="prices-block js-prod_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <link itemprop="availability" href="http://schema.org/<?=$arResult['CAN_BUY']?'In':'OutOf'?>Stock">
                        <meta itemprop="price" content="<?=$arResult['ITEM_PRICES'][0]['PRICE']?>">
                        <meta itemprop="priceCurrency" content="RUB">
			<meta itemprop="priceValidUntil" content="2023-11-20" />
                        
                               

    <?
        $withoutLenzes = $arResult['PROPERTIES']['DISCONT_WITHOUT_LENZES']['VALUE'];
        if ($withoutLenzes =='Y') {
            $fullPrice = number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', '');
            $priceBest =  ceil($fullPrice/2);?>
            <div class="price">
                <p><span class="price-title b"><?if($arResult['IBLOCK_ID']==42){?>Со скидкой:<?} else {?>Цена со скидкой:<?}?> </span><span class="price-before js-prod_price_value" style='text-decoration: none;'><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span><?if($arResult['IBLOCK_ID']==42){?> за одну линзу<?}?>

                <?if($arResult['IBLOCK_ID']==42){?><br><span style="font-size: 16px">по промокоду <strong>0803</strong></span><?}?>
            </p>
            </div>

            <div class="price">
                <p><span class="price-title">Спеццена<span class="bigAsterisk">*</span>:</span><span class="price-after"><?=number_format($priceBest, 0, '', ' ')?> <span>₽</span></span></p>
            </div>

        <?} else {?>
            <div class="price">
                <p>
			        <?if ($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER'):?>
                        <span class="price-title c" style="color:#9e9e9e!important;"><?if($arResult['IBLOCK_ID']==42){?>Со скидкой:<?} else {?>Цена со скидкой:<?}?></span><span class="price-after js-prod_price_value" style="margin-right: 15px; color:#9e9e9e!important;"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span><?if($arResult['IBLOCK_ID']==42){?> за одну линзу<?}?>
						<?if($arResult['IBLOCK_ID']==42){?><br><span style="font-size: 16px">по промокоду <strong>0803</strong></span><?}?>
        			<?else:?>
                        <span class="price-title c"><?if($arResult['IBLOCK_ID']==42){?>Со скидкой:<?} else {?>Цена со скидкой:<?}?></span><span class="price-after js-prod_price_value" style="margin-right: 15px;"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?> <span>₽</span></span><?if($arResult['IBLOCK_ID']==42){?> за одну линзу<?}?>
						<?if($arResult['IBLOCK_ID']==42){?><br><span style="font-size: 16px">по промокоду <strong>0803</strong></span><?}?>
		    		<?endif;?>
                </p>
            </div>
        <?}
    ?>
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
                                        <div class="price">
                                            <?
                                            $priceTitle = 'Старая цена:';
                                            if ($arParams['CITY_NAME'] == 'Санкт-Петербург'
                                                ||  $arParams['CITY_NAME'] == 'Москва'
                                                ||  $arParams['CITY_NAME'] == 'Уфа') {
                                                $priceTitle = 'Цена в салоне :';
                                            }
                                            ?>
                                            <p><span class="price-title"><?=$priceTitle?></span><span class="price-before"><?= number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', ' ') ?> <span>₽</span></span><?if($arResult['IBLOCK_ID']==42){?> за одну линзу<?}?></p>
                                        </div>
                                    <?}?>
                                <?}?>

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

                        <? if ($arResult['PRODUCT_AVAILABLE'] == 'IN_STOCK') { ?>
                            <p class="nalichie js-prod_nalichie">В наличии
<?if( $arResult['CATALOG_QUANTITY'] <= 201 ){?><img src="<?=SITE_TEMPLATE_PATH?>/img/image!.png" alt=""> В ограниченном количестве<?}?>
                            </p>
                        <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER') { ?>
                            <p class="nalichie nalichie_preorder js-prod_nalichie">Под заказ</p>
                        <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'DELAY') { ?>
                            <p class="nalichie nalichie_delay js-prod_nalichie"><?=$arResult['PROPERTIES']['DELIVERY_DELAY']['NAME'];?></p>
                        <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'IN_STORE') { ?>
                            <p class="nalichie nalichie_delay js-prod_nalichie">Товар на складе</p>
                        <? } else { ?>
                            <p class="nalichie nalichie_no js-prod_nalichie">Нет в наличии</p>
                        <? } ?>

                </div>


<div class="productCard_buttons">
    <? if ($arResult['PRODUCT_AVAILABLE'] == 'IN_STOCK') { ?>
        <?if($arResult['IBLOCK_ID']==42){?>
            <a href="#rezerv" class="open-popup-link rezerv_btn">Забронировать цену со скидкой</a>
        <?} else {?>
            <a href="#rezerv" class="open-popup-link rezerv_btn">Отложить на примерку в салоне</a>
        <?}?>
    <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'DELAY' || $arResult['PRODUCT_AVAILABLE'] == 'IN_STORE') { ?>
        <a href="#rezerv" class="open-popup-link rezerv_btn delay">Доставить на примерку в салон</a>
    <?}?>

    <?/*?><div class="addons-block"><?*/?>
  <?if ( !in_array($arParams['CITY_NAME'], ['Москва','Санкт-Петербург']) > 0):?>
      <div class="cart-item-price-qty cart-item-price-qty_cart js-count_wrap" data-count="<?=$arResult['CATALOG_QUANTITY']?>"
        <?/*if(!$arResult['CAN_BUY'])echo ' style="display:none"'*/?>
        style="display:none">
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
            <? if ($arResult['PRODUCT_AVAILABLE'] == 'IN_STOCK') { ?>
              <div class="buy-btn js-prod_orderprice" data-id="<?=$arResult['ELEMENT_ID']?>">
                  <span>Уточнить стоимость</span>
              </div>
            <? } elseif ($arResult['PRODUCT_AVAILABLE'] == 'DELAY' || $arResult['PRODUCT_AVAILABLE'] == 'IN_STORE') { ?>
              <div class="buy-btn js-prod_orderprice oraBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                  <span>Уточнить стоимость</span>
              </div>
            <?} else {?>
                <div class="buy-btn js-prod_orderprice redBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                  <span>Уточнить стоимость</span>
                </div>
            <?}?>
          <?break;

          case 'OLD_PRICE':
          case 'PRICE':
              if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                  <?/*?><div class="buy-btn buy-btn_short js-buy" data-id="<?=$arResult['ELEMENT_ID']?>"><?*/?>
                    <? if ($arResult['PRODUCT_AVAILABLE'] == 'DELAY' || $arResult['PRODUCT_AVAILABLE'] == 'IN_STORE'): ?>
                  <div class="buy-btn js-buy oraBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                    <? else: ?>
                  <div class="buy-btn js-buy" data-id="<?=$arResult['ELEMENT_ID']?>">
                    <? endif; ?>
                      <span><img src="<?=SITE_TEMPLATE_PATH?>/img/imageCart.png" alt="" onclick="ym(24545261, 'reachGoal', 'zakaz-online');"> Заказать онлайн</span>
                  </div>
              <?} else {?>
                  <div class="buy-btn js-prod_preorder redBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                      <span>Заказать</span>
                  </div>
                  <div class="buy-btn js-prod_orderprice redBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                      <span>Уточнить стоимость</span>
                  </div>
              <?}?>
          <?break;

          default:?>
              <div class="buy-btn js-prod_preorder redBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                  <span>Заказать</span>
              </div>
              <div class="buy-btn js-prod_orderprice redBtn" data-id="<?=$arResult['ELEMENT_ID']?>">
                  <span>Уточнить стоимость</span>
              </div>
          <?break;
      }
      ?>
  </div>
<?/*?></div><?*/?>
</div>




				<?if($arResult['IBLOCK_ID'] == '12'){?>
					<?if($arResult["PROPERTIES"]["BRAND"]["VALUE"] != 15697):?>
                        <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
							<? if ($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER') { ?>
                                <p style="margin: 0 0 15px 0;"><strong>Cрок поставки уточняйте у наших менеджеров по <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a> </strong></p>
							<? } ?>
							<?if($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER'):?>
                                <p style="margin: 0;"><strong>Цена со скидкой действительна только при заказе очков вместе с линзами. Если вы хотите купить только оправу, позвоните.</strong></p>
							<?endif;?>
                        </div>
					<?endif;?>
				<?}?>
<?if($arResult['IBLOCK_ID']!=42){?>
	<?if($arResult['PRODUCT_AVAILABLE'] == 'PRE_ORDER'):?>
        <div class="bottomInfoPhone">
            <p style="margin: 0;"><strong>Цена на товар может измениться</strong></p>
        </div>
	<?endif;?>
    <div class="bottomInfoPhone">
        <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>" class="imgPhone">
            <img src="<?=SITE_TEMPLATE_PATH?>/img/imagePhone.jpg" alt="">
        </a>
        <p style="margin: 0;">Проконсультируем по наличию, зафиксируем цену с сайта (в салонах цена выше), запишем на примерку<?if (CSite::InDir('/eyeglass-frames/')) {?> и бесплатную проверку зрения<?}?>.  По <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>">телефону</a> и в <a href="javascript:jivo_api.open()">чате</a></p>
    </div>
<?}?>

<? if ($arResult['PRODUCT_AVAILABLE'] == 'IN_STOCK' || $arResult['PRODUCT_AVAILABLE'] == 'DELAY' || $arResult['PRODUCT_AVAILABLE'] == 'IN_STORE') { ?>
<div id="rezerv" class="white-popup mfp-hide">
    <div class="rezerv__container">
            <button class="rezerv__close mfp-close">
                <svg class="modal-close-icon"><use xlink:href="#close"></use></svg>
            </button>

         <div id="rezerv_form-wrap">
            <div class="h4">Выбор салона</div>
            <section class="rezerv_salons">

                <h3 class="hidden-md">
                    <?if($arParams['CITY_PARAMS']['NAME'] == 'Москва'){
                        echo 'Доступно в 2 салонах в городе Москва';
                    } else if ($arParams['CITY_PARAMS']['NAME'] == 'Санкт-Петербург'){
                        echo 'Доступно в 3 салонах в городе Санкт-Петербург';
                    } else {
                        echo 'Доступно в салонах:';
                    }?>        
                </h3>

                <div class="h3 d-md-none">
                    <?if($arParams['CITY_PARAMS']['NAME'] == 'Москва'){
                        echo 'Доступно в 2 салонах Москвы';
                    } else if ($arParams['CITY_PARAMS']['NAME'] == 'Санкт-Петербург'){
                        echo 'Доступно в 3 салонах С.Петербурга';
                    } else {
                        echo 'Доступно в салонах:';
                    }?>
                </div>

                <? if ($arResult['PRODUCT_AVAILABLE'] == 'DELAY'): ?>
                    <p class="callManager">Пожалуйста, дождитесь подтверждения вашего заказа</p>
                    <p>Оправа будет доставлена в выбранный вами салон в течение
                        <?=preg_replace('/[^0-9-]+/', '', $arResult['PROPERTIES']['DELIVERY_DELAY']['NAME']);?>
                        дней. Мы обязательно сообщим вам о поступлении интересующего вас товара</p>
                <? else: ?>
                <p class="callManager hidden-md">Дождитесь звонка менеджера с подтверждением резерва в выбранном салоне</p>
                <p class="callManager d-md-none">Обязательно дождитесь звонка с подтверждением резерва.</p>
                <? endif; ?>
                <?foreach ( $arResult['SALOON'] as $item ){?>
                    <div class="rezerv_salon">
                        <div class="rezerv_address">
                            <?=$item['PREVIEW_TEXT']?>
                            <p>
                                <a href="/contacts/#salon-map" target="_blank">
                                <span class="on-map-img">
                                    <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                </span>Показать на&nbsp;карте
                                </a>
                            </p>
                         </div>
                         <div class="rezerv_button">
                            <button class="rezerv_btn rezerv_btn-selectSalon" data-salon="<?=$item['ID']?>">
                            <? if ($arResult['PRODUCT_AVAILABLE'] == 'DELAY'): ?>
                                Доставить сюда
                            <? else: ?>
                                Зарезервировать
                            <? endif; ?>
                            </button>
                         </div>
                    </div>
                <?}?>
            </section><!--rezerv_salons-->
            <div class="h4">Резерв</div>
            <section class="rezerv_form">
                <div class="h3">Зарезервировать в салоне по адресу</div>
                <div class="rezerv_form-topInfo">
                    <div class="rezerv_form-address">
                        <?foreach ( $arResult['SALOON'] as $item ){?>
                            <div class="rezerv_form-salonID rezerv_form-salonID-<?=$item['ID']?>">
                                <?=$item['PREVIEW_TEXT']?>
                                <p>
                                    <a href="/contacts/#salon-map" target="_blank">
                                        <span class="on-map-img">
                                            <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                        </span>Показать на&nbsp;карте
                                    </a>
                                </p>
                                <button class="rezerv_form-salonBack">← Выбрать другой салон</button>
                            </div>
                        <?}?>
                    </div>
                    <div class="rezerv_form-product">
                        <img src="<?=$arResult['DETAIL_PICTURE']['SAFE_SRC']?>" alt="">
                        <div class="rezerv_form-product-right">
                            <div class="rezerv_form-product-title"><?=$arResult['NAME']?></div>
                            <?switch ($arResult['PRODUCT_PRICE_TYPE']) {
                                case 'NOT_SHOW_PRICE':?>
                                <p>уточнить стоимость</p>
                                <?break;

                                case 'OLD_PRICE':?>
                                <?/*if ($arResult['PRODUCT_AVAILABLE'] != 'PRE_ORDER') {?>
                                    <?if(SITE_ID!='m1') {?>
                                        <?if(SITE_ID!='m2') {?>
                                            <p>
                                                <span class="rezerv_price-title">Цена на сайте:</span>
                                                <span class="rezerv_price"><?=number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', ' ') ?>
                                                    <span>₽</span>
                                                </span>
                                            </p>
                                        <?}?>
                                    <?}?>
                                <?}*/?>

                                <?$withoutLenzes = $arResult['PROPERTIES']['DISCONT_WITHOUT_LENZES']['VALUE'];

                                if ($withoutLenzes =='Y') {
                                    $fullPrice = number_format($arResult['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', '');
                                    $priceBest =  ceil($fullPrice/2);?>
                                    <p>
                                        <span class="rezerv_price-title">Цена на сайте:</span>
                                        <span class="rezerv_price"><?=number_format($priceBest, 0, '', ' ')?>
                                            <span>₽</span>
                                        </span>
                                    </p>

                                <?} else {?>
                                    <p>
                                        <span class="rezerv_price-title">Цена на сайте:</span>
                                        <span class="rezerv_price"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?>
                                            <span>₽</span>
                                        </span>
                                    </p>
                                <?}?>

                                <?break;

                                case 'PRICE':?>
                                    <p>
                                        <span class="rezerv_price-title">Цена на сайте:</span>
                                        <span class="rezerv_price"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ') ?>
                                            <span>₽</span>
                                        </span>
                                    </p>
                                <?break;

                                default:?>
                                    <p>Предзаказ</p>
                                <?break;
                            }?>
                        </div>
                    </div>
                </div>

                <div class="rezerv_form-form">
                    <div class="h3">Контактная информация</div>
                    <form action="<?=SITE_TEMPLATE_PATH?>/sendRezerv.php" method="POST" onsubmit="ym(24545261, 'reachGoal', 'otlojit'); return true;">
                        <div class="rezerv_form-formInputs">
                            <div class="form-item">
                                <input class="input" type="text" name="name" placeholder="Ваше имя">
                            </div>
                            <div class="form-item">
                                <input class="input phonemask required" type="tel" name="phone" placeholder="Номер телефона*" required>
                            </div>
                            <div class="form-item">
                                <input class="input" type="text" name="promocode" placeholder="Промокод (если есть)">
                            </div>
                        </div>
                        <div class="rezerv_form-formTextarea form-item">
                            <textarea class="input" name="comment" placeholder="Комментарии и пожелания"></textarea>
                        </div>
                        <div class="rezerv_form-formFooter">
                            <button type="button" class="rezerv_btn sendRezervBtn">
                            <? if ($arResult['PRODUCT_AVAILABLE'] == 'DELAY'): ?>
                                Доставить сюда
                            <? else: ?>
                                Зарезервировать в салоне
                            <? endif; ?>
                            </button type="button">
                            <p>Нажимая кнопку, вы соглашаетесь на обработку данных</p>
                        </div>
                         <input type="text" name="last_name" class="lastnameinp">
                         <input type="hidden" name="utm_source" value="<?php echo $_SESSION['utm_source']; ?>">
                         <input type="hidden" name="utm_medium" value="<?php echo $_SESSION['utm_medium']; ?>">
                         <input type="hidden" name="utm_campaign" value="<?php echo $_SESSION['utm_campaign']; ?>">
                         <input type="hidden" name="utm_content" value="<?php echo $_SESSION['utm_content']; ?>">
                         <input type="hidden" name="utm_term" value="<?php echo $_SESSION['utm_term']; ?>">
                         <input type="hidden" name="clientID" value="">
                         <input type="hidden" name="form" value="Резерв в салоне">
                         <input type="hidden" name="rezrvSalonID" value="">
                         <input type="hidden" name="product" value="<?=$arResult['NAME']?>">

                    </form>
                    <? if ($arResult['PRODUCT_AVAILABLE'] == 'DELAY'): ?>
                        <p class="callManager">Пожалуйста, дождитесь подтверждения вашего заказа</p>
                        <p>Оправа будет доставлена в выбранный вами салон в течение
                            <?=preg_replace('/[^0-9-]+/', '', $arResult['PROPERTIES']['DELIVERY_DELAY']['NAME']);?>
                            дней. Мы обязательно сообщим вам о поступлении интересующего вас товара</p>
                    <? else: ?>
                     <p class="callManager hidden-md">Дождитесь звонка менеджера с подтверждением резерва в выбранном салоне</p>
                     <p class="callManager d-md-none">Обязательно дождитесь звонка с подтверждением резерва.</p>
                    <? endif; ?>
                </div>
            </section>
         </div><!--rezerv_form-->
    </div>
</div>
<?}?>
<style>
    .lastnameinp {position: absolute;left: -9999px;display: none;}
    .product-page-status {margin-top: 0 !important;}
    .nalichie {align-self: flex-start; font-size:  12px !important; padding-right: 0 !important; padding-left: 15px;}
    .nalichie:after {display: none !important;}
    .nalichie:before {
        content: '';
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        left: 0;
        margin-right: 5px;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        width: 8px;
        height: 8px;
        background-color: #8fd436;
    }
    .nalichie.nalichie_delay:before {
        background-color: #ff8343;
    }
    .nalichie img {height: 12px; margin-left: 5px;}
    .productCard_buttons {display: flex; margin-bottom: 15px;}
    .productCard_buttons .rezerv_btn {font-size: 15px; display: flex; align-items: center; justify-content: center; padding-left: 5px; padding-right: 5px; margin-right: 10px;}

    .description p.infoPhone {line-height: normal;}
    .description p.infoPhone a {display: inline; line-height: normal; text-transform: unset; padding: 0; text-decoration: underline; font-size: 18px; font-weight: normal;}

    .productCard_buttons .buy-btn {margin-bottom: 0; width: 220px;}
    .productCard_buttons .buy-btn span {font-size: 15px; transition: .3s; padding: 0 10px !important;}

    .productCard_buttons .buy-btn:not(.redBtn) {width: 190px;}
    .productCard_buttons .buy-btn:not(.redBtn) span { border: 2px solid #f44747; background: transparent; color: #393939; }
    .productCard_buttons .buy-btn.oraBtn span { border: 2px solid #ff8343; }
    .productCard_buttons .buy-btn:not(.redBtn) span img {margin-right: 5px; position: relative; top: 2px; transition: .3s;}
    .productCard_buttons .buy-btn:not(.redBtn) span:hover {background: #f44747; color: #fff;}
    .productCard_buttons .buy-btn.oraBtn span:hover { background: #ff8343; }
    .productCard_buttons .buy-btn:not(.redBtn) span:hover img {filter: invert(1);}

    .bottomInfoPhone {display: flex; margin: 15px 0; font-size: 16px; line-height: normal;}
    .bottomInfoPhone a.imgPhone {align-self: flex-start; margin-right: 10px; margin-top: 5px;}
    .bottomInfoPhone a:not(.imgPhone) {text-decoration: underline;}
    .bottomInfoPhone a img {max-width: 30px;}

    .rezerv__container {
        position: relative;
        width: 100%;
        max-width: 900px;
        background-color: #fff;
        margin: 0 auto;
        -webkit-box-shadow: 0 8px 30px rgb(0 0 0 / 20%);
        box-shadow: 0 8px 30px rgb(0 0 0 / 20%);
        padding: 30px;
    }
    .rezerv__container h3 span, .rezerv__container .h3 span {color: #ff5050; text-decoration: underline;}
    .rezerv__container .h3 {
        display: block;
        font-size: 1.17em;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }
    .rezerv__container .h4 {
        display: block;
        margin-block-start: 1.33em;
        margin-block-end: 1.33em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }
    .rezerv__container .callManager {color: #ff5050; font-weight:  bold;}
    .rezerv_salons {}
    .rezerv_salon {display: flex; justify-content: space-between; padding: 30px 0; border-bottom: 1px solid #cdcdcd}
    .rezerv_salon:last-child {border-bottom: 0;}
    .rezerv_address {}
    .rezerv_address p {margin: 0 0 10px 0;}
    .rezerv_button {}
    .rezerv_btn {
        display: block;
        width: 100%;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        background-color: #f44747;
        line-height: 45px;
        text-align: center;
        text-transform: uppercase;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        border: 0;
        outline:  none;
        padding-left: 20px;
        padding-right: 20px;
        }
    .rezerv_btn:hover {
        background: #ff8343;
    }
    .rezerv_btn.delay {
        background: #ff8343;
    }
    .rezerv_btn.delay:hover {
        background: #f44747;
    }
    .rezerv_form-salonID {display: none;}
    .rezerv_form-salonID p {margin: 0 0 10px 0;}
    .rezerv_form-salonID.active {display: block;}
    .rezerv_form-topInfo {
        display: flex;
        justify-content: space-between;
        padding-bottom: 30px;
        border-bottom: 1px solid #cdcdcd;
    }
    .rezerv_form-product {
        display: flex;
    }
    .rezerv_form-product img {
        width: 100px;
        height: auto;
        align-self: flex-start;
    }
    .rezerv_form-product-right {
        display: flex;
        flex-direction: column;
        padding-left: 15px;
    }
    .rezerv_form-product-right p {margin: 0;}
    .rezerv_form-product-title {font-weight: bold;}
    .rezerv_form-salonBack {background: #eee; outline: none; cursor: pointer; padding: 5px 10px; margin: 0; font-size: 16px; border: 1px solid #cdcdcd; border-radius: 4px;}
    .rezerv_form-formInputs {display: flex;}
    .rezerv_form-formInputs .form-item {flex-grow: 1;}
    .rezerv_form-formInputs .form-item + .form-item {margin-left: 15px;}
    .rezerv_form-formInputs .form-item .input {border: 1px solid #b5b5b5;}
    .rezerv_form-formTextarea.form-item .input {border: 1px solid #b5b5b5;}
    .rezerv_form-formTextarea.form-item textarea {height: 100px; padding-top: 15px;}
    .rezerv_form-formFooter {display: flex; align-items: center; margin-bottom: 30px;}
    .rezerv_form-form button {width: auto; margin-right: 30px; padding-left: 15px;padding-right: 15px;}
    .rezerv_form-form p {margin: 0;}
    @media screen and (max-width:1280px) {
        .productCard_buttons .rezerv_btn {max-width: none; margin-right: 0;margin-bottom: 15px}
        .productCard_buttons {flex-wrap: wrap; margin-top:15px;}
        .productCard_buttons .buy-btn { width: 100%!important;}
        .js-prod_buy_wrap { width: 100%; flex-wrap: wrap;}
        .buy-btn.js-prod_orderprice.redBtn {margin-left: 0;margin-top:15px;}
}
    @media screen and (max-width:991px) {
        .productCard_buttons {flex-direction: column;}
        .productCard_buttons .rezerv_btn {margin-right: 0; margin-bottom: 15px}
        .productCard_buttons .buy-btn {width: 100% !important}
        .prices-block {margin-bottom: 10px !important}
        .nalichie {margin-bottom: 15px !important}
        .product-page .with-border {padding-bottom: 0 !important;}


        .rezerv__close {top: -5px !important; right: -5px !important;}
        .rezerv__container {padding: 15px 15px 30px 15px;}
        .rezerv_salons h3, .rezerv_salons .h3 {margin-top: 5px; margin-bottom: 5px; line-height: normal;}
        .rezerv_salon {flex-direction: column; padding: 20px 0;}
        .rezerv__container .callManager {margin: 5px 0; font-size: 16px; line-height: normal;}
        .rezerv_address p {line-height: normal}
        .rezerv_form-topInfo {flex-direction: column;}
        .rezerv_form h3, .rezerv_form .h3 {margin-top: 5px; margin-bottom: 10px; line-height: normal;}
        .rezerv_form-address {margin-bottom: 30px}
        .rezerv_form-address p {line-height: normal}
        .rezerv_form-product img {align-self: center}
        .rezerv_form-formInputs {flex-direction: column;}
        .rezerv_form-formInputs .form-item + .form-item {margin-left: 0}
        .rezerv_form-formFooter {flex-direction: column; margin-bottom: 15px}
        .rezerv_form-form h3, .rezerv_form-form .h3 {margin: 15px 0;}
        .rezerv_form-form p {font-size: 14px; margin-top: 10px; text-align: center}
        .rezerv_form-formInputs .form-item {margin-bottom: 10px}
        .rezerv_form-form .callManager {font-size: 16px;}
        .rezerv_form-form button {width: 100%; margin-right: 0}

    }
</style>

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


    <?/*$phoneNumber = \PDV\Tools::getDataByCity($arParams['CITY_PARAMS']['ID'])['PHONE_HEADER'][0];*/?>
    <!--
    <?if ($arParams['CITY_NAME'] == 'Санкт-Петербург') {?>           
    <p><strong>Салоны открыты! Посещение только по записи.</strong><br/>
    Мы заботимся о вашем здоровье и безопасности, поэтому ведем прием по записи <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></p>
    <?} else {};?>
    -->
<div class="h3">Адреса салонов оптики в <?=$arParams['CITY_PARAMS']['NAME_DECLENSION']?>:</div>
        <?//}?>
        <div class="invitements-block">
            <?foreach ( $arResult['SALOON'] as $item ){?>
                <div class="invitement">
					<?//=$item['PREVIEW_TEXT']?>
					<?=$item['PROPERTY_CARD_TEXT_VALUE']["TEXT"]?>
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
					<?if ( !empty($item['PROPERTY_BRAND_LIST_CARD_VALUE']["TEXT"]) ){?>
                        <div class="description">
                            <div class="toggle">
                                <span>Список брендов в наличии в новом салоне</span>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="14" viewBox="0 0 13 14">
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
                                        <div class="description-list__item" >
						<?=$item['PROPERTY_BRAND_LIST_CARD_VALUE']["TEXT"]?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<?/*?>
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
<?*/?>
<?if (CSite::InDir('/eyeglass-frames/')) {?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
        <strong>Бесплатная консультация оптометриста.</strong> Запишитесь в салон — подберем комфортную оправу нужного размера.
        <br><br>
        Подробности и запись:  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
    </div>
<?} else if($arResult['IBLOCK_ID']==42){?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
        <strong>Бесплатная консультация.</strong> Запишитесь в салон — проверим зрение и подберем очковые линзы с учетом вашего рецепта.
        <br><br>
        Подробности и запись:  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
    </div>
<?} else {?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
        <strong>Бесплатная консультация.</strong> Запишитесь в салон — подберем комфортную оправу нужного размера.
        <br><br>
        Подробности и запись:  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
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
                            <?if (CSite::InDir('/eyeglass-frames/')) {?>
                               <span>Характеристики оправы</span>
                            <?} elseif (CSite::InDir('/sunglasses/')){?>
                                <span>Характеристики солнцезащитных очков</span>
                            <?} elseif (CSite::InDir('/sports-glasses/')){?>
                                <span>Характеристики спортивных очков</span>
                            <?}else {?>
                                <span>Характеристики</span>
                            <?}?>
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
                                        <div class="description-list__item" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                            <p class="label" itemprop="name"><?= $arResult['PROPERTIES'][$propCode]['NAME'] ?>:</p>
                                            <?
                                                $code = ToLower($propCode);
                                                $arFilterValues = array();
                                                foreach($arValues['VALUES'] as $fCode => $fValue)
                                                {
                                                    if(intval($fCode) > 0) $fCode = CUtil::translit($fValue, LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '']);
                                                    $url = "/".$arResult["SECTION"]["CODE"]."/filter/".$code."-is-".$fCode."/apply/";
													$arFilterValues[] = '<a href="'.$url.'">'.$fValue.'</a>';
                                                }
                                            ?>
                                            <p class="value" itemprop="value"><?= implode(' / ', $arFilterValues); ?></p>
                                        </div>
                                    <? } ?>

                                    <?
                                        if ($arParams['IBLOCK_ID'] == '42') {
                                                        $lenses_char = array("LENSES_INDEX","LENSES_SURFACE_DESIGN","LENSES_MATERIAL","LENSES_DESIGN","LENSES_FEATURES");

                                                        foreach($lenses_char as $char) {
                                                            if ( !empty($arResult['PROPERTIES'][$char]['VALUE']) ){?>
                                                                                        <div class="description-list__item" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                                                                            <p class="label" itemprop="name"><?= $arResult['PROPERTIES'][$char]['NAME'] ?>:</p>
                                                                                            <p class="value" itemprop="value">
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
                           

                            <?if($arResult['IBLOCK_ID']!=42){?>
                            <p class="infoPhone">Уточнить наличие нужного вам размера можно в <a href="javascript:jivo_api.open()">чате</a> или по телефону <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a> </p>
                            <?}?>
                        </div>
                    </div>
                <?endif;?>

                <?if($arResult['IBLOCK_ID']==42){?>
                    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
                        <p class="infoPhone">Уточнить срок изготовления по вашему рецепту можно в <a href="javascript:jivo_api.open()">чате</a> или по телефону <a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a> </p>
                    </div>
                <?}?>

                <?if ( in_array($arParams['CITY_NAME'], ['Москва','Санкт-Петербург']) ) {?>
                    <div class="description">
                        <div class="toggle">
                            <?if (CSite::InDir('/eyeglass-frames/')) {?>
                               <span>Как приобрести оправу</span>
                            <?} elseif (CSite::InDir('/sunglasses/')){?>
                                <span>Как приобрести солнцезащитные очки</span>
                            <?} elseif (CSite::InDir('/sports-glasses/')){?>
                                <span>Как приобрести спортивные очки</span>
                            <?}else {?>
                                <span>Как приобрести</span>
                            <?}?>
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
                                <div class="description-list" style="font-size: 14px;">
<?if($arResult['IBLOCK_ID']==42){?>
Вы можете приобрести очковые линзы в салоне или заказать с доставкой. Обратите внимание, что верно изготовленные по рецепту линзы нельзя вернуть или обменять (постановление правительства РФ № 55 от 19.01.1998).
<br><br>
<strong>Запись в салон</strong><br>
Нажмите «Забронировать цену со скидкой». Выберите удобный салон «Черника-Оптика» в <?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>Москве<?} elseif ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>Санкт-Петербурге<?} else {?>Москве или Санкт-Петербурге<?}?> — мы зафиксируем для вас цену с сайта (в салонах цена выше) и запишем на бесплатную проверку зрения и подбор очковых линз.
<br><br>
Оплата в салоне наличными или банковской картой.
<br><br>
<?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>
    <strong>Курьерская доставка по Москве</strong>
<?} elseif ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
    <strong>Курьерская доставка по Санкт-Петербургу</strong>
<?} else {?>
    <strong>Курьерская доставка по Москве и Санкт-Петербургу</strong>
<?}?><br>
Нажмите «Заказать онлайн»* и выберите доставку курьером. Курьер доставит выбранные линзы или очки с линзами вам домой или на работу.
<br><br>
Оплата курьеру наличными или банковской картой.
При покупке линз или оправы с линзами от 6000 рублей — доставка бесплатно.
<br><br>
<strong>Почта России и СДЭК (для регионов)</strong>
Нажмите «Заказать онлайн»*, выберите доставку в регионы. После оформления заявки менеджер свяжется с вами, чтобы подтвердить заказ, и вышлет ссылку для онлайн-оплаты. Когда оплата поступит — отправим заказ и пришлем номер для отслеживания.
<br><br>
Почтой и СДЭК доставляются только оплаченные (или частично оплаченные) заказы.
<br><br>
* Для получения скидки при онлайн-заказе не забудьте указать промокод <strong style="color:red">0803</strong>

<?} else {?>
Вы можете примерить понравившуюся модель в салоне или заказать с доставкой. Ниже мы подробно рассказали о каждом способе.
<br><br>
<strong>Запись в салон</strong><br>
Нажмите «Отложить на примерку в салоне». Выберите удобный салон «Черника-Оптика» в <?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>Москве<?} elseif ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>Санкт-Петербурге<?} else {?>Москве или Санкт-Петербурге<?}?> — мы зафиксируем для вас цену с сайта (в салонах цена выше) и запишем на бесплатную проверку зрения и примерку оправ в удобное для вас время.
<br><br>
Оплата в салоне наличными или банковской картой.
<br><br>
<?if ( $arParams['CITY_NAME'] == 'Москва' ) {?>
    <strong>Курьерская доставка по Москве</strong>
<?} elseif ( $arParams['CITY_NAME'] == 'Санкт-Петербург' ) {?>
    <strong>Курьерская доставка по Санкт-Петербургу</strong>
<?} else {?>
    <strong>Курьерская доставка по Москве и Санкт-Петербургу</strong>
<?}?>
Нажмите «Заказать онлайн» и выберите доставку курьером. Курьер привезет выбранные оправы (до 4 штук) для примерки к вам домой или на работу.
<br><br>
Оплачиваются только оправы, которые вы решили приобрести. Если ни одна не подошла — оплачивается только доставка (250 рублей).
<br><br>
Оплата курьеру после примерки наличными или банковской картой.<br>При покупке оправы от 6000 рублей — доставка бесплатно.
<br><br>

Мы настоятельно рекомендуем примерить оправы в салоне.<br>
<?if (CSite::InDir('/eyeglass-frames/')) {?>
• В большинстве случаев при выборе оправы <strong>нужно учитывать ваш рецепт</strong>. Например, безободковые или тонкие металлические оправы не подойдут, если у вас большой «минус».<br>
<?}?>
• <strong>В салоне выбор больше</strong>, особенно последних коллекций.  На сайте представлен не весь ассортимент.<br>
• Наши консультанты помогут сделать правильный выбор.
<br><br>

<strong>Почта России и СДКЭК (для регионов)</strong><br>
Нажмите «Заказать онлайн», выберите доставку в регионы. После оформления заявки менеджер свяжется с вами, чтобы подтвердить заказ, и вышлет ссылку для онлайн-оплаты. Когда оплата поступит — отправим заказ и пришлем номер для отслеживания.
<br><br>
Почтой и СДЭК доставляются только оплаченные (или частично оплаченные) заказы.
<?}?>

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
<?if (CSite::InDir('/eyeglass-frames/')) {?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
Скидка действует при заказе оправы с линзами через сайт и при предварительной записи в салон.
<br><br>
Записаться можно онлайн и по телефону  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
    </div>
<?} else if($arResult['IBLOCK_ID']==42) {?>
     <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
        Скидка действует при предварительной записи в салон и заказе линз онлайн с промокодом <strong style="color: red;">0803</strong>.
        <br><br>
        Записаться можно онлайн и по телефону  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
    </div>
<?} else {?>
    <div class="info-block new_fl_infoBlock" style="font-size: 16px;">
Скидка действует при заказе солнцезащитных очков через сайт и при предварительной записи в салон.
<br><br>
Записаться можно онлайн и по телефону  <nobr><a href="tel:<?=\PDV\Tools::clearPhone($phoneNumber)?>"><?=$phoneNumber?></a></nobr>
    </div>
<?}?>
            </div>

        </div>
    </div>
</section>
<?if(CSite::InDir("/eyeglass-frames/")):?>
<div class="container">
	<div class="element-detail-text" >
        <? if ($arResult["DISPLAY_DETAIL_TEXT"] != "N" && $arResult['PROPERTIES']['DESC']['VALUE']['TEXT']): ?>
            <div itemprop="description">
                <? if ($arResult['PROPERTIES']['DESC']['VALUE']['TYPE'] == 'HTML'): ?>
                    <?=html_entity_decode($arResult['PROPERTIES']['DESC']['VALUE']['TEXT'])?>
                <? else: ?>
                    <?=$arResult['PROPERTIES']['DESC']['VALUE']['TEXT']?>
                <? endif; ?>
            </div>
		<?else:?>
				<h2>Оправа <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?> купить в "Черника-оптика"</h2>
				<div itemprop="description"><p>Оправа <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?> - оригинальный товар любимого многими бренда
                    <a href="<?="/".$arResult["SECTION"]["CODE"]."/filter/brand-is-".ToLower($arResult['BRAND']['CODE'])."/apply/"?>"><?=$arResult['BRAND']['NAME']?></a>,
                    который подчеркнет ваш стиль. Вы можете приобрести понравившуюся вам оправу онлайн или в одном из наших салонов в <?=$arParams['CITY_PARAMS']['NAME_DECLENSION']?>.
                    Чтобы получить скидку сайта, зарезервируйте оправу через сайт. Тогда цена будет для вас ниже, чем в розничных магазинах.</p>
                    <p>Наши опытные оптометристы, имеющие действующие сертификаты о специальном образовании, на самом современном оборудовании проверят ваше зрение и подберут для вас линзы в выбранную вами оправу с учетом ваших потребностей.</p></div>
		<?endif;?> 
	</div>
</div>
<? elseif (CSite::InDir("/sunglasses/")): ?>
    <div class="container">
        <div class="element-detail-text" >
            <? if ($arResult["DISPLAY_DETAIL_TEXT"] != "N" && $arResult['PROPERTIES']['DESC']['VALUE']['TEXT']): ?>
                <div itemprop="description">
                    <? if ($arResult['PROPERTIES']['DESC']['VALUE']['TYPE'] == 'HTML'): ?>
                        <?=html_entity_decode($arResult['PROPERTIES']['DESC']['VALUE']['TEXT'])?>
                    <? else: ?>
                        <?=$arResult['PROPERTIES']['DESC']['VALUE']['TEXT']?>
                    <? endif; ?>
                </div>
            <? else: ?>
                <? $article = trim(str_replace('с/з', '', $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])); ?>
                <h2>Солнцезащитные очки <?=$article?> купить в <?=$arParams['CITY_PARAMS']['NAME_DECLENSION']?></h2>
                <div itemprop="description">
                    <p>
                        Солнцезащитные очки <?=$article?> - оригинальный товар любимого многими бренда
                        <a href="<?="/".$arResult["SECTION"]["CODE"]."/filter/brand-is-".ToLower($arResult['BRAND']['CODE'])."/apply/"?>"><?=$arResult['BRAND']['NAME']?></a>.
                    </p>
                    <p>
                        Модель защитит ваши глаза от избыточного излучения ультрафиолета и поможет создать индивидуальный образ.
                        Вы можете приобрести очки в одном из наших салонов или сделать заказ онлайн.
                        Тогда цена будет для вас ниже, чем в розничных магазинах.
                    </p>
                </div>
            <? endif; ?>
        </div>
	</div>
<?endif;?>

<?if ( !empty($arResult['OFFERS_COLORS']) ):?>
    <script>var offerParams = "<?=CUtil::PhpToJSObject($arResult['OFFERS_COLORS'], false, true); ?>";</script>
<?endif;?>
<? if (!empty($arResult['IMAGES']) && count($arResult['IMAGES']) > 1) { ?>
    <script>
        $(document).ready(function() {
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
        });
    </script>
<? } ?>

<?if(CModule::IncludeModule("arturgolubev.ecommerce")){
    $APPLICATION->IncludeComponent(
        "arturgolubev:ecommerce.detail",
        ".default",
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "OFFERS_CART_PROPERTIES" => $arParams['OFFERS_CART_PROPERTIES'],
            "PRODUCT_ID" => $arResult['ID'],
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "360000"
        ),
        $component
    );
}?>