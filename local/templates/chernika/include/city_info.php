<?
//use \Bitrix\Main\Loader,
//    \Bitrix\Main\Application,
//    \Bitrix\Main\Web\Cookie,
//    \Bitrix\Main\Context;

//Loader::includeModule('sale');

//$CITY_NAME = Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME');
//$CITY_ID = Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_ID');
//
//if(isset($_GET['cityID']) && !isset($_SESSION['cityID'])){
//   $_SESSION['cityID'] = $_GET['cityID'];
//   if ($_SESSION['cityID'] == 'msk') { $CITY_NAME = 'Москва'; $CITY_ID = 84; $_SESSION['cityID'] = 'just change';}
//   if ($_SESSION['cityID'] == 'spb') { $CITY_NAME = 'Санкт-Петербург'; $CITY_ID = 85; $_SESSION['cityID'] = 'just change';}
//}
//
//if ( empty($CITY_NAME) ) {
//    $CITY_NAME = 'не определен';
//
//    if ( SITE_ID == 's2' )
//        $geoCity = 'Санкт-Петербург';
//    else {
//        $address = \PDV\Altasib::GetAddr();
//        $geoCity = (!empty($address['city'])?$address['city']:$address['region']);
//    }
//
//    if ( !empty($geoCity) ) {
//        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
//            'order' => array('NAME_RU' => 'asc'),
//            'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY', '?NAME_RU' => $geoCity),
//            'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
//        ));
//        if ( $item = $res->fetch() ) {
//            $CITY_NAME = $item['NAME_RU'];
//            $CITY_ID = $item['ID'];
//
//            $context = Application::getInstance()->getContext();
//
//            $cookie = new Cookie('SELECT_CITY_ID', $item['ID']);
//            $cookie->setDomain(SITE_SERVER_NAME);
//            $cookie->setExpires(0);
//            $cookie->setHttpOnly(false);
//            $context->getResponse()->addCookie($cookie);
//
//            $cookie = new Cookie('SELECT_CITY_NAME', $item['NAME_RU']);
//            $cookie->setDomain(SITE_SERVER_NAME);
//            $cookie->setExpires(0);
//            $cookie->setHttpOnly(false);
//            $context->getResponse()->addCookie($cookie);
//        }
//    }
//}

//if ($CITY_NAME == 'Санкт-Петербург') {
//    if (SITE_ID != 's2')
//        LocalRedirect(PROTOCOL . 'spb.' . CUSTOM_HTTP_HOST . CURRENT_DIR);
//} else {
//    if (SITE_ID == 's2')
//        LocalRedirect(SITE_DOMAIN . CURRENT_DIR);
//}

// if ( in_array($CITY_NAME, ['Москва','Санкт-Петербург']) )
//     define('PRICE_BASE__CODE', 'Продажа на сайте');
// else
//     define('PRICE_BASE__CODE', 'Продажа на сайте ИнтернетМагазин');

// define('PRICE_BASE__CODE', 'Продажа на сайте');
//
// switch ($CITY_ID) {
//     case '85':
//         define('PRICE_MARKET__CODE', 'СПБ_Я.Маркет_Цена');
//         define('PRICE_SPEC_MARKET__CODE', 'СПБ_Я.Маркет_СпецЦена');
//         break;
//     default:
//         define('PRICE_MARKET__CODE', 'Москва_Я.Маркет_Цена');
//         define('PRICE_SPEC_MARKET__CODE', 'Москва_Я.Маркет_СпецЦена');
//         break;
// }

$server = \Bitrix\Main\Context::getCurrent()->getServer();
// require_once($server->getDocumentRoot() . SITE_TEMPLATE_PATH . '/include/price_define.php');

//$arDefaultCity = array(
//    84 => 'Москва',
//    85 => 'Санкт-Петербург',
//    1699 => 'Волгоград',
//    2772 => 'Пермь',
//    3001 => 'Уфа',
//    3254 => 'Тюмень',
//    2930 => 'Орск',
//    2287 => 'Казань',
//    1016 => 'Воронеж',
//    3990 => 'Омск'
//);

$arDefaultCity = $_SESSION['CITIES_LIST'];
//$CITY_NAME = $_SESSION['GEO_IP']['NAME'];
//$CITY_ID = $_SESSION['GEO_IP']['ID'];
$arrSaloon = \PDV\Tools::getSaloon($CITY_NAME);
?>

