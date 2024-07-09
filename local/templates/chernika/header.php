<?php
use \Bitrix\Main\Page\Asset,
    \Bitrix\Main\Context,
    \Bitrix\Conversion\Internals\MobileDetect;
$asset = Asset::getInstance();
$context = Context::getCurrent();
$server = $context->getServer();
$httpHost = $server->getHttpHost();
$request = $context->getRequest();
$protocol = ($request->isHttps() ? 'https' : 'http') . '://';
$detect = new MobileDetect();
$subDomain = substr_count($httpHost, '.') > 1 ? substr($httpHost, 0, strpos($httpHost, '.')) : '';
if ($subDomain === 'dev')
    $subDomain = '';
define('CURRENT_DIR', $request->getRequestedPageDirectory() . '/');
define('HTTP_HOST',   $httpHost);
define('SUB_DOMAIN',  $subDomain);
define('PROTOCOL',    $protocol);
define('IS_MOBILE',   $detect->isMobile());
define('IS_TABLET',   $detect->isTablet());
define('CUSTOM_HTTP_HOST',  trim(str_replace(SUB_DOMAIN, '', HTTP_HOST), '.'));
define('SITE_DOMAIN', PROTOCOL . CUSTOM_HTTP_HOST);
foreach ($request->getQueryList() as $paramName => $paramValue) {
    if (strpos($paramName, 'utm_') !== false) {
        $_SESSION[$paramName] = $_SESSION[$paramName] ?? $paramValue;
    }
}
require_once('include/get_geo_ip.php'); // set city
$isHomePage = \PDV\Tools::isHomePage();
$isCatalog = \PDV\Tools::isCatalog();
$isLinzi = \PDV\Tools::isLinziPage();
$isLenses = \PDV\Tools::isLensesCatalog();
$is404 = \PDV\Tools::is404();
$notShowH1 = \PDV\Tools::notShowH1();
$favoriteCount = \PDV\Tools::getFavoritesCount();
$basketData = \PDV\Tools::getBasketData();
$notShowAuth = \PDV\Tools::notShowAuth();
$isPodborPage = \PDV\Tools::isPodborPage();
$isAjax = \PDV\Tools::isAjax();
$isOutletPage = \PDV\Tools::isOutletPage();
$isOutletSunglassesPage = \PDV\Tools::isOutletSunglassesPage();
//$analyticCountersFolder = !empty(SUB_DOMAIN) ? SUB_DOMAIN . '/' : '';
//$analyticCountersPath = rtrim('include/' . $analyticCountersFolder, '/');
$analyticCountersPath = 'include/';
global $USER;
?>
<?if($isLenses) {
    header('Location: /linzy/progressivnye-linzy-essilor/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <? //$APPLICATION->ShowHead();?>
    <title><? $APPLICATION->ShowTitle() ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="canonical" href="<?=PROTOCOL . HTTP_HOST . str_replace("//", "/", CURRENT_DIR)?>">
    <link rel="icon" type="image/svg+xml" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon.svg">
    <meta name="theme-color" content="#9971db">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-navbutton-color" content="#9971db">
    <meta name="apple-mobile-web-app-status-bar-style" content="#9971db">
    <meta name="yandex-verification" content="f0ce17d125b42cb8">
    <script  src="<?=SITE_TEMPLATE_PATH . '/js/plugins/jquery-2.1.3.js'?>"></script>
    <? /*?><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/main.min.css?v=<?=time()?>"><?*/ ?>
    <? /*?><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/custom.css?v=<?=time()?>"><?*/ ?>
    <?
	$asset->addCss(SITE_TEMPLATE_PATH . '/css/main.min.css');
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/custom.css');
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/jquery.steps.css');
    // if ( $USER->GetId() != 1) $asset->addJs('//api-maps.yandex.ru/2.1/?lang=ru_RU');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/js/scripts.min.js?v='.time());
    // $asset->addJs(SITE_TEMPLATE_PATH.'/js/custom.js?v='.time());
    // $asset->addJs(SITE_TEMPLATE_PATH.'/js/linkReplace.js?v='.time());
    // $asset->addJs(SITE_TEMPLATE_PATH . '/js/plugins/jquery-2.1.3.js');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/lazysizes.min.js');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/scripts.min.js');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/custom.min.js?v=0.0.6');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/linkReplace.min.js');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/jquery.cookie.js');
    $asset->addJs(SITE_TEMPLATE_PATH . '/js/jquery.steps.min.js');
    $APPLICATION->ShowMeta("robots", false, false);
    $APPLICATION->ShowMeta("keywords", false, false);
    $APPLICATION->ShowMeta("description", false, false);
    // $APPLICATION->ShowLink("canonical", null, false);
    // $asset = \Bitrix\Main\Page\Asset::getInstance();
    // $asset->addJs(SITE_TEMPLATE_PATH  . '/js/bitrix/bx.min.js');
    ?>
    <? //$APPLICATION->ShowHead(false);?>
    <?// $APPLICATION->ShowHeadStrings(); ?>
	<? //$APPLICATION->ShowCSS(false, false);?>
    <?//  $APPLICATION->ShowHeadScripts(); ?>
    <?php if (CSite::InDir('/personal/') || $USER->IsAdmin()) {
        $APPLICATION->ShowHeadStrings();
        $APPLICATION->ShowHeadScripts();
    } ?>
    <? require_once($analyticCountersPath . '/analitics_head.php'); ?>
    <?php /* ?><!--МСК колтрекинг задарма-->
    <script>(function(w, c){(w[c]=w[c]||[]).push(function(){new zTracker({"id":"4998bf9ccfb96d1f86e165795fa80d796229","metrics":{"metrika":"24545261","ga":"UA-133866473-1"}});});})(window, "zTrackerCallbacks");</script>
    <script async id="zd_ct_phone_script" src="https://my.zadarma.com/js/ct_phone.min.js"></script>
    <!--СПБ колтрекинг задарма-->
    <script>(function(w, c){(w[c]=w[c]||[]).push(function(){new zTracker({"id":"8e2572b9dc77c7a4827ed1d8d697eca16238","metrics":{"metrika":"24545261","ga":"UA-133866473-1"}});});})(window, "zTrackerCallbacks");</script>
    <script async id="zd_ct_phone_script" src="https://my.zadarma.com/js/ct_phone.min.js"></script><?php */ ?>
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <?/* <link rel="preload" href="<?php echo SITE_TEMPLATE_PATH ?>/fonts/FuturaPT-Book/FuturaPT-Book.woff" as="font" type="font/woff" crossorigin> */?>
 <style>
        html,body{margin:0;padding:0}
        #layout{display:none}
        #chernika-preloader{position:fixed;width:100%;height:100%;top:0;left:0;background-color:#fff;z-index:999}
        #chernika-preloader_spinner{width:300px;height:auto;position:absolute;top:0;right:0;bottom:0;left:0;margin:auto;animation:pulse .7s ease-in-out infinite}
	.viezd-btn {
    display: block;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    background-color: #f44747;
    line-height: 29px;
    padding: 0 11px;
    margin-left: 20px;
    text-align: center;
    font-size: 15px;
    color: #fff;
    cursor: pointer;}
.viezd-btn:hover {
background-color: #ff9e4a;
color: #fff !important;
}

.proverka-btn {
    display: block;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    background-color: #ff9e4a;
    line-height: 29px;
    padding: 0 11px;
    margin-left: 20px;
    text-align: center;
    font-size: 15px;
    color: #fff;
    cursor: pointer;}
.proverka-btn:hover {
background-color: #f44747;
color: #fff !important;
}
	.topDropdown {position: relative;}
	.topDropdown-inner {
		display: none !important;
		position: absolute;
		z-index: 9999;
		padding: 5px;
		background: #232323;
		width: 240px;
	}
	.topDropdown-inner li {padding: 5px 10px; line-height: normal;margin-right: 0;}
	.topDropdown-inner li a {
		color: #fff;
	}
	.topDropdown:hover .topDropdown-inner {display: flex !important; flex-direction: column;}
	.topDropdown-inner:hover {display: block !important;}
   .marquiz__container_inline .marquiz__button {
        background-color: #9971db;
        padding: 10px 20px;
        font-family: "Open Sans", sans-serif;
        font-size: 14px;
        font-weight: 400;
        color: #1a1a1a;
        border-radius: 5px;
        border: 2px solid #9971db;
        padding: 15px 30px;
        font-weight: bold;
    }
#marquiz__close {
        opacity: 1 !important;
    }
    #marquiz__close:hover {
        opacity: 0.6 !important;
    }
        @media only screen and (max-width:1024px){#chernika-preloader_spinner{width:200px;}}
        @keyframes pulse {0%,100%{opacity:0}50%{opacity:1}}
        @media screen and (max-width: 767px) {
            jdiv.__jivoMobileButton {
                margin-bottom: 50px;
                margin-left: -15px;
            }
        }
	.covid { width: 100%; padding: 10px 0; background-color: #009688;}
                    .covid .row {display: -webkit-flex; display: -moz-flex; display: -ms-flex; display: -o-flex; display: flex; padding: 0 15px;}
                    .covid a {display: -webkit-flex; display: -moz-flex; display: -ms-flex; display: -o-flex; display: flex; flex-grow: 1; justify-content: center;}
                    .covid a:hover {text-decoration: none;}
                    .covid p {margin: 0; color: #fff; text-align: center; width: 100%;}
                    .covid p strong span {display: inline-block; border-bottom: 1px solid #fff; line-height: normal;}
                    @media screen and (max-width: 991px) {.covid a {padding: 0 10px;}}
                    @media screen and (max-width: 768px) {
                        .covid {padding: 5px 0;}
                        .covid p {line-height: 16px;}
                        .noMobile {display: none}
                    }
 @media (max-height: 700px) and (min-width: 1023px) {
        #marquiz__close {
            top: -15px !important;
        }
    }

    @media (max-height: 653px) and (min-width: 1023px) {
        #marquiz__close {
            top: -10px !important;
        }
    }

    @media screen and (max-width:  767px) {
        .quiz_wrap {
            margin-bottom: 30px;
        }
    }
    </style>
</head>
<body>
<!-- Marquiz script start -->
<? if ( $CITY_ID == 2 ): ?>
<script>
function mquiz10() {
(function(w, d, s, o){ var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() { if (document.readyState !== 'loading') Marquiz.init(o); else document.addEventListener("DOMContentLoaded", function() { Marquiz.init(o); }); }; d.head.insertBefore(j, d.head.firstElementChild); })(window, document, 'script', { host: '//quiz.marquiz.ru', region: 'eu', id: '663a0d6522028a002626bf62', autoOpen: 25, autoOpenFreq: 'once', openOnExit: false, disableOnMobile: false } );
}setTimeout(mquiz10, 10000);
</script>
<? else: ?>
<script>
function mquiz10() {
(function(w, d, s, o){ var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() { if (document.readyState !== 'loading') Marquiz.init(o); else document.addEventListener("DOMContentLoaded", function() { Marquiz.init(o); }); }; d.head.insertBefore(j, d.head.firstElementChild); })(window, document, 'script', { host: '//quiz.marquiz.ru', region: 'eu', id: '61c5e0a186b413003fc46f6d', autoOpen: 25, autoOpenFreq: 'once', openOnExit: false, disableOnMobile: false } );
}setTimeout(mquiz10, 10000);
</script>
<? endif; ?>
<!-- Marquiz script end -->
   
    <?// require_once($analyticCountersPath . '/analitics_top.php'); ?>
    <?if ($USER->IsAdmin()) {?><div id="panel"><?$APPLICATION->ShowPanel();?></div><?}?>
    <?if ( !$isAjax ):?>
 <div id="layout" class="wrapper">
   <?/*?>  
    <div class="covid">
        <div class="container-fluid">
            <div class="row">
                <p><strong>С 1 ноября увеличатся цены</strong> на линзы для очков. Успейте заказать по старым ценам.</p>
            </div>
        </div>
    </div>
<?*/?>
<?if($CITY_NAME=="Санкт-Петербург"){?>
    <? if ($_COOKIE["NEW_SALOON_QUIZ"] != "Y"): ?>
        <div class="covid new_saloon_quiz">
            <div class="row">
                <div><p>Рядом с какой станцией метро вы бы хотели видеть новый салон оптики?</p></div>
                <div><div data-marquiz-id="667042b420caed0026352e51"></div></div>
<script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Button', {id: '667042b420caed0026352e51', buttonText: 'Выбрать', bgColor: '#9971db', textColor: '#fff', rounded: true, blicked: true})</script>
<style>
.new_saloon_quiz {
    display: flex;
}
.new_saloon_quiz .row {
    align-items: center;
    margin: 0 auto;
}
.new_saloon_quiz .row > div {
    margin: 0 2em;
}
.marquiz__container .marquiz__button {
	color: #ffffff;
	background-color: #9971db;
	font-family: "Open Sans", sans-serif;
	font-size: 14px;
	border-radius: 3px;
	border: 2px solid #9971db;
	padding: 5px 21px;
	font-weight: bold;
	transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out, border-color 0.3s ease-in-out;
}
</style>
            </div>
        </div>
        <script>document.cookie = "NEW_SALOON_QUIZ=Y; max-age=86400; path=/;";</script>
    <?endif;?>
<?}?>
<?/*?>
<div class="covid">
    <a href="/contacts/" class="container-fluid">
        <div class="row">
            <p><strong>График работы в новогодние праздники. <span>Подробнее</span> →</strong></p>
        </div>
    </a>
</div>
<?*/?>
               
            <span class="to-top d-none d-xl-flex"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="13" viewbox="0 0 22 13">
                <defs>
                    <path id="wwg8a" d="M250 833l10-10 10 10"></path>
                </defs>
                <g>
                    <g transform="translate(-249 -821)">
                        <use fill="#fff" fill-opacity="0" stroke="#424242" stroke-linecap="round" stroke-miterlimit="50" stroke-width="2" xlink:href="#wwg8a"></use>
                    </g>
                </g>
            </svg></span>
            <div class="overlay"></div>
            <?require_once('include/city_info.php')?>
            <header class="header">
                <?php if (!isset($_COOKIE['headerInfoCollapse'])) {
                    echo getHeaderInfo($_SESSION['GEO_IP']['NAME']);
                } ?>

<div class="navbar-top">
                <div class="navbar-xl-top d-none d-xl-block">
                    <div class="container d-flex justify-content-between">
                        <?include('include/our_salon.php')?>
                        <div class="navbar-xl-top_middle">
                            <?=str_replace('&nbsp;',' ',\PDV\Tools::getPhoneHeader($CITY_ID));?>
                            <?/*?><a href="#callback-modal" class="callback__btn js-callback__btn"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="11"><defs><path id="a" d="M824 27l-.8-.1c-3.3-1.2-6-4-7-7.3a2.5 2.5 0 0 1 .8-2.8l.5-.4a1.7 1.7 0 0 1 2.6.5l1 1.8c.1.5 0 1-.3 1.4l-.2.2a.7.7 0 0 0 0 .7c.3.6.7 1.1 1.3 1.4.3.2.6.1.8 0l.2-.2c.4-.4 1-.5 1.4-.2l1.8.9a1.7 1.7 0 0 1 .4 2.7l-.6.6c-.5.5-1.1.8-1.8.8z"/></defs><use fill="#fff" transform="translate(-816 -16)" xlink:href="#a"/></svg>Заказать звонок</a><?*/?>
                        </div>
                        <div class="navbar-xl-top_right">
                            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"simple", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "simple"
	),
	false
);?>
                        </div>
                    </div>
                </div>
                <div class="navbar-top1">
                    <div class="container d-flex"><a href="#main-menu" class="navbar-top-catalog-btn d-none d-md-flex d-xl-none"><span class="burger"></span>Каталог</a>
                        <div class="navbar-top-panel d-flex justify-content-between">
							<? if(IS_MOBILE): ?>
								<a href="#main-menu" class="catalog-btn-mobile"><div class="burger"></div><span>Меню</span></a>
							<? endif; ?>
                            <a href="/" class="logo">
                                <svg id="svg-logo"><use xlink:href="#chernika-logo"/></svg>
                                <?/*?><img src="<?=SITE_TEMPLATE_PATH?>/img/logo_chernika.svg" alt="Салон оптики «Черника-Оптика»"><?*/?>
                            <?/*if (IS_MOBILE) {?>
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/mobile_logo_chernika.jpg" alt="Салон оптики «Черника-Оптика»">
                            <?} else {?>
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/logo_chernika.svg" alt="Салон оптики «Черника-Оптика»">
                            <?}*/?>
                            </a>
                            <div class="mobile-phone d-md-flex d-xl-none">
							<? if(!IS_MOBILE): ?>
								<?=str_replace('&nbsp;',' ', \PDV\Tools::getPhoneHeader($CITY_ID));?>
							<? else: ?>
								<a href="tel:<?=str_replace('+','',(\PDV\Tools::getPhoneHeaderCustomClearForA($CITY_ID)));?>"><img src="<?=(SITE_TEMPLATE_PATH . "/img/phone_black.svg")?>" width="18" height="18" alt="Телефон"></a>
							<? endif; ?>
							</div>
                            <? if (!IS_MOBILE) {
                                $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top-menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "top",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top-menu",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "top-menu"
	),
	false
);
                            } ?>
                            <a href="javascript:void(0);" class="cities-tablet d-none d-md-block city-tablet" onclick="ESCityShow();">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="19">
                                    <path id="a" transform="translate(-20 -469)" d="M26.5 469a6.78 6.78 0 0 1 6.5 7.02c0 3.88-4.59 11.98-6.5 11.98-1.97 0-6.5-8.1-6.5-11.98a6.78 6.78 0 0 1 6.5-7.02zm0 4.13a2.79 2.79 0 0 0-2.67 2.9 2.79 2.79 0 0 0 2.67 2.88 2.79 2.79 0 0 0 2.67-2.89 2.79 2.79 0 0 0-2.67-2.89z"></path>
                                </svg><span class="badge js-selcity"><?=$CITY_NAME?></span>
                            </a>
                            <?/*?><a href="/favorite/" class="likes d-none d-md-block">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21" height="19" viewbox="0 0 21 19">
                                    <defs>
                                        <path id="kw75a" d="M519.82 23c-1.67 0-3.25.45-4.32 1.73-1.07-1.28-2.65-1.72-4.32-1.73a5.05 5.05 0 0 0-5.18 5.18 7.88 7.88 0 0 0 1.73 4.32c2 2.92 6.87 6.53 7.08 6.68.4.3.96.3 1.37 0 .22-.15 5.09-3.76 7.1-6.68.99-1.23 1.59-2.74 1.72-4.32a5.05 5.05 0 0 0-5.18-5.18z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-505 -22)">
                                            <use fill="#fff" fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="2" xlink:href="#kw75a"></use>
                                        </g>
                                    </g>
                                </svg><span class="badge">(<span class="js-favorites_count"><?=$favoriteCount?></span>)</span>
                            </a><?*/?>

                            <?//if ( !in_array($CITY_NAME, ['Москва','Санкт-Петербург']) ) {?>

                            <div class="search">
                                <div class="opened active">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewbox="0 0 18 18">
                                        <defs>
                                            <path id="_6oh1a" d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                        </defs>
                                        <g>
                                            <g transform="translate(-730 -22)">
                                                <use fill="#202020" xlink:href="#_6oh1a"></use>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="closed">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                                        <defs>
                                            <path id="_lqdxa" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                                        </defs>
                                        <g>
                                            <g transform="translate(-343 -19)">
                                                <use fill="#202020" xlink:href="#_lqdxa"></use>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <?// } ?>
                            <?if ( !$notShowAuth ):?>
                                <a href="<?=($USER->IsAuthorized())?'/personal/':'#login-modal'?>" class="profile<?=($USER->IsAuthorized())?'':' js-profile'?> d-none d-md-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="19" viewbox="0 0 20 19">
                                        <defs>
                                            <path id="fivba" d="M676.82 27.21a4.11 4.11 0 0 1 3.99-4.22c2.2 0 3.99 1.9 3.99 4.23a4.11 4.11 0 0 1-3.99 4.22c-2.2 0-3.99-1.9-3.99-4.22z"></path>
                                            <path id="fivbb" d="M680.96 32.05c-6.24 0-8.35 7.27-8.35 7.27h16.8s-2.22-7.27-8.45-7.27z"></path>
                                        </defs>
                                        <g>
                                            <g transform="translate(-671 -22)">
                                                <use fill="#fff" fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="2" xlink:href="#fivba"></use>
                                            </g>
                                            <g transform="translate(-671 -22)">
                                                <use fill="#fff" fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="2" xlink:href="#fivbb"></use>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            <?endif;?>
                                <a href="/personal/cart/" class="cart d-none d-md-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="18" viewBox="0 0 22 18">
                                        <defs>
                                            <path id="_8498a" d="M587 22h4.41l1.41 3.88H609l-4.53 9.06h-10.35l-4.53-10.35H587z"></path>
                                            <path id="_8498c" d="M602.53 36.24a1.94 1.94 0 1 1 0 3.88 1.94 1.94 0 0 1 0-3.88z"></path>
                                            <path id="_8498d" d="M596.06 36.24a1.94 1.94 0 1 1 0 3.88 1.94 1.94 0 0 1 0-3.88z"></path>
                                            <clipPath id="_8498b">
                                                <use fill="#fff" xlink:href="#_8498a"></use>
                                            </clipPath>
                                        </defs>
                                        <g>
                                            <g transform="translate(-587 -22)">
                                                <use fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#_8498b&quot;)" xlink:href="#_8498a"></use>
                                            </g>
                                            <g transform="translate(-587 -22)">
                                                <use fill="#202020" xlink:href="#_8498c"></use>
                                            </g>
                                            <g transform="translate(-587 -22)">
                                                <use fill="#202020" xlink:href="#_8498d"></use>
                                            </g>
                                        </g>
                                    </svg><span class="badge">(<span class="js-basket_count"><?=$basketData['COUNT']?></span>)</span>
                                </a>
							<? if( IS_MOBILE ): ?>
								<a href="/personal/cart/" class="cart-btn-mobile">
									<img src="<?=(SITE_TEMPLATE_PATH . "/img/cart.svg")?>" width="23" height="18" alt="Корзина">
									<span>Корзина</span><span class="badge"><?=$basketData['COUNT']?></span>
								</a>
							<? endif; ?>
                        </div>
                    </div>
                </div>
                <div class="navbar-top-search">
                    <div class="container">
						<?$APPLICATION->IncludeComponent(
							"arturgolubev:search.title",
							"",
							Array(
								"ANIMATE_HINTS" => array(""),
								"ANIMATE_HINTS_SPEED" => "1",
								"CATEGORY_0" => array("iblock_catalog"),
								"CATEGORY_0_TITLE" => "",
								"CATEGORY_0_iblock_catalog" => array("12","14"),
								"CHECK_DATES" => "N",
								"CONTAINER_ID" => "smart-title-search",
								"CONVERT_CURRENCY" => "Y",
								"CURRENCY_ID" => "RUB",
								"FILTER_NAME" => "",
								"INPUT_ID" => "smart-title-search-input",
								"INPUT_PLACEHOLDER" => "поиск по товарам",
								"NUM_CATEGORIES" => "1",
								"ORDER" => "rank",
								"PAGE" => "#SITE_DIR#search/index.php",
								"PREVIEW_HEIGHT_NEW" => "34",
								"PREVIEW_WIDTH_NEW" => "34",
								"PRICE_CODE" => array("Продажа на сайте"),
								"PRICE_VAT_INCLUDE" => "Y",
								"SHOW_HISTORY" => "N",
								"SHOW_INPUT" => "Y",
								"SHOW_LOADING_ANIMATE" => "Y",
								"SHOW_PREVIEW" => "Y",
								"SHOW_PREVIEW_TEXT" => "N",
								"SHOW_PROPS" => array(""),
								"SHOW_QUANTITY" => "N",
								"TOP_COUNT" => "5",
								"USE_LANGUAGE_GUESS" => "Y"
							)
						);?>
