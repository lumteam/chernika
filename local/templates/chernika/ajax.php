<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Loader,
    \Bitrix\Main\Application,
    \Bitrix\Main\Mail\Event,
    \Bitrix\Main\Web\Cookie,
    \Bitrix\Main\Context;

global $USER, $APPLICATION, $DB;

$request = Application::getInstance()->getContext()->getRequest();

$action = htmlspecialchars($request->get('action'));
$id = intval($request->get('id'));
$count = intval($request->get('count'));
$name = htmlspecialchars($request->get('name'));
$phone = htmlspecialchars($request->get('phone'));
$email = htmlspecialchars($request->get('email'));
$promocode = htmlspecialchars($request->get('promocode'));
$text = htmlspecialchars($request->get('text'));
$type = htmlspecialchars($request->get('type'));
$password = htmlspecialchars($request->get('password'));
$repassword = htmlspecialchars($request->get('repassword'));

if ( $count == 0 )
    $count = 1;

$result = array(
    'data' => array(),
    'error' => false,
    'error_text' => ''
);


//$CITY_NAME = \Bitrix\Main\Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME');
$CITY_NAME = $_SESSION['GEO_IP']['NAME'];
$CITY_ID = $_SESSION['GEO_IP']['ID'];

// if ( in_array($CITY_NAME, ['Москва','Санкт-Петербург']) )
//     define('PRICE_BASE__CODE', 'Продажа на сайте');
// else
//     define('PRICE_BASE__CODE', 'Продажа на сайте ИнтернетМагазин');

// define('PRICE_BASE__CODE', 'Продажа на сайте');

$server = \Bitrix\Main\Context::getCurrent()->getServer();
// require_once($server->getDocumentRoot() . SITE_TEMPLATE_PATH . '/include/price_define.php');

switch ( $action ) {
    case 'searchcity':
        if ( strlen($text) > 2 ) {
            Loader::includeModule('sale');

//            $CITY_ID = Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_ID');

            $result['data']['citylist'] = '';
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'order' => array('NAME_RU' => 'asc'),
                'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY', '?NAME_RU' => $text),
                'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
            ));
            while( $item = $res->fetch() ) {
                if ( $item['ID'] == $CITY_ID ) $cl = ' checked';
                $result['data']['citylist'] .= '<li class="custom'.$cl.'"><a href="#" data-id="'.$item['ID'].'">'.$item['NAME_RU'].'</a></li>';
            }
        }
        break;