<?if ($CITY_NAME==='Санкт-Петербург') {?>
    <div itemscope itemtype="http://schema.org/Organization">
	<img itemprop="image" style="display: none;" src="/local/templates/chernika/img/favicon.png" alt="Черника Оптика" >
        <meta itemprop="name" content="Черника Оптика">
        <meta itemprop="alternateName" content="Мега-Оптика">
        <meta itemprop="telephone" content="+7 (812) 409-48-72">
        <meta itemprop="telephone" content="+7 (800) 302-32-89">
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Санкт-Петербург">
            <meta itemprop="streetAddress" content="улица 1-я Красноармейская, дом 8-10">
        </div>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Санкт-Петербург">
            <meta itemprop="streetAddress" content="проспект Просвещения, дом 32 к1">
        </div>
	<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Санкт-Петербург">
            <meta itemprop="streetAddress" content="Комендантский проспект, дом 21, корпус 1">
        </div>
    </div>
<? } else { ?>
    <div itemscope itemtype="http://schema.org/Organization">
	<img itemprop="image" style="display: none;" src="/local/templates/chernika/img/favicon.png" alt="Черника Оптика" >
        <meta itemprop="name" content="Черника Оптика">
        <meta itemprop="alternateName" content="Мега-Оптика">
        <meta itemprop="telephone" content="+7 (495) 008-28-28">
        <meta itemprop="telephone" content="+7 (800) 302-32-89">
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Москва">
            <meta itemprop="streetAddress" content="улица Бутырский Вал дом 4">
        </div>
	<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Москва">
            <meta itemprop="streetAddress" content="улица Профсоюзная, дом 64/66">
        </div>
    </div>
<? } ?>
<div id="city-modal" class="mfp-hide city-container">
    <!--noindex-->
        <div class="modal-header">
            <input type="text" placeholder="Введите название города" class="city-input d-none d-md-block js-searchcity">
            <div class="h4 d-md-none">Мой город</div>
            <div class="h4 d-none d-md-block">Ваш регион: <?=$CITY_NAME?></div>
            <button class="mfp-close">
                <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
            </button>
        </div>

        <ul class="city-list">
            <? foreach ($arDefaultCity as $cityCode => $arCity) {?>
                <li class="default<? if ($arCity['ID'] == $CITY_ID) echo ' checked'; ?>">
                    <? if ($arCity['ID'] == $CITY_ID) { ?>
                        <span><?= $arCity['NAME'] ?></span>
                    <? } else {
                        // $url = $APPLICATION->GetCurPageParam('changeCityId=' . $cityCode, ['changeCityId']);

                        // if ($arCity['ID'] == 85) { // spb
                        $url = PROTOCOL . \PDV\Tools::getSubDomain($arCity['SUB_DOMAIN']) . CUSTOM_HTTP_HOST . CURRENT_DIR;
                        // }
                        ?>
                        <?/*?><a href="<?= $APPLICATION->GetCurPageParam('changeCityId=' . $cityId, ['changeCityId']) ?>"><?= $arCity['NAME'] ?></a><?*/?>
                        <a href="<?= $url ?>"><?= $arCity['NAME'] ?></a>
                    <? } ?>
                </li>
            <? } ?>
        </ul>

        <?if ( !empty($arrSaloon) ):?>
            <div class="d-none d-md-block city-adresses-modal">
                <div class="h5">Наши салоны в г. <?=$CITY_NAME?></div>
                <?foreach ( $arrSaloon as $item ){?>
                    <div class="city-adresses-column">
			<p class="city-adresses-name"><strong><?=$item['NAME']?></strong><? if (!empty($item['PROPERTY_COMMENT_VALUE'])) { ?><br/><span style="font-size:18px;font-weight: 400;"><?= $item['PROPERTY_COMMENT_VALUE'] ?></span><? } ?></p>
                        <p class="metro<?if($CITY_NAME=='Москва') echo ' metro_moscow';?>">
                            <?if ( !empty($item['PROPERTY_ICON_VALUE']) ){?>
                                <img src="<?=CFile::GetPath($item['PROPERTY_ICON_VALUE'])?>" alt="">
                            <?} else {?>
                                <?=htmlspecialchars_decode($item['DETAIL_TEXT'])?>
                            <? } ?>
                            <span>&nbsp;<?= $item['PROPERTY_METRO_VALUE'] ?></span>
                        </p>
                        <div class="adress"><?=$item['PREVIEW_TEXT']?></div>
                        <?if ( !empty($item['PROPERTY_MAP_VALUE']) ){?>
                            <?/*?><a href="#" class="on-map js-openmap" data-coord="<?= $item['PROPERTY_MAP_VALUE'] ?>"
                       data-name="<?= $item['NAME'] ?>"><?*/?>
                            <a href="/contacts/#salon-map" class="on-map_header">
                                <div class="on-map-img">
                                    <?/* <svg id="Layer_1000" version="1.1" xmlns="http://www.w3.org/2000/svg" height="15" width="15"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 15 15"
                                         style="enable-background:new 0 0 15 15;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                        </g>
                                    </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                </svg> */?>
                                </div>
                                Показать на&nbsp;карте
                            </a>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        <?endif;?>
    <!--/noindex-->
</div>

<div id="city-side" class="city-side initializable">
    <ul class="city-list">
        <? foreach ($arDefaultCity as $cityCode => $arCity) {?>
            <li class="default<? if ($arCity['ID'] == $CITY_ID) echo ' checked'; ?>">
                <? if ($arCity['ID'] == $CITY_ID) { ?>
                    <span><?= $arCity['NAME'] ?></span>
                <? } else {
                    // $url = $APPLICATION->GetCurPageParam('changeCityId=' . $cityCode, ['changeCityId']);

                    // if ($arCity['ID'] == 85) { // spb
                        $url = PROTOCOL . \PDV\Tools::getSubDomain($arCity['SUB_DOMAIN']) . CUSTOM_HTTP_HOST . CURRENT_DIR;
                    // }
                    ?>
                    <a href="<?= $url ?>"><?= $arCity['NAME'] ?></a>
                <? } ?>
            </li>
        <? } ?>
    </ul>
    <?/*?><ul class="city-list js_citylist">
        <? foreach ($arDefaultCity as $cityCode => $arCity) { ?>
            <li class="default<? if ($arCity['ID'] == $CITY_ID) echo ' checked'; ?>">
                <span data-id="<?= $arCity['ID'] ?>"><?= $arCity['NAME'] ?></span>
            </li>
        <? } ?>
    </ul><?*/?>
</div>