<?/*
                        <form action="/search/">
                            <input type="text" name="q" placeholder="Поиск по сайту">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewbox="0 0 18 18">
                                    <defs>
                                        <path  d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-730 -22)">
                                            <use fill="#202020" xlink:href="#6oh1a"></use>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </form>
*/?>
                    </div>
                </div>
</div><!-- ./navbar-top -->
                <? if (!IS_MOBILE) {
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top-megamenu",
                        [
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "top",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => [""],
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top-menu",
                            "USE_EXT" => "N"
                        ]
                    );
                } ?>
            </header>
<? if ( in_array($CITY_NAME, ['Москва','Санкт-Петербург']) ):?>
<? if ( $isLinzi ):?>
<?
$CITY_NAME = $_SESSION['GEO_IP']['NAME'];
$GLOBALS['arrFilterSlider'] = ['ID' => \PDV\Tools::getLinzSliderIdsByCity($CITY_NAME)];
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "slider-home",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("DETAIL_PICTURE", ""),
        "FILTER_NAME" => "arrFilterSlider",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => IBLOCK_ID__LINZSLIDER,
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "100",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "DESC",
        "STRICT_SECTION_CHECK" => "N",
        "IS_MOBILE" => IS_MOBILE,
        "IS_TABLET" => IS_TABLET,
    )
);?>
<?endif;?>
<?endif;?>
            <? if ( !$isHomePage && !$isCatalog && !$isPodborPage && !$is404 && !$isOutletPage && !$isOutletSunglassesPage):?>
                <?
		$bannerCatalog = \PDV\Tools::getBannerCatalog();
		$bannerCatalogFile = $_SERVER['DOCUMENT_ROOT'].$APPLICATION->GetCurDir()."top_banner.php";
		if(file_exists($bannerCatalogFile))
		{
			$bannerCatalogContent = file_get_contents($bannerCatalogFile);
			if($bannerCatalogContent != "") $bannerCatalog = $bannerCatalogContent;
		}
		$APPLICATION->AddViewContent("ES_WARRANTY", $bannerCatalog);
		$APPLICATION->ShowViewContent("ES_WARRANTY");
                ?>
                <?//=\PDV\Tools::getBannerCatalog();?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    Array(
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "START_FROM" => "0"
                    )
                );?>
                <div<?=\PDV\Tools::getClassPage()?>>
                    <div class="container">
                        <?if(!CSite::InDir("/brands/") && !CSite::InDir("/linzy/")):?>
                        <?if ( $notShowH1 ) :?>
                            <h1 class="page-title "><?=$APPLICATION->ShowTitle(false)?></h1>
                        <?endif;?>
			<?endif;?>
            <?endif;?>
        <?endif;?>