//    case 'setcity':
//        if ( $id > 0 && !empty($text) ) {
//            $context = Application::getInstance()->getContext();
//
//            $cookie = new Cookie('SELECT_CITY_ID', $id);
//            $cookie->setDomain(CUSTOM_HTTP_HOST);
//            $cookie->setExpires(0);
//            $cookie->setHttpOnly(false);
//            $context->getResponse()->addCookie($cookie);
//            $context->getResponse()->flush("");
//
//            $cookie = new Cookie('SELECT_CITY_NAME', $text);
//            $cookie->setDomain(CUSTOM_HTTP_HOST);
//            $cookie->setExpires(0);
//            $cookie->setHttpOnly(false);
//            $context->getResponse()->addCookie($cookie);
//            $context->getResponse()->flush("");
//
//            if ( $id > 0 ) {
//                global $USER;
//                $userUpdate = new \CUser;
//                $userUpdate->Update($USER->GetId(), array('PERSONAL_CITY' => $id));
//            }
//
//            $result['data']['text'] = 'OK';
//        }
//        break;
    case 'subscribe':
        if ( !empty($email) ) {
            Loader::includeModule('subscribe');
            $subscr = new CSubscription;

            $resSubscr = CSubscription::GetByEmail($email);
            if ( $aSubscr = $resSubscr->GetNext() )
                $subscr->Update($aSubscr['ID'], array('ACTIVE' => 'Y'));
            else {
                $arFields = Array(
                    'USER_ID' => ($USER->IsAuthorized() ? $USER->GetID() : false),
                    'FORMAT' => 'html',
                    'EMAIL' => $email,
                    'ACTIVE' => 'Y',
                    'RUB_ID' => array(1),
                    'SEND_CONFIRM' => 'N',
                    'CONFIRMED' => 'Y'
                );
                if ( $subscr->Add($arFields) )
                    $result['data']['text'] = 'OK';
            }
        }
        break;
    case 'addreview':
        if ( !empty($email) && !empty($text) ) {
            $model = intval($request->get('model'));
            $quality = intval($request->get('quality'));
            $salon = intval($request->get('salon'));

            if ( $model == 0 )
                $model = '';
            if ( $quality == 0 )
                $quality = '';

            Loader::includeModule('iblock');
            $el = new CIBlockElement;
            if ( $el->Add(array(
                'IBLOCK_ID' => IBLOCK_ID__REVIEWS,
                'ACTIVE' => 'N',
                'ACTIVE_FROM' => date($DB->DateFormatToPHP( CSite::GetDateFormat('SHORT') ), time()),
                'NAME' => (!empty($name))?$name:'Без имени',
                'PREVIEW_TEXT' => $text,
                'PROPERTY_VALUES' => array(
                    'MODEL' => $model,
                    'QUALITY' => $quality,
                    'EMAIL' => $email,
                    'SALON' => $salon
                )
            )) ) {
		if($salon > 0)
		{
			CModule::IncludeModule("iblock");
			$arLink = CIBlockElement::GetList(array("ID"=>"ASC"), array("IBLOCK_ID"=>2,"ID"=>$salon), false, false, array("NAME","PROPERTY_TEL1","PROPERTY_TEL2","PROPERTY_CITY","PROPERTY_ADRESS"))->Fetch();
			$salon = htmlspecialchars($arLink["PROPERTY_ADRESS_VALUE"]);
		}
                Event::send(array(
                    'EVENT_NAME' => 'ADD_REVIEW',
                    'LID' => SITE_ID,
                    'C_FIELDS' => array(
                        'NAME' => $name,
                        'EMAIL' => $email,
                        'TEXT' => $text,
                        'MODEL' => $model,
                        'QUALITY' => $quality,
                        'SALON' => $salon
                    )
                ));
            }
        }
        break;
    case 'profile':
        $fields = array();
        if ( isset($request['NAME']) && isset($request['PERSONAL_PHONE']) && isset($request['EMAIL']) ) {
            $login = $request['LOGIN'];
            if ( empty($login) )
                $login = $request['EMAIL'];

            $fields = array(
                'NAME' => $request['NAME'],
                'PERSONAL_PHONE' => $request['PERSONAL_PHONE'],
                'EMAIL' => $request['EMAIL'],
                'LOGIN' => $login,
            );
        }
        elseif ( isset($request['PASSWORD']) && isset($request['CONFIRM_PASSWORD']) ) {
            $fields = array(
                'PASSWORD' => $request['PASSWORD'],
                'CONFIRM_PASSWORD' => $request['CONFIRM_PASSWORD']
            );
        }
        elseif ( isset($request['PERSONAL_CITY']) && isset($request['PERSONAL_STREET']) && isset($request['PERSONAL_MAILBOX']) ) {
            $city = $request['PERSONAL_CITY'];
            if ( empty($request['PERSONAL_CITY_val']) )
                $city = '';

            $fields = array(
                'PERSONAL_CITY' => $city,
                'PERSONAL_STREET' => $request['PERSONAL_STREET'],
                'PERSONAL_MAILBOX' => $request['PERSONAL_MAILBOX']
            );
        }

        if ( !empty($fields) ) {
            $userUpdate = new CUser;
            if ( $userUpdate->Update($USER->GetId(), $fields) ) {
                if ( $fields['PERSONAL_CITY'] > 0 ) {
                    $context = Application::getInstance()->getContext();

                    $cookie = new Cookie('SELECT_CITY_ID', $fields['PERSONAL_CITY']);
                    $cookie->setDomain(CUSTOM_HTTP_HOST);
                    $cookie->setExpires(0);
                    $cookie->setHttpOnly(false);
                    $context->getResponse()->addCookie($cookie);
                    $context->getResponse()->flush("");

                    Loader::includeModule('sale');
                    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                        'order' => array('NAME_RU' => 'asc'),
                        'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY', 'ID' => $fields['PERSONAL_CITY']),
                        'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
                    ));
                    if ( $item = $res->fetch() ) {
                        $cookie = new Cookie('SELECT_CITY_NAME', $item['NAME_RU']);
                        $cookie->setDomain(CUSTOM_HTTP_HOST);
                        $cookie->setExpires(0);
                        $cookie->setHttpOnly(false);
                        $context->getResponse()->addCookie($cookie);
                        $context->getResponse()->flush("");
                    }
                }

                $result['data']['text'] = 'Данные успешно обновлены';
            }
            else
                $result['data']['text'] = '<span class="text-error">'.$userUpdate->LAST_ERROR.'</span>';
        }
        break;
    case 'recipe_file':
        $fid = CFile::SaveFile($_FILES['file'], 'recipe');
        $userUpdate = new CUser;
        $userUpdate->Update($USER->GetId(), array('UF_RECIPE' => CFile::MakeFileArray($fid)));

        if ( $fid > 0  ) {
            $arr = CFile::GetFileArray($fid);
            $result['data']['text'] = '<div class="js-recipe_file"><a href="'.$arr['SRC'].'" target="_blank">'.$arr['ORIGINAL_NAME'].'</a> <a href="#" class="js-recipe_del">Удалить</a></div>';;
        }

        break;
    case 'recipe_text':
        $userUpdate = new CUser;
        $userUpdate->Update($USER->GetId(), array('UF_RECIPE_TEXT' => $text));
        break;
    case 'getFavAll':
        if (isset($_SESSION['FAVORITES_IDS']) && !empty($_SESSION['FAVORITES_IDS'])) {
            $result['data']['ids'] = $_SESSION['FAVORITES_IDS'];
            $result['data']['favoriteCount'] = count($result['data']['ids']);
        } else {
            Loader::includeModule('iblock');
            Loader::includeModule('sale');
            $result['data'] = [
                'ids' => [],
                'favoriteCount' => 0
            ];
            $idsTemp = [];
            $rsElem = \CIBlockElement::GetList(
                [],
                ['IBLOCK_ID' => IBLOCK_ID__FAVORITES, '=PROPERTY_FUSER_ID' => \CSaleBasket::GetBasketUserID()],
                false,
                false,
                ['PROPERTY_PRODUCT']
            );
            while ($arElem = $rsElem->Fetch()) {
                $result['data']['ids'][] = $arElem['PROPERTY_PRODUCT_VALUE'];
                $result['data']['favoriteCount']++;
            }
        }
