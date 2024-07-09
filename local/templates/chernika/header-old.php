<?
use Bitrix\Main\Page\Asset;
$isHomePage = \PDV\Tools::isHomePage();
$isCatalog = \PDV\Tools::isCatalog();
$is404 = \PDV\Tools::is404();
$notShowH1 = \PDV\Tools::notShowH1();
$favoriteCount = \PDV\Tools::getFavoritesCount();
$basketData = \PDV\Tools::getBasketData();
$notShowAuth = \PDV\Tools::notShowAuth();
$isPodborPage = \PDV\Tools::isPodborPage();
$isAjax = \PDV\Tools::isAjax();
global $USER;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="canonical" href="https://<?=SITE_SERVER_NAME?><?=$APPLICATION->GetCurDir()?>"/>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon-114x114.png">
    <meta name="theme-color" content="#9971db">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-navbutton-color" content="#9971db">
    <meta name="apple-mobile-web-app-status-bar-style" content="#9971db">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/main.min.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/custom.css?v=<?=time()?>">
    <?
    if ( $USER->GetId() != 1) Asset::getInstance()->addJs('//api-maps.yandex.ru/2.1/?lang=ru_RU');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/scripts.min.js?v='.time());
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/custom.js?v='.time());
    ?>
</head>
<body>
<?$APPLICATION->ShowPanel()?>
    <?if ( !$isAjax ):?>
        <div class="wrapper">
            <a href="#" class="to-top d-none d-xl-flex"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="13" viewbox="0 0 22 13">
                <defs>
                    <path id="wwg8a" d="M250 833l10-10 10 10"></path>
                </defs>
                <g>
                    <g transform="translate(-249 -821)">
                        <use fill="#fff" fill-opacity="0" stroke="#424242" stroke-linecap="round" stroke-miterlimit="50" stroke-width="2" xlink:href="#wwg8a"></use>
                    </g>
                </g>
            </svg></a>
            <div class="overlay"></div>
            <?include('include/city_info.php')?>
            <div id="fast-view-modal" class="mfp-hide fast-view-container">
                <div class="modal-header">
                    <button class="mfp-close">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                            <defs>
                                <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                            </defs>
                            <g>
                                <g transform="translate(-343 -19)">
                                    <use fill="#202020" xlink:href="#acpka"></use>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="fast-view js-prod_card"></div>
            </div>
            <header class="header">
            <div class="navbar-xl-top d-none d-xl-block">
                <div class="container d-flex justify-content-between">
                    <?include('include/our_salon.php')?>
                    <div class="navbar-xl-top_middle"><?=\PDV\Tools::getPhoneHeader($CITY_NAME)?></div>
                    <div class="navbar-xl-top_right">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "simple",
                            Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "Y",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "top",
                                "USE_EXT" => "N"
                            )
                        );?>
                    </div>
                </div>
            </div>
            <div class="navbar d-md-none">
                <div class="container d-flex justify-content-between">
                    <a href="#main-menu" class="catalog-btn-mobile"><div class="burger"></div><span>Каталог</span></a>
                    <a href="#city-side" class="city-btn-mobile">
                        <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035              c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719              c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                </g>
                            </g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                        </svg><span>Мой город</span></a>
                    <a href="/favorite/" class="likes-btn-mobile">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="16" viewbox="0 0 18 16">
                            <defs>
                                <path id="5hoqa" d="M320.64 628c-1.4 0-2.74.38-3.64 1.46-.9-1.08-2.23-1.46-3.64-1.46a4.25 4.25 0 0 0-4.36 4.36c.11 1.33.62 2.6 1.46 3.64 1.68 2.46 5.78 5.5 5.96 5.63.34.25.8.25 1.15 0 .19-.13 4.29-3.17 5.97-5.63a6.64 6.64 0 0 0 1.46-3.64 4.25 4.25 0 0 0-4.36-4.36z"></path>
                            </defs>
                            <g>
                                <g transform="translate(-308 -627)">
                                    <use fill="#fff" fill-opacity="0" stroke="#fff" stroke-miterlimit="50" stroke-width="2" xlink:href="#5hoqa"></use>
                                </g>
                            </g>
                        </svg><span>Избранное</span>
                    </a>
                    <?if ( !in_array($CITY_NAME, ['Москва','Санкт-Петербург']) ) {?>
                        <a href="/personal/cart/" class="cart-btn-mobile">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="19" height="17">
                            <defs>
                                <path id="a" d="M313 543h3.81l1.22 3.35H332l-3.91 7.83h-8.94l-3.91-8.94H313z"></path>
                                <path id="c" d="M326.77 555.95a1.68 1.68 0 1 1 0 3.35 1.68 1.68 0 0 1 0-3.35z"></path>
                                <path id="d" d="M320.73 555.95a1.68 1.68 0 1 1 0 3.35 1.68 1.68 0 0 1 0-3.35z"></path>
                                <clippath id="b">
                                    <use fill="#fff" xlink:href="#a"></use>
                                </clippath>
                            </defs>
                            <use fill="#fff" fill-opacity="0" stroke="#fff" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#b&quot;)" xlink:href="#a" transform="translate(-313 -543)"></use>
                            <use fill="#fff" xlink:href="#c" transform="translate(-313 -543)"></use>
                            <use fill="#fff" xlink:href="#d" transform="translate(-313 -543)"></use>
                        </svg><span>Корзина</span><span class="badge"><?=$basketData['COUNT']?></span>
                    </a>
                    <? } ?>
                </div>
            </div>
            <div class="navbar-top">
                <div class="container d-flex"><a href="#main-menu" class="navbar-top-catalog-btn d-none d-md-flex d-xl-none"><span class="burger"></span>Каталог</a>
                    <div class="navbar-top-panel d-flex justify-content-between">
                        <a href="/" class="logo"><img src="<?=SITE_TEMPLATE_PATH?>/img/logo_chernika.svg" alt=""></a>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "top-menu",
                            Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "top",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "Y",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "top-menu",
                                "USE_EXT" => "N"
                            )
                        );?>
                        <a href="#city-modal" class="cities-tablet d-none d-md-block city-tablet">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="19">
                                <path id="a" transform="translate(-20 -469)" d="M26.5 469a6.78 6.78 0 0 1 6.5 7.02c0 3.88-4.59 11.98-6.5 11.98-1.97 0-6.5-8.1-6.5-11.98a6.78 6.78 0 0 1 6.5-7.02zm0 4.13a2.79 2.79 0 0 0-2.67 2.9 2.79 2.79 0 0 0 2.67 2.88 2.79 2.79 0 0 0 2.67-2.89 2.79 2.79 0 0 0-2.67-2.89z"></path>
                            </svg><span class="badge js-selcity"><?=$CITY_NAME?></span>
                        </a>
                        <a href="/favorite/" class="likes d-none d-md-block">
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
                        </a>

                        <?if ( !in_array($CITY_NAME, ['Москва','Санкт-Петербург']) ) {?>
                            <a href="/personal/cart/" class="cart d-none d-md-block">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="18" viewBox="0 0 22 18">
                                    <defs>
                                        <path id="8498a" d="M587 22h4.41l1.41 3.88H609l-4.53 9.06h-10.35l-4.53-10.35H587z"></path>
                                        <path id="8498c" d="M602.53 36.24a1.94 1.94 0 1 1 0 3.88 1.94 1.94 0 0 1 0-3.88z"></path>
                                        <path id="8498d" d="M596.06 36.24a1.94 1.94 0 1 1 0 3.88 1.94 1.94 0 0 1 0-3.88z"></path>
                                        <clipPath id="8498b">
                                            <use fill="#fff" xlink:href="#8498a"></use>
                                        </clipPath>
                                    </defs>
                                    <g>
                                        <g transform="translate(-587 -22)">
                                            <use fill-opacity="0" stroke="#202020" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#8498b&quot;)" xlink:href="#8498a"></use>
                                        </g>
                                        <g transform="translate(-587 -22)">
                                            <use fill="#202020" xlink:href="#8498c"></use>
                                        </g>
                                        <g transform="translate(-587 -22)">
                                            <use fill="#202020" xlink:href="#8498d"></use>
                                        </g>
                                    </g>
                                </svg><span class="badge">(<span class="js-basket_count"><?=$basketData['COUNT']?></span>)</span>
                            </a>
                        <? } ?>

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
                        <a href="#" class="search">
                            <div class="opened active">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewbox="0 0 18 18">
                                    <defs>
                                        <path id="6oh1a" d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-730 -22)">
                                            <use fill="#202020" xlink:href="#6oh1a"></use>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="closed">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                                    <defs>
                                        <path id="lqdxa" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-343 -19)">
                                            <use fill="#202020" xlink:href="#lqdxa"></use>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-top-search">
                <div class="container">
                    <form action="/search/">
                        <input type="text" name="q" placeholder="Поиск по сайту">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewbox="0 0 18 18">
                                <defs>
                                    <path id="6oh1a" d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-730 -22)">
                                        <use fill="#202020" xlink:href="#6oh1a"></use>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "top-megamenu",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "top",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top-menu",
                    "USE_EXT" => "N"
                )
            );?>
        </header>

            <? if ( !$isHomePage && !$isCatalog && !$isPodborPage && !$is404 ):?>
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
                        <?if ( $notShowH1 ) :?>
                            <h1 class="page-title"><?=$APPLICATION->ShowTitle(false)?></h1>
                        <?endif;?>
            <?endif;?>
        <?endif;?>