//        if ( !empty($idsTemp) ) {
//            $rsElem = \CIBlockElement::GetList(
//                [],
//                ['IBLOCK_ID' => [IBLOCK_ID__CATALOG, IBLOCK_ID__CATALOG_2, IBLOCK_ID__LENSES], 'ACTIVE' => 'Y', 'ID' => $idsTemp],
//                false,
//                false,
//                ['ID']
//            );
//            while ( $arElem = $rsElem->GetNext() ) {
//                $result['data']['ids'][] = $arElem['ID'];
//                $result['data']['favoriteCount']++;
//            }
//        }
//        unset($idsTemp);

        break;
    case 'fav':
        if ($id > 0) {
            Loader::includeModule('iblock');
            Loader::includeModule('sale');

            $result['data']['add'] = false;
            $fuserId = \CSaleBasket::GetBasketUserID();

            $el = new \CIBlockElement;
            $rsElem = \CIBlockElement::GetList(
                [],
                ['IBLOCK_ID' => IBLOCK_ID__FAVORITES, '=PROPERTY_PRODUCT' => $id, '=PROPERTY_FUSER_ID' => $fuserId],
                false,
                ['nTopCount' => 1],
                ['ID']
            );
            if ($arElem = $rsElem->Fetch()) {
                if ($el->Delete($arElem['ID']) && !empty($_SESSION['FAVORITES_IDS'])) {
                    unset($_SESSION['FAVORITES_IDS'][array_search($id, $_SESSION['FAVORITES_IDS'])]);
                }
            } else {
                $elemId = $el->Add([
                    'IBLOCK_ID' => IBLOCK_ID__FAVORITES,
                    'NAME' => $id . '-' . $fuserId,
                    'PROPERTY_VALUES' => [
                        'PRODUCT' => $id,
                        'FUSER_ID' => $fuserId
                    ]
                ]);
                if ($elemId) {
                    $_SESSION['FAVORITES_IDS'][] = $id;

                    $result['data']['add'] = true;
                }
            }
        } else
            $result['error'] = true;

        break;
    case 'quick':
        if ( $id > 0 ):
            Loader::includeModule('iblock');
            $iblock = CIBlockElement::GetIBlockByID($id);

            ob_start();
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.element",
                "quick",
                Array(
                    "ACTION_VARIABLE" => "prod_action",
                    "ADD_DETAIL_TO_SLIDER" => "N",
                    "ADD_ELEMENT_CHAIN" => "N",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => array("BUY"),
                    "ADD_TO_BASKET_ACTION_PRIMARY" => array("BUY"),
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/basket.php",
                    "BRAND_USE" => "N",
                    "BROWSER_TITLE" => "-",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_SECTION_ID_VARIABLE" => "N",
                    "COMPATIBLE_MODE" => "N",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "DETAIL_PICTURE_MODE" => array("POPUP"),
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_NAME" => "N",
                    "DISPLAY_PREVIEW_TEXT_MODE" => "E",
                    "ELEMENT_CODE" => "",
                    "ELEMENT_ID" => $id,
                    "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
                    "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_MESS_BTN_BUY" => "Выбрать",
                    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                    "GIFTS_SHOW_IMAGE" => "Y",
                    "GIFTS_SHOW_NAME" => "Y",
                    "GIFTS_SHOW_OLD_PRICE" => "Y",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
                    "IBLOCK_ID" => $iblock,
                    "IBLOCK_TYPE" => "catalog",
                    "IMAGE_RESOLUTION" => "16by9",
                    "LABEL_PROP" => array(),
                    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                    "LINK_IBLOCK_ID" => "",
                    "LINK_IBLOCK_TYPE" => "",
                    "LINK_PROPERTY_SID" => "",
                    "MAIN_BLOCK_OFFERS_PROPERTY_CODE" => array(),
                    "MAIN_BLOCK_PROPERTY_CODE" => array(),
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_COMMENTS_TAB" => "Комментарии",
                    "MESS_DESCRIPTION_TAB" => "Описание",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "MESS_PRICE_RANGES_TITLE" => "Цены",
                    "MESS_PROPERTIES_TAB" => "Характеристики",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_CART_PROPERTIES" => array("COLOR"),
                    "OFFERS_FIELD_CODE" => array("", ""),
                    "OFFERS_LIMIT" => "0",
                    "OFFERS_PROPERTY_CODE" => array("COLOR", ""),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "OFFER_ADD_PICT_PROP" => "-",
                    "OFFER_TREE_PROPS" => array("COLOR"),
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => PRICE_BASE__CODE,
                        1 => PRICE_MARKET__CODE,
                        2 => PRICE_SPEC_MARKET__CODE,
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRICE_VAT_SHOW_VALUE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
                    "PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
                    "PRODUCT_PROPERTIES" => array(),
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "PROPERTY_CODE" => array("HIT", ''),
                    "SECTION_CODE" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_CANONICAL_URL" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SET_VIEWED_IN_COMPONENT" => "N",
                    "SHOW_404" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DEACTIVATED" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "STRICT_SECTION_CHECK" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_COMMENTS" => "N",
                    "USE_ELEMENT_COUNTER" => "Y",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_GIFTS_DETAIL" => "N",
                    "USE_GIFTS_MAIN_PR_SECTION_LIST" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "USE_RATIO_IN_RANGES" => "N",
                    "USE_VOTE_RATING" => "N",
                    "CITY_NAME" => $CITY_NAME, // \Bitrix\Main\Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME')
                    "CITY_PARAMS" => $_SESSION['GEO_IP'],
                )
            );
            $result['data']['text'] = ob_get_contents();
            ob_end_clean();
        endif;
        break;
    case 'prod_add':
        if ( $id > 0 ) {
            Loader::includeModule('catalog');
            $arProductParams = [];

            $iblock = CIBlockElement::GetIBlockByID($id);
//            if ( in_array($iblock, [IBLOCK_ID__CATALOG_TP,IBLOCK_ID__CATALOG_TP,IBLOCK_ID__CATALOG_2,IBLOCK_ID__CATALOG_TP_2]) ) {
            if ( in_array($iblock, [IBLOCK_ID__CATALOG,IBLOCK_ID__CATALOG_TP,IBLOCK_ID__CATALOG_2,IBLOCK_ID__CATALOG_TP_2,IBLOCK_ID__LENSES,IBLOCK_ID__LENSES_SKU]) ) {
                $color = '';
                $db_props = CIBlockElement::GetProperty(
                    $iblock,
                    $id,
                    array('sort' => 'asc'),
                    array('CODE' => 'COLOR')
                );
                if ( $ar_props = $db_props->GetNext() ) {
                    if ( !empty($ar_props['VALUE']) ) {
                        $colorData = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR, $ar_props['VALUE']);
                        $color = $colorData[ $ar_props['VALUE'] ]['UF_NAME'];
                    }
                }

                if ( !empty($color) )
                    $arProductParams[] = [
                        'NAME' => 'Цвет',
                        'CODE' => 'COLOR',
                        'VALUE' => $color,
                        'SORT' => 100
                    ];
            }

            if ( !empty($type) ) {
                $typeData = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES, $type);
                if ( !empty($typeData[$type]) ) {
                    $arProductParams[] = [
                        'NAME' => 'Длина дужки',
                        'CODE' => 'DUZHKA',
                        'VALUE' => $typeData[$type]['UF_DUZHKA'],
                        'SORT' => 10
                    ];
                    $arProductParams[] = [
                        'NAME' => 'Ширина моста',
                        'CODE' => 'MOST',
                        'VALUE' => $typeData[$type]['UF_MOST'],
                        'SORT' => 10
                    ];
                    $arProductParams[] = [
                        'NAME' => 'Ширина линзы',
                        'CODE' => 'LINZA',
                        'VALUE' => $typeData[$type]['UF_LINZA'],
                        'SORT' => 10
                    ];
                    $arProductParams[] = [
                        'NAME' => 'Высота',
                        'CODE' => 'HEIGHT',
                        'VALUE' => $typeData[$type]['UF_HEIGHT'],
                        'SORT' => 10
                    ];
                }
            }

            Add2BasketByProductID($id, $count, [], $arProductParams);
        }
        else
            $result['error'] = true;

        break;
    case 'prod_remove':
        if ( $id > 0 ) {
            Loader::includeModule('sale');
            if ( !\CSaleBasket::Delete($id) )
                $result['error'] = true;
        }
        else
            $result['error'] = true;

        break;
    case 'prod_change':
        if ( $id > 0 && $count > 0 ) {
            Loader::includeModule('sale');
            \CSaleBasket::Update($id, array('QUANTITY' => $count));
        }
        else
            $result['error'] = true;

        break;
    case 'prood_order':
    case 'prood-order_spb':
        if ( !empty($phone) && $id > 0 ) {
            Loader::includeModule('iblock');
            $rsElem = \CIBlockElement::GetById($id);
            if ( $arElem = $rsElem->GetNext() ) {
                $prodName = $arElem['NAME'];
                if ( !empty($type) ) {
                    $typeData = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES, $type);
                    if ( !empty($typeData[$type]) ) {
                        $prodName .= "<br/>Длина дужки: ".$typeData[$type]['UF_DUZHKA']."<br/>";
                        $prodName .= "Ширина моста: ".$typeData[$type]['UF_MOST']."<br/>";
                        $prodName .= "Ширина линзы: ".$typeData[$type]['UF_LINZA']."<br/>";
                        $prodName .= "Высота: ".$typeData[$type]['UF_HEIGHT'];
                    }
                }

                $utm_content = urldecode($_SESSION['utm_content']);

                $detailPageUrl = \PDV\Tools::getDetailPageUrl([], $arElem['IBLOCK_ID'], $arElem['CODE']);
                $detailPageUrl = current($detailPageUrl);

                $el = new \CIBlockElement;

                if ( $action == 'prood_order_spb' ) {
                    $el->Add([
                        'IBLOCK_ID' => 40,
                        'NAME' => (!empty($name)) ? $name : 'Без имени',
                        'PREVIEW_TEXT' => $text,
                        'DETAIL_TEXT' => '<a href="' . $_SERVER['HTTP_REFERER'] . '">' . $prodName . '</a>',
                        'DETAIL_TEXT_TYPE' => 'html',
                        'PROPERTY_VALUES' => [
                            'PHONE' => $phone,
                            'PROMOCODE' => $promocode
                        ]
                    ]);

                    Event::send(array(
                        'EVENT_NAME' => 'PROD_ORDER_SPB',
                        'LID' => SITE_ID,
                        'C_FIELDS' => array(
                            'NAME' => $name,
                            'PHONE' => $phone,
                            'PROMOCODE' => $promocode,
                            'COMMENT' => $text,
                            'PRODUCT_URL' => '<a href="'.$_SERVER['HTTP_REFERER'].'">'.$prodName.'</a>',
                            'utm_source' => $_SESSION['utm_source'],
                            'utm_medium' => $_SESSION['utm_medium'],
                            'utm_campaign' => $_SESSION['utm_campaign'],
                            'utm_content' => $utm_content,
                            'utm_term' => $_SESSION['utm_term']
                        )
                    ));
                }
                else {
                    $el->Add([
                        'IBLOCK_ID' => 37,
                        'NAME' => (!empty($name))?$name:'Без имени',
                        'PREVIEW_TEXT' => $text,
                        'DETAIL_TEXT' => '<a href="'.$_SERVER['HTTP_REFERER'].'">'.$prodName.'</a>',
                        'DETAIL_TEXT_TYPE' => 'html',
                        'PROPERTY_VALUES' => [
                            'PHONE' => $phone,
                            'PROMOCODE' => $promocode
                        ]
                    ]);


                    Event::send(array(
                        'EVENT_NAME' => 'PROD_ORDER',
                        'LID' => SITE_ID,
                        'C_FIELDS' => array(
                            'NAME' => $name,
                            'PHONE' => $phone,
                            'PROMOCODE' => $promocode,
                            'COMMENT' => $text,
                            'PRODUCT_URL' => '<a href="'.$_SERVER['HTTP_REFERER'].'">'.$prodName.'</a>',
                            'utm_source' => $_SESSION['utm_source'],
                            'utm_medium' => $_SESSION['utm_medium'],
                            'utm_campaign' => $_SESSION['utm_campaign'],
                            'utm_content' => $utm_content,
                            'utm_term' => $_SESSION['utm_term']
                        )
                    ));
                }


               $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "From: info@chernika-optika.ru\r\n";
                $headers .= "Reply-To: info@chernika-optika.ru\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

               $message = "<b>Заявка на товар</b><br/><br/>";
               $message .= "Имя: ".$name."<br/>";
               $message .= "Номер телефона: ".$phone."<br/>";
               $message .= "Email: ".$email."<br/>";
               $message .= "Комментарий: ".$text."<br/>";
               $message .= "Ссылка на товар: <a href='".$_SERVER['HTTP_REFERER']."'>".$prodName."</a><br/><br/>";
               $message .= "<b>UTM</b><br/><br/>";
               $message .= "utm_source: ".$_SESSION['utm_source']."<br/>";
               $message .= "utm_medium: ".$_SESSION['utm_medium']."<br/>";
               $message .= "utm_campaign: ".$_SESSION['utm_campaign']."<br/>";
               $message .= "utm_content: ".$utm_content."<br/>";
               $message .= "utm_term: ".$_SESSION['utm_term']."<br/>";

               mail('leads+chernika@idclient.ru','chernika-optika',$message, $headers);

               //$hostname = '185.105.226.25';
               //$username = 'idclient_leads_usr';
               //$password = 's9c79Hgxyvn5Ec7k';
               //$dbName = 'idclient_leads';
               	$hostname = '5.188.28.75';
				$username = 'leads_chern_usr';
    			$password = 'tEZDAdWoHg92Jq7x';
    			$dbName   = 'leads_chernikaoptika';
                // Подключение к БД.
               $mysqli = new mysqli($hostname, $username, $password);
               $mysqli->query("SET NAMES 'utf8';");
               $mysqli->query("SET CHARACTER SET 'utf8';");
               $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");
               $mysqli->select_db($dbName);

               $t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
                  VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

                  $page = SITE_SERVER_NAME.$detailPageUrl;
                  $date_today = date("Y-m-d");
                  $time = date("H:i:s");

                $query = sprintf($t, $date_today, $time, $page, $_SESSION['utm_source'], $_SESSION['utm_medium'], $_SESSION['utm_campaign'], $utm_content, $_SESSION['utm_term'], $name, $phone, $email, $text, 'Оформление заказа. попап', $referer, $freferer, "_".$clientID);


                $result = $mysqli->query($query);
            }

        }
        break;
    case 'prood_preorder':
    if ( !empty($phone) && $id > 0 ) {
            Loader::includeModule('iblock');
            $rsElem = \CIBlockElement::GetById($id);
            if ( $arElem = $rsElem->GetNext() ) {
                $prodName = $arElem['NAME'];
                if ( !empty($type) ) {
                    $typeData = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES, $type);
                    if ( !empty($typeData[$type]) ) {
                        $prodName .= "<br/>Длина дужки: ".$typeData[$type]['UF_DUZHKA']."<br/>";
                        $prodName .= "Ширина моста: ".$typeData[$type]['UF_MOST']."<br/>";
                        $prodName .= "Ширина линзы: ".$typeData[$type]['UF_LINZA']."<br/>";
                        $prodName .= "Высота: ".$typeData[$type]['UF_HEIGHT'];
                    }
                }

                $utm_content = urldecode($_SESSION['utm_content']);
                $detailPageUrl = \PDV\Tools::getDetailPageUrl([], $arElem['IBLOCK_ID'], $arElem['CODE']);
                $detailPageUrl = current($detailPageUrl);

                $IBLOCK_ID = 38;
                if ( $action == 'prod_orderprice')
                    $IBLOCK_ID = 39;

                $el = new \CIBlockElement;
                $el->Add([
                    'IBLOCK_ID' => $IBLOCK_ID,
                    'NAME' => (!empty($name))?$name:'Без имени',
                    'PREVIEW_TEXT' => $text,
                    'DETAIL_TEXT' => '<a href="http://'.SITE_SERVER_NAME.$detailPageUrl.'">'.$prodName.'</a>',
                    'DETAIL_TEXT_TYPE' => 'html',
                    'PROPERTY_VALUES' => [
                        'PHONE' => $phone,
                        'EMAIL' => $email
                    ]
                ]);

                $EVENT_NAME = 'PROD_PREORDER';
                if ( $action == 'prod_orderprice')
                    $EVENT_NAME = 'PROD_ORDERPRICE';

                Event::send(array(
                    'EVENT_NAME' => $EVENT_NAME,
                    'LID' => SITE_ID,
                    'C_FIELDS' => array(
                        'NAME' => $name,
                        'PHONE' => $phone,
                        'EMAIL' => $email,
                        'COMMENT' => $text,
                        'referer' => $referer,
                        'freferer' => $freferer,
                        'clientID' => $clientID,
                        'PRODUCT_URL' => '<a href="http://'.SITE_SERVER_NAME.$detailPageUrl.'">'.$prodName.'</a>'
                    )
                ));

               $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "From: info@chernika-optika.ru\r\n";
                $headers .= "Reply-To: info@chernika-optika.ru\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

               $message = "<b>Предзаказ на товар</b><br/><br/>";
               if ( $action == 'prod_orderprice')
                   $message = "<b>Запрос цены на товар</b><br/><br/>";

               $message .= "Имя: ".$name."<br/>";
               $message .= "Номер телефона: ".$phone."<br/>";
               $message .= "Email: ".$email."<br/>";
               $message .= "Комментарий: ".$text."<br/>";
               $message .= "Ссылка на товар: <a href='http://".SITE_SERVER_NAME.$detailPageUrl."'>".$prodName."</a><br/><br/>";
               $message .= "<b>UTM</b><br/><br/>";
               $message .= "utm_source: ".$_SESSION['utm_source']."<br/>";
               $message .= "utm_medium: ".$_SESSION['utm_medium']."<br/>";
               $message .= "utm_campaign: ".$_SESSION['utm_campaign']."<br/>";
               $message .= "utm_content: ".$utm_content."<br/>";
               $message .= "utm_term: ".$_SESSION['utm_term']."<br/>";

               mail('leads+chernika@idclient.ru','chernika-optika',$message, $headers);

               //$hostname = '185.105.226.25';
               //$username = 'idclient_leads_usr';
               //$password = 's9c79Hgxyvn5Ec7k';
               //$dbName = 'idclient_leads';
               	$hostname = '5.188.28.75';
				$username = 'leads_chern_usr';
    			$password = 'tEZDAdWoHg92Jq7x';
    			$dbName   = 'leads_chernikaoptika';
               // Подключение к БД.
               $mysqli = new mysqli($hostname, $username, $password);
               $mysqli->query("SET NAMES 'utf8';");
               $mysqli->query("SET CHARACTER SET 'utf8';");
               $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");
               $mysqli->select_db($dbName);

               $t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
                  VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

                  $page = SITE_SERVER_NAME.$detailPageUrl;
                  $date_today = date("Y-m-d");
                  $time = date("H:i:s");;

                $query = sprintf($t, $date_today, $time, $page, $_SESSION['utm_source'], $_SESSION['utm_medium'], $_SESSION['utm_campaign'], $utm_content, $_SESSION['utm_term'], $name, $phone, $email, $text, 'Предзаказ', $referer, $freferer, "_".$clientID);
               $result = $mysqli->query($query);
            }

        }
        break;
    case 'prod_orderprice':
        if ( !empty($phone) && $id > 0 ) {
            Loader::includeModule('iblock');
            $rsElem = \CIBlockElement::GetById($id);
            if ( $arElem = $rsElem->GetNext() ) {
                $prodName = $arElem['NAME'];
                if ( !empty($type) ) {
                    $typeData = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SIZES, $type);
                    if ( !empty($typeData[$type]) ) {
                        $prodName .= "<br/>Длина дужки: ".$typeData[$type]['UF_DUZHKA']."<br/>";
                        $prodName .= "Ширина моста: ".$typeData[$type]['UF_MOST']."<br/>";
                        $prodName .= "Ширина линзы: ".$typeData[$type]['UF_LINZA']."<br/>";
                        $prodName .= "Высота: ".$typeData[$type]['UF_HEIGHT'];
                    }
                }

                $utm_content = urldecode($_SESSION['utm_content']);
                $detailPageUrl = \PDV\Tools::getDetailPageUrl([], $arElem['IBLOCK_ID'], $arElem['CODE']);
                $detailPageUrl = current($detailPageUrl);

                $IBLOCK_ID = 38;
                if ( $action == 'prod_orderprice')
                    $IBLOCK_ID = 39;

                $el = new \CIBlockElement;
                $el->Add([
                    'IBLOCK_ID' => $IBLOCK_ID,
                    'NAME' => (!empty($name))?$name:'Без имени',
                    'PREVIEW_TEXT' => $text,
                    'DETAIL_TEXT' => '<a href="http://'.SITE_SERVER_NAME.$detailPageUrl.'">'.$prodName.'</a>',
                    'DETAIL_TEXT_TYPE' => 'html',
                    'PROPERTY_VALUES' => [
                        'PHONE' => $phone,
                        'EMAIL' => $email
                    ]
                ]);

                $EVENT_NAME = 'PROD_PREORDER';
                if ( $action == 'prod_orderprice')
                    $EVENT_NAME = 'PROD_ORDERPRICE';

                Event::send(array(
                    'EVENT_NAME' => $EVENT_NAME,
                    'LID' => SITE_ID,
                    'C_FIELDS' => array(
                        'NAME' => $name,
                        'PHONE' => $phone,
                        'EMAIL' => $email,
                        'COMMENT' => $text,
                        'referer' => $referer,
                        'freferer' => $freferer,
                        'clientID' => $clientID,
                        'PRODUCT_URL' => '<a href="http://'.SITE_SERVER_NAME.$detailPageUrl.'">'.$prodName.'</a>'
                    )
                ));

               $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "From: info@chernika-optika.ru\r\n";
                $headers .= "Reply-To: info@chernika-optika.ru\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

               $message = "<b>Уточнить стоимость</b><br/><br/>";
               if ( $action == 'prod_orderprice')
                   $message = "<b>Запрос цены на товар</b><br/><br/>";

               $message .= "Имя: ".$name."<br/>";
               $message .= "Номер телефона: ".$phone."<br/>";
               $message .= "Email: ".$email."<br/>";
               $message .= "Комментарий: ".$text."<br/>";
               $message .= "Ссылка на товар: <a href='http://".SITE_SERVER_NAME.$detailPageUrl."'>".$prodName."</a><br/><br/>";
               $message .= "<b>UTM</b><br/><br/>";
               $message .= "utm_source: ".$_SESSION['utm_source']."<br/>";
               $message .= "utm_medium: ".$_SESSION['utm_medium']."<br/>";
               $message .= "utm_campaign: ".$_SESSION['utm_campaign']."<br/>";
               $message .= "utm_content: ".$utm_content."<br/>";
               $message .= "utm_term: ".$_SESSION['utm_term']."<br/>";

               mail('leads+chernika@idclient.ru','chernika-optika',$message, $headers);


//Energo-soft 2023 - Report
$es_source = "Уточнить стоимость ".date('Y-m-d H:i:s');
$es_description = "Товар:".$prodName;
$es_contact = "Имя:".$name." Email:".$email;
$es_phone=$phone;

$queryParams = [
    'source' => $es_source,
    'description' => $es_description,
    'contact' => $es_contact,
    'phone' => $es_phone,
];
$queryUrl ='https://script.google.com/macros/s/AKfycbwhhgMKf6rFpOrWkt40Nvq5vPjOS54cW9RbgpoONiLbfvWwz4I-MJUHMPwzSFZ599yR/exec?';

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_POST => 1,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_ENCODING => 0,
  CURLOPT_URL => $queryUrl,
  CURLOPT_POSTFIELDS =>$queryParams,
));
$result = curl_exec($curl);
curl_close($curl);
//---end-----

               //$hostname = '185.105.226.25';
               //$username = 'idclient_leads_usr';
               //$password = 's9c79Hgxyvn5Ec7k';
               //$dbName = 'idclient_leads';
               	$hostname = '5.188.28.75';
				$username = 'leads_chern_usr';
    			$password = 'tEZDAdWoHg92Jq7x';
    			$dbName   = 'leads_chernikaoptika';
               // Подключение к БД.
               $mysqli = new mysqli($hostname, $username, $password);
               $mysqli->query("SET NAMES 'utf8';");
               $mysqli->query("SET CHARACTER SET 'utf8';");
               $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");
               $mysqli->select_db($dbName);

               $t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
                  VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

                  $page = SITE_SERVER_NAME.$detailPageUrl;
                  $date_today = date("Y-m-d");
                  $time = date("H:i:s");;

                $query = sprintf($t, $date_today, $time, $page, $_SESSION['utm_source'], $_SESSION['utm_medium'], $_SESSION['utm_campaign'], $utm_content, $_SESSION['utm_term'], $name, $phone, $email, $text, 'Уточнить стоимость', $referer, $freferer, "_".$clientID);
               $result = $mysqli->query($query);


            }

        }
        break;
    case 'reg':
        if ( !empty($name) && !empty($email) && !empty($password) && !empty($repassword)) {
            global $USER;

            $GROUP_ID = array();
            $def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
            if($def_group != "")
                $GROUP_ID = explode(",", $def_group);

            $ID = 0;
            $user = new CUser();
            $arResult['VALUES'] = array(
                'ACTIVE' => 'Y',
                'LID' => SITE_ID,
                'NAME' => $name,
                'LOGIN' => $email,
                'EMAIL' => $email,
                'PASSWORD' => $password,
                'CONFIRM_PASSWORD' => $repassword,
                'GROUP_ID' => $GROUP_ID,
                'CHECKWORD' => md5(CMain::GetServerUniqID().uniqid()),
                'CONFIRM_CODE' => randString(8),
                'LANGUAGE_ID' => LANGUAGE_ID,
                'USER_IP' => $_SERVER["REMOTE_ADDR"],
                'USER_HOST' => @gethostbyaddr($_SERVER["REMOTE_ADDR"])
            );
            $ID = $user->Add($arResult['VALUES']);

            if ( intval($ID) == 0 ) {
                $result['error'] = true;
                $errText = explode('<br>', $user->LAST_ERROR);
                foreach ( $errText as $key => $t ) {
                    if ( stripos($t, 'логин') !== false )
                        unset($errText[$key]);
                }
                $result['error_text'] = implode('<br/>', $errText);
            }
            else {
                $USER->Login($email, $password);

                $arEventFields = $arResult['VALUES'];
                $event = new CEvent;
                $event->SendImmediate("NEW_USER", SITE_ID, $arEventFields);
                $event->SendImmediate("USER_INFO", SITE_ID, $arEventFields);
            }
        }
        else
            $result['error'] = true;

        break;
}

if ( stripos($action, 'prod_') !== false ) {
    $result['data']['basketData'] = \PDV\Tools::getBasketData();
}

$result['data']['basketData']['basket'] = '';
if ( stripos($action, 'prod_') !== false && $action != 'prod_add' ) {
    ob_start();
    $APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "cart", Array(
        "ACTION_VARIABLE" => "basketAction",    // Название переменной действия
        "ADDITIONAL_PICT_PROP_7" => "-",    // Дополнительная картинка [Каталог товаров 4AA13DEC]
        "ADDITIONAL_PICT_PROP_9" => "-",    // Дополнительная картинка [Пакет предложений (Основной каталог товаров)]
        "AUTO_CALCULATION" => "Y",    // Автопересчет корзины
        "BASKET_IMAGES_SCALING" => "adaptive",    // Режим отображения изображений товаров
        "COLUMNS_LIST_EXT" => array(    // Выводимые колонки
            0 => "PREVIEW_PICTURE",
            1 => "DISCOUNT",
            2 => "DELETE",
            3 => "SUM",
        ),
        "COLUMNS_LIST_MOBILE" => array(    // Колонки, отображаемые на мобильных устройствах
            0 => "PREVIEW_PICTURE",
            1 => "DISCOUNT",
            2 => "DELETE",
            3 => "SUM",
        ),
        "COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
        "CORRECT_RATIO" => "Y",    // Автоматически рассчитывать количество товара кратное коэффициенту
        "DEFERRED_REFRESH" => "N",    // Использовать механизм отложенной актуализации данных товаров с провайдером
        "DISCOUNT_PERCENT_POSITION" => "bottom-right",
        "DISPLAY_MODE" => "extended",    // Режим отображения корзины
        "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
        "GIFTS_CONVERT_CURRENCY" => "N",
        "GIFTS_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_HIDE_NOT_AVAILABLE" => "N",
        "GIFTS_MESS_BTN_BUY" => "Выбрать",
        "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
        "GIFTS_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_PLACE" => "BOTTOM",
        "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
        "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
        "GIFTS_SHOW_IMAGE" => "Y",
        "GIFTS_SHOW_NAME" => "Y",
        "GIFTS_SHOW_OLD_PRICE" => "N",
        "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
        "HIDE_COUPON" => "N",    // Спрятать поле ввода купона
        "LABEL_PROP" => "",    // Свойства меток товара
        "LABEL_PROP_MOBILE" => "",
        "LABEL_PROP_POSITION" => "",
        "OFFERS_PROPS" => "",    // Свойства, влияющие на пересчет корзины
        "PATH_TO_ORDER" => "/personal/order/make/",    // Страница оформления заказа
        "PRICE_DISPLAY_MODE" => "Y",    // Отображать цену в отдельной колонке
        "PRICE_VAT_SHOW_VALUE" => "N",    // Отображать значение НДС
        "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",    // Порядок отображения блоков товара
        "QUANTITY_FLOAT" => "N",    // Использовать дробное значение количества
        "SET_TITLE" => "N",    // Устанавливать заголовок страницы
        "SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки рядом с изображением
        "SHOW_FILTER" => "N",    // Отображать фильтр товаров
        "SHOW_RESTORE" => "N",    // Разрешить восстановление удалённых товаров
        "TEMPLATE_THEME" => "blue",    // Цветовая тема
        "TOTAL_BLOCK_DISPLAY" => array(    // Отображение блока с общей информацией по корзине
            0 => "bottom",
        ),
        "USE_DYNAMIC_SCROLL" => "Y",    // Использовать динамическую подгрузку товаров
        "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
        "USE_GIFTS" => "N",    // Показывать блок "Подарки"
        "USE_PREPAYMENT" => "N",    // Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
        "USE_PRICE_ANIMATION" => "N",    // Использовать анимацию цен
    ),
        false
    );
    $result['data']['basketData']['basket'] = ob_get_contents();
    ob_end_clean();
}

echo json_encode($result);
?>
