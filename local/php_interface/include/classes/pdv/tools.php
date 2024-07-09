<?php
namespace PDV;

use \Bitrix\Main\Loader,
    \Bitrix\Main\Data\Cache,
    \Bitrix\Highloadblock as HL,
    \Bitrix\Main\Service\GeoIp,
    \Bitrix\Main\Context,
    \Bitrix\Main\Application;


class Tools {
    public static function getBrands()
    {
        $arResult = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = IBLOCK_ID__BRAND;
        $cachePath = '/getBrands/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arResult = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $dbResult = \CIBlockElement::GetList(
                [
                    'NAME' => 'ASC'
                ],
                [
                    'IBLOCK_ID' => IBLOCK_ID__BRAND
                ],
                false,
                false,
                [
                    'ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_NOT_SHOW_PRICE'
                ]
            );
            while ($arBrands = $dbResult->Fetch()) {
                $arResult[$arBrands['ID']] = $arBrands;
            }

            $obCache->EndDataCache($arResult);
        }

        return $arResult;
    }

    public static function getSubDomain($subDomain = '')
    {
        $subDomain = trim($subDomain, '.');
        if (!empty($subDomain)) {
            $subDomain .= '.';
        }

        return $subDomain;
    }
    public static function setDomain()
    {
        $subDomain = $_SESSION['GEO_IP']['SUB_DOMAIN'] ?? '';

        if (SUB_DOMAIN != $subDomain) {
            $subDomain = trim($subDomain, '.');
            if (!empty($subDomain)) {
                $subDomain .= '.';
            }
            LocalRedirect(PROTOCOL . $subDomain . CUSTOM_HTTP_HOST . CURRENT_DIR);
        }
    }

    public static function isHomePage(){
        global $APPLICATION;

        if ( $APPLICATION->GetCurPage(true) == '/index.php' )
            return true;
        else
            return false;
    }

    public static function is404() {
        global $APPLICATION;

        if ( defined('ERROR_404') )
            return true;
        else
            return $APPLICATION->GetCurPage() == SITE_DIR . '404.php';
    }

    public static function isCatalog() {
        global $APPLICATION;

        $arr = explode('/', $APPLICATION->GetCurDir());
        if ( in_array($arr[1], ['eyeglass-frames','sunglasses','sports-glasses','lenses',
                                'vision-glasses', 'progressive-glasses', 'multifocal-glasses', 'photochromic-glasses']) )
            return true;
        else
            return false;
    }

    public static function isPodborPage() {
        if ( \CSite::InDir('/podbor/') )
            return true;
        else
            return false;
    }

    public static function isOutletPage() {
        if ( \CSite::InDir('/outlet/') )
            return true;
        else
            return false;
    }

    public static function isOutletSunglassesPage() {
        if ( \CSite::InDir('/outlet-sunglasses/') )
            return true;
        else
            return false;
    }

    public static function isLensesCatalog() {
        if ( \CSite::InDir('/lenses/') )
            return true;
        else
            return false;
    }

    public static function isLinziPage() {
        if ( \CSite::InDir('/linzy/index.php') )
            return true;
        else
            return false;
    }

    public static function getClassPage(){
        global $APPLICATION;

        $cl = '';
        if ( $APPLICATION->GetCurPage() == '/certificates/' )
            $cl = 'certificates-page';
        elseif ( $APPLICATION->GetCurPage() == '/reviews/' )
            $cl = 'feedbacks-page';
        elseif ( $APPLICATION->GetCurPage() == '/reviews/' )
            $cl = 'sales-page';
        elseif ( $APPLICATION->GetCurPage() == '/personal/cart/' )
            $cl = 'page-cart';
        elseif ( $APPLICATION->GetCurPage() == '/contacts/' )
            $cl = 'contacts__section';

        return (!empty($cl))?' class="'.$cl.'"':'';
    }

    public static function notShowH1(){
        global $APPLICATION;
        $countSect = count(explode('/', $APPLICATION->GetCurPage()));

        if (
            ( \CSite::InDir('/articles/') && $countSect == 4 ) ||
            ( \CSite::InDir('/action/') && $countSect == 4 ) ||
            $APPLICATION->GetCurPage() == '/personal/' ||
            $APPLICATION->GetCurPage() == '/personal/edit/' ||
            $APPLICATION->GetCurPage() == '/personal/edit-address/' ||
            $APPLICATION->GetCurPage() == '/personal/password/' ||
            $APPLICATION->GetCurPage() == '/personal/order/' ||
            $APPLICATION->GetCurPage() == '/contacts/' ||
            $APPLICATION->GetCurPage() == '/podbor/' ||
            \CSite::Indir('/favorite/')
        )
            return false;
        else
            return true;
    }

    //Склонение слов
    public static function Declension ($digit, $expr, $onlyword = false) {
        if (!is_array ( $expr )) {
            $expr = array_filter ( explode ( ' ',
                    $expr
                )
            );
        }
        if (empty ($expr [2])) {
            $expr [2] = $expr [1];
        }
        $i = preg_replace ( '/[^0-9]+/s',
                '',
                $digit
            ) % 100;
        if ($onlyword) {
            $digit = '';
        }
        if ($i >= 5 && $i <= 20) {
            $res = $digit.' '.$expr [2];
        } else {
            $i %= 10;
            if ($i == 1) {
                $res = $digit.' '.$expr [0];
            } elseif ($i >= 2 && $i <= 4) {
                $res = $digit.' '.$expr [1];
            } else {
                $res = $digit.' '.$expr [2];
            }
        }
        return trim ( $res );
    }

    public static function getFavorites()
    {
        if (isset($_SESSION['FAVORITES_IDS']) && !empty($_SESSION['FAVORITES_IDS'])) {
            $idsTemp = $_SESSION['FAVORITES_IDS'];
        } else {
            Loader::includeModule('iblock');
            Loader::includeModule('sale');

            $idsTemp = [];
            $rsElem = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => IBLOCK_ID__FAVORITES,
                    'ACTIVE' => 'Y',
                    '=PROPERTY_FUSER_ID' => \CSaleBasket::GetBasketUserID()
                ],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_PRODUCT']
            );
            while ($arElem = $rsElem->Fetch()) {
                $idsTemp[] = $arElem['PROPERTY_PRODUCT_VALUE'];
                $_SESSION['FAVORITES_IDS'] = $idsTemp;
            }
        }

        return $idsTemp;
    }

    public static function getFavoritesCount(){
        return count(self::getFavorites());
    }

    public static function getOrderCount(){
        global $USER;
        Loader::includeModule('sale');

        $dbOrderList = \Bitrix\Sale\Internals\OrderTable::getList(array(
            'order' => array('ID' => 'DESC'),
            'filter' => array('USER_ID' => $USER->GetId()),
            'select' => array('ID')
        ));
        return $dbOrderList->getSelectedRowsCount();
    }

    public static function getBasketData(){
        Loader::includeModule('sale');

        $result = array(
            'COUNT' => 0,
            'PRICE' => 0
        );
        $dbBasketItems = \CSaleBasket::GetList(
            array(
                'ID' => 'ASC'
            ),
            array(
                'FUSER_ID' => \CSaleBasket::GetBasketUserID(),
                'LID' => SITE_ID,
                'ORDER_ID' => 'NULL',
                'CAN_BUY' => 'Y',
                'DELAY' => 'N'
            ),
            false,
            false,
            array('QUANTITY', 'PRICE')
        );
        while ( $arItems = $dbBasketItems->Fetch() )
        {
            $result['COUNT'] += $arItems['QUANTITY'];
            //$result['PRICE'] += $arItems['QUANTITY'] * $arItems['PRICE'];
        }

        return $result;
    }

    public function getAllSaloons($CITY_NAME = '')
    {
        $result = $arSalons = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = serialize(IBLOCK_ID__SALON . $CITY_NAME);
        $cachePath = '/getAllSaloons/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arSalons = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__SALON, 'ACTIVE' => 'Y'],
                false,
                false,
                ['NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PROPERTY_MAP', 'PROPERTY_ICON', 'PROPERTY_CITY', 'PROPERTY_METRO', 'PROPERTY_COMMENT', 'PROPERTY_DOPTEXT', 'PROPERTY_CARD_TEXT', 'PROPERTY_BRAND_LIST_CARD']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arSalons[] = $arElem;
            }
            unset($arElem);

            $obCache->EndDataCache($arSalons);
        }

        if (!empty($arSalons)) {
            $arr = $arrTmp = [];
            foreach ($arSalons as $arElem) {
                if ($arElem['PROPERTY_CITY_VALUE'] == $CITY_NAME)
                    $arr[] = $arElem;
                else
                    $arrTmp[] = $arElem;
            }

            $result = $arr;
            if (empty($arr)) {
                $result = array_merge($arr, $arrTmp);
            }
        }

        return $result;
    }

    public function getSaloon($CITY_NAME = '')
    {
        $result = [];

        if (!empty($CITY_NAME)) {
            $obCache = new \CPHPCache();
            $cacheLifetime = CHACHE_LIFE_TIME;
            $cacheID = serialize(IBLOCK_ID__SALON . $CITY_NAME);
            $cachePath = '/getSaloon/' . $cacheID;

            if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                $result = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                Loader::includeModule('iblock');

                $rsElem = \CIBlockElement::GetList(
                    ['sort' => 'asc', 'id' => 'desc'],
                    ['IBLOCK_ID' => IBLOCK_ID__SALON, 'ACTIVE' => 'Y', '=PROPERTY_CITY' => $CITY_NAME],
                    false,
                    false,
                    ['NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PROPERTY_MAP', 'PROPERTY_ICON', 'PROPERTY_METRO', 'PROPERTY_COMMENT', 'PROPERTY_DOPTEXT', 'PROPERTY_CARD_TEXT', 'PROPERTY_BRAND_LIST_CARD']
                );
                while ($arElem = $rsElem->Fetch()) {
                    $result[] = $arElem;
                }

                $obCache->EndDataCache($result);
            }
        }

        return $result;
    }

    public static function getAllPictureIds($id, $arData = [], $type = '')
    {
        $result = [];

        if ($id > 0) {
            $obCache = new \CPHPCache();
            $cacheLifetime = CHACHE_LIFE_TIME;
            $cacheID = serialize($id . $type);
            $cachePath = '/getAllPictureIds/' . $cacheID;

            if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                $result = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                Loader::includeModule('iblock');

                $iblockId = \CIBlockElement::GetIBlockByID($id);

                $rsElem = \CIBlockElement::GetList(
                    [],
                    ['IBLOCK_ID' => $iblockId, '=ID' => $id],
                    false,
                    ['nTopCount' => 1],
                    ['IBLOCK_ID', 'ID', 'DETAIL_PICTURE', 'PREVIEW_PICTURE', 'PROPERTY_MORE_PHOTO']
                );
                if ($arElemObj = $rsElem->GetNextElement()) {
                    $arElem = $arElemObj->GetFields();
                    $arProp = $arElemObj->GetProperties();

                    if ($type == 'detail') {
                        if (!empty($arElem['DETAIL_PICTURE']))
                            $result[] = $arElem['DETAIL_PICTURE'];
                        elseif (!empty($arElem['PREVIEW_PICTURE']))
                            $result[] = $arElem['PREVIEW_PICTURE'];
                    } else {
                        if (!empty($arElem['PREVIEW_PICTURE']))
                            $result[] = $arElem['PREVIEW_PICTURE'];
                        if (!empty($arElem['DETAIL_PICTURE']))
                            $result[] = $arElem['DETAIL_PICTURE'];
                    }

                    foreach ($arProp['MORE_PHOTO']['VALUE'] as $pic) {
                        $result[] = $pic;
                    }
                }

                $obCache->EndDataCache($result);
            }
        }

        return $result;
    }

    public static function getPreviewPictureIds($id, $arData = [])
    {
        $arr = self::getAllPictureIds($id, $arData);

        if (!empty($arr))
            return $arr[0];
        else
            return false;
    }

    public static function getPreviewPicture($id, $arData = [])
    {
        $pic = self::getPreviewPictureIds($id, $arData);
        if ($pic) {
            $resizeImg = \CFile::ResizeImageGet($pic, ['width' => 600, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
            return $resizeImg['src'];
        } else
            return SITE_TEMPLATE_PATH . '/img/no_photo.png';
    }

    public static function getPreviewPictureEx($id, $arData = [])
    {
        $pic = self::getPreviewPictureIds($id, $arData);
        if ($pic) {
            $resizeImg = \CFile::ResizeImageGet($pic, ['width' => 600, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $resizeImg = array(
                'SRC' => $resizeImg['src'],
                'WIDTH' => $resizeImg['width'],
                'HEIGHT' => $resizeImg['height'],
            );
            return $resizeImg;
        } else
            return array(
                'SRC' => SITE_TEMPLATE_PATH . '/img/no_photo.png',
                'WIDTH' => 150,
                'HEIGHT' => 150,
            );
    }

    public static function getArticleProduct($id)
    {
        if ($id > 0) {
            $result = '';

            $obCache = new \CPHPCache();
            $cacheLifetime = CHACHE_LIFE_TIME;
            $cacheID = $id;
            $cachePath = '/getArticleProduct/' . $cacheID;

            if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                $result = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                $db_props = \CIBlockElement::GetProperty(
                    \CIBlockElement::GetIBlockByID($id),
                    $id,
                    ['sort' => 'asc'],
                    ['CODE' => 'CML2_ARTICLE']
                );
                if ($ar_props = $db_props->Fetch()) {
                    $result = $ar_props['VALUE'];
                }

                $obCache->EndDataCache($result);
            }

            return $result;
        } else
            return false;
    }

    public static function getHighloadBlockData($idBlock = 0, $xmlIds = [], $ids = [], $table_name = '')
    {
        $result = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = serialize([$idBlock, $xmlIds, $ids, $table_name]);
        $cachePath = '/getHighloadBlockData/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $result = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('highloadblock');

            if ($idBlock > 0)
                $hlblock = HL\HighloadBlockTable::getById($idBlock)->fetch();
            elseif (!empty($table_name))
                $hlblock = HL\HighloadBlockTable::getList(['filter' => ['TABLE_NAME' => $table_name]])->fetch();

            $hlentity = HL\HighloadBlockTable::compileEntity($hlblock);
            $strEntityDataClass = $hlentity->getDataClass();

            $filter = [];
            if ($xmlIds)
                $filter['UF_XML_ID'] = $xmlIds;
            if ($ids)
                $filter['ID'] = $ids;

            $arSelect = ['UF_NAME', 'UF_XML_ID'];
            if ($idBlock == HIGHLOADBLOCK_ID__FORMS) {
                $arSelect[] = 'UF_FILE';
                $arSelect[] = 'UF_NOT_SHOW_IN_MENU';
            } elseif ($idBlock == HIGHBLOCK_ID__COLOR) {
                $arSelect[] = 'UF_RGB';
                $arSelect[] = 'UF_FILE';
            } elseif ($idBlock == HIGHBLOCK_ID__SIZES) {
                $arSelect[] = 'UF_DUZHKA';
                $arSelect[] = 'UF_MOST';
                $arSelect[] = 'UF_LINZA';
                $arSelect[] = 'UF_HEIGHT';
                $arSelect[] = 'UF_TOTAL';
                $arSelect[] = 'UF_AVAIL';
            } elseif ($idBlock == HIGHBLOCK_ID__SEX) {
                $arSelect[] = 'UF_NOT_SHOW_IN_MENU';
            }

            $rsData = $strEntityDataClass::getList([
                'select' => $arSelect,
                'filter' => $filter,
                'order' => ['UF_SORT' => 'ASC', 'UF_NAME' => 'ASC']
            ]);
            while ($arItem = $rsData->Fetch()) {
                $result[$arItem['UF_XML_ID']] = $arItem;
            }

            $obCache->EndDataCache($result);
        }

        return $result;
    }

    public static function getHexColors()
    {
        $arr = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = HIGHBLOCK_ID__COLOR;
        $cachePath = '/getHexColors/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arr = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            $arr = self::getHighloadBlockData(HIGHBLOCK_ID__COLOR);
            $obCache->EndDataCache($arr);
        }

        $arrTemp = [];
        foreach ($arr as $key => $value) {
            $arrTemp[strtolower($key)] = $value;
        }
        $arr = $arrTemp;
        unset($arrTemp);

        return $arr;
    }

    public static function getParamFilterBySectId($iblockId, $sectId)
    {
        $result = [];

        if ($iblockId > 0 && $sectId > 0) {
            $obCache = new \CPHPCache();
            $cacheLifetime = CHACHE_LIFE_TIME;
            $cacheID = serialize($iblockId . $sectId);
            $cachePath = '/getParamFilterBySectId/' . $cacheID;

            if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                $result = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                Loader::includeModule('iblock');

                $sectPageUrl = '';
                $rsSect = \CIBlockSection::GetList(
                    ['sort' => 'asc', 'id' => 'desc'],
                    ['IBLOCK_ID' => $iblockId, '=ID' => $sectId],
                    false,
                    ['IBLOCK_ID', 'ID', 'SECTION_PAGE_URL', 'CODE']
                );
//                if ($arSect = $rsSect->GetNext())
//                    $sectPageUrl = $arSect['SECTION_PAGE_URL'];
                if ($arSect = $rsSect->Fetch())
                    $sectPageUrl = '/' . $arSect['CODE'] . '/';

                $FORMS = $BRANDS = $POLS = $LENSES_TYPE = $LENSES_FEATURES = [];

                if ($iblockId == IBLOCK_ID__LENSES) {
                    $objLensesType = \CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => 'LENSES_TYPE']);
                    while ($arLensesType = $objLensesType->Fetch()) {
                        $LENSES_TYPE[$arLensesType['VALUE']] = $arLensesType['XML_ID'];
                    }

                    $objLensesFeatures = \CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => 'LENSES_FEATURES']);
                    while ($arLensesFeatures = $objLensesFeatures->Fetch()) {
                        $LENSES_FEATURES[$arLensesFeatures['VALUE']] = $arLensesFeatures['XML_ID'];
                    }
                }

                $rsElem = \CIBlockElement::GetList(
                    [],
                    ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', '=SECTION_ID' => $sectId, 'INCLUDE_SUBSECTIONS' => 'Y'],
                    false,
                    false,
                    ['IBLOCK_ID', 'ID', 'PROPERTY_FRAME_TYPE', 'PROPERTY_BRAND', 'PROPERTY_POL', 'PROPERTY_LENSES_TYPE', 'PROPERTY_LENSES_FEATURES', 'PROPERTY_NEW', 'PROPERTY_POPULAR', 'PROPERTY_SALE']
                );
                while ($arElem = $rsElem->GetNext()) {
                    if (!empty($arElem['PROPERTY_FRAME_TYPE_VALUE']))
                        $FORMS[] = $arElem['PROPERTY_FRAME_TYPE_VALUE'];
                    if (!empty($arElem['PROPERTY_BRAND_VALUE']))
                        $BRANDS[] = $arElem['PROPERTY_BRAND_VALUE'];
                    if (!empty($arElem['PROPERTY_POL_VALUE']))
                        $POLS[] = $arElem['PROPERTY_POL_VALUE'];

                    if (!empty($arElem['PROPERTY_LENSES_TYPE_VALUE']) && !empty($LENSES_TYPE))
                        $result['LENSES_TYPE'][$arElem['PROPERTY_LENSES_TYPE_ENUM_ID']] = [
                            'UF_NAME' => $arElem['PROPERTY_LENSES_TYPE_VALUE'],
                            'URL' => $sectPageUrl . 'filter/lenses_type-is-' . $LENSES_TYPE[$arElem['PROPERTY_LENSES_TYPE_VALUE']] . '/apply/'
                        ];
                    if (!empty($arElem['PROPERTY_LENSES_FEATURES_VALUE']) && !empty($LENSES_FEATURES))
                        $result['LENSES_FEATURES'][$arElem['PROPERTY_LENSES_FEATURES_ENUM_ID']] = [
                            'NAME' => $arElem['PROPERTY_LENSES_FEATURES_VALUE'],
                            'URL' => $sectPageUrl . 'filter/lenses_features-is-' . $LENSES_FEATURES[$arElem['PROPERTY_LENSES_FEATURES_VALUE']] . '/apply/'
                        ];

                    if (!empty($arElem['PROPERTY_NEW_VALUE']))
                        $result['NEW'] = true;
                    if (!empty($arElem['PROPERTY_POPULAR_VALUE']))
                        $result['POPULAR'] = true;
                    if (!empty($arElem['PROPERTY_SALE_VALUE']))
                        $result['SALE'] = true;
                }

                if (!empty($FORMS))
                    $result['FORMS'] = self::getHighloadBlockData(HIGHLOADBLOCK_ID__FORMS, $FORMS);
                unset($FORMS);

                if (!empty($BRANDS)) {
                    $rsElem = \CIBlockElement::GetList(
                        ['name' => 'asc'],
                        ['IBLOCK_ID' => IBLOCK_ID__BRAND, 'ACTIVE' => 'Y', 'ID' => $BRANDS],
                        false,
                        false,
                        ['IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PROPERTY_NOT_SHOW_IN_MENU']
                    );
                    while ($arElem = $rsElem->Fetch()) {
                        $result['BRANDS'][$arElem['ID']] = $arElem;
                    }
                }
                unset($BRANDS);

                if (!empty($POLS))
                    $result['POLS'] = self::getHighloadBlockData(HIGHBLOCK_ID__SEX, $POLS);
                unset($POLS);

                foreach ($result['FORMS'] as $i => $item) {
                    $result['FORMS'][$i]['URL'] = $sectPageUrl . 'filter/frame_type-is-' . strtolower($i) . '/apply/';
                }

                foreach ($result['BRANDS'] as $i => $item) {
                    $result['BRANDS'][$i]['URL'] = $sectPageUrl . 'filter/brand-is-' . $item['CODE'] . '/apply/';
                }

                foreach ($result['POLS'] as $i => $item) {
                    $result['POLS'][$i]['URL'] = $sectPageUrl . 'filter/pol-is-' . strtolower($i) . '/apply/';
                }
            }

            $obCache->EndDataCache($result);
        }

        return $result;
    }

    public function getBannerCatalog()
    {
        Loader::includeModule('iblock');

//        $CITY_NAME = Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME');
//        $CITY_NAME = $_SESSION['GEO_IP']['NAME'];

        $arrData = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;

//        $arFilter = ['IBLOCK_ID' => IBLOCK_ID__BANNERS, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'PROPERTY_REGION' => false];
        $arFilter = ['IBLOCK_ID' => IBLOCK_ID__BANNERS, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'];
//        if (!empty($CITY_NAME) && ($CITY_NAME == 'Санкт-Петербург' || $CITY_NAME == 'Москва')) {
            $arFilter['=PROPERTY_REGION'] = $_SESSION['GEO_IP'];
//        }

        $cacheID = serialize($arFilter);
        $cachePath = '/getBannerCatalog/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arrData = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            $phoneNumber = self::getDataByCity($_SESSION['GEO_IP']['ID'])['PHONE_HEADER'][0];

            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                $arFilter,
                false,
                false,
                ['NAME', 'PREVIEW_TEXT', 'PROPERTY_COLOR', 'PROPERTY_BTN_NAME', 'PROPERTY_BTN_LINK', 'PROPERTY_BTN_COLOR']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arElem['PREVIEW_TEXT'] = str_replace(
                    ['#CITY#', '#PHONE#'],
                    [$_SESSION['GEO_IP']['NAME_DECLENSION'], '<a href="tel:' . self::clearPhone($phoneNumber) . '">' . $phoneNumber . '</a>'],
                    $arElem['PREVIEW_TEXT']
                );
                $arrData[] = $arElem;
            }

            $obCache->EndDataCache($arrData);
        }

        $result = '';

        if (!empty($arrData)) {
            $countOfData = count($arrData);

            $result = '<div class="note-warring"' . (!empty($arElement['PROPERTY_COLOR_VALUE']) ? ' style="background-color:#' . $arElement['PROPERTY_COLOR_VALUE'] . ';"' : '') . '>';

            if ($countOfData > 1) {
                $result .= '<div class="note-track">';
            }

            foreach ($arrData as $arElement) {
                $result .= '<div class="container d-xl-flex' . ($countOfData > 1 ? ' note-slick' : '') . '">';

                if (!empty($arElement['PREVIEW_TEXT']))
                    $result .= $arElement['PREVIEW_TEXT'];
                else {
                    $result .= '<p>' . $arElement['NAME'] . '</p>';
                    if (!empty($arElement['PROPERTY_BTN_LINK_VALUE'])) {
                        $result .= '<a href="' . $arElement['PROPERTY_BTN_LINK_VALUE'] . '" class="note-warring-btn d-none d-xl-block"' . (!empty($arrData['PROPERTY_COLOR_VALUE']) ? ' style="background-color:#' . $arrData['PROPERTY_BTN_COLOR_VALUE'] . ';"' : '') . '>' . (!empty($arrData['PROPERTY_BTN_NAME_VALUE']) ? $arrData['PROPERTY_BTN_NAME_VALUE'] : 'Подробнее') . '</a>';
                    }
                }

                $result .= '</div>';
            }

            if ($countOfData > 1) {
                $result .= '</div>';
            }

            $result .= '</div>';

            if ($countOfData > 1) {
                $result .= '<script>$(".note-track").slick({arrows:false,dots:false,mobileFirst:true,speed:500,autoplaySpeed:5000,slidesToShow:1,slidesToScroll:1,autoplay:true,cssEase:"ease-out",});</script>';
            }
        }

        return $result;
    }

    public static function getOffersColors( $arr, $colors = [], $sizes = [] ) {
        $result = [];
        if ( !empty($arr) ) {
            if ( empty($colors) ) {
                $obCache = new \CPHPCache();
                $cacheLifetime = CHACHE_LIFE_TIME;
                $cacheID = HIGHBLOCK_ID__COLOR;
                $cachePath = '/getOffersColors/' . $cacheID;

                if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                    $colors = $obCache->GetVars();
                } elseif ($obCache->StartDataCache()) {
                    $colors = self::getHighloadBlockData(HIGHBLOCK_ID__COLOR);
                    $obCache->EndDataCache($colors);
                }
            }

            $needId = key($arr);

            $minPrice = 1000000000;
            foreach ( $arr as $id => $offer ) {
                if (
                    !empty($offer['PROPERTIES']['COLOR']['VALUE']) &&
                    $offer['ITEM_PRICES'][0]['PRICE'] > 0 &&
                    $offer['ITEM_PRICES'][0]['PRICE'] < $minPrice
                ) {
                    $minPrice = $offer['ITEM_PRICES'][0]['PRICE'];
                    $needId = $id;
                }
            }
            unset($minPrice);

            foreach ( $arr as $id => $offer ) {
                if (
                    !empty($offer['PROPERTIES']['COLOR']['VALUE']) &&
                    $offer['ITEM_PRICES'][0]['PRICE'] > 0 &&
                    $offer['CATALOG_QUANTITY'] > 0
                ) {
                    $needId = $id;
                }
            }

            $offer = $arr[$needId];
            if ( !empty($offer) ) {
                $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ] = [
                    'ID' => $offer['ID'],
                    'COLOR' => $colors[ $offer['PROPERTIES']['COLOR']['VALUE'] ],
                    'PRICE' => $offer['ITEM_PRICES'][0]['PRICE'],
                    'OLD_PRICE' => $offer['PROPERTIES']['OLD_PRICE']['VALUE'],
                    'QUANTITY' => $offer['CATALOG_QUANTITY']
                ];

                if ( $offer['ITEM_PRICES'][0]['PRICE'] < $offer['ITEM_PRICES'][0]['BASE_PRICE'] )
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['OLD_PRICE'] = $offer['ITEM_PRICES'][0]['BASE_PRICE'];

                if ( !empty($offer['PREVIEW_PICTURE']) ) {
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE'][] = $offer['PREVIEW_PICTURE']['SRC'];
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE_ID'][] = $offer['PREVIEW_PICTURE']['ID'];
                }
                elseif ( !empty($offer['DETAIL_PICTURE']) ) {
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE'][] = $offer['DETAIL_PICTURE']['SRC'];
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE_ID'][] = $offer['DETAIL_PICTURE']['ID'];
                }

                foreach ( $offer['PROPERTIES']['MORE_PHOTO']['VALUE'] as $img ) {
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE'][] = \CFile::GetPath($img);
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['PICTURE_ID'][] = $img;
                }

                $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['SIZES'] = [];
                foreach ( $offer['PROPERTIES']['SIZES']['VALUE'] as $size ) {
                    $result[ $offer['PROPERTIES']['COLOR']['VALUE'] ]['SIZES'][ $size ] = $sizes[ $size ];
                }
            }
        }

        return $result;
    }

    public static function notShowAuth(){
        global $USER, $APPLICATION;

        $result = false;
        if ( !$USER->IsAuthorized() && $APPLICATION->GetCurDir() == '/personal/' )
            $result = true;

        return $result;
    }

    public static function isAjax(){
        $request = Application::getInstance()->getContext()->getRequest();

        return $request->get('ajax_mode') == 'y';
    }

    public static function getCatalogIblockId()
    {
        global $APPLICATION;

        $iblockId = IBLOCK_ID__CATALOG;

        $arr = explode('/', $APPLICATION->GetCurDir());
        if (in_array($arr[1], ['sunglasses', 'sports-glasses']))
            $iblockId = IBLOCK_ID__CATALOG_2;
        elseif (in_array($arr[1], ['lenses']))
            $iblockId = IBLOCK_ID__LENSES;

        return $iblockId;
    }

    public static function getSalePrice($productId, $productPriceId = null, $price = null, $quantity = 1, $siteId = 's1')
    {
        if ($productId < 1)
            return false;

        Loader::includeModule('sale');
        Loader::includeModule('catalog');

        $result = [];

        if (!isset($productPriceId) || !isset($price)) {
            // $obCache = new \CPHPCache();
            // $cacheLifetime = CHACHE_LIFE_TIME;
            // $cacheID = serialize(PRICE__CATALOG_GROUP_ID . $productId);
            // $cachePath = '/' . $cacheID;
            //
            // if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            //     $result = $obCache->GetVars();
            // } elseif ($obCache->StartDataCache()) {
            //     $db_res = \CPrice::GetList(
            //         [],
            //         [
            //             "PRODUCT_ID" => $productId,
            //             "=CATALOG_GROUP_ID" => PRICE__CATALOG_GROUP_ID
            //         ],
            //         false,
            //         false,
            //         ['ID', 'PRICE']
            //     );
            //     if ($ar_res = $db_res->Fetch()) {
            //         $result['productPriceId'] = $ar_res["ID"];
            //         $result['price'] = $ar_res["PRICE"];
            //     } else
            //         return false;
            //
            //     $obCache->EndDataCache($result);
            // }

            $prices = \Bitrix\Catalog\PriceTable::getList([
                'select' => ['ID', 'PRICE'],
                'filter' => \Bitrix\Iblock\ORM\Query::filter()
                    ->where('PRODUCT_ID', $productId)
                    // ->whereIn('CATALOG_GROUP_ID', [PRICE_BASE__CODE_ID, PRICE_BASE_SPEC__CODE_ID])
                    ->where('CATALOG_GROUP_ID', PRICE__CATALOG_GROUP_ID)
                ,
            ])->fetchAll();

            $productPriceId = $prices['ID'];
            $price = $prices['PRICE'];

            // $productPriceId = $result['productPriceId'];
            // $price = $result['price'];
        }

        $arOrder = [
            'SITE_ID' => $siteId,
            'USER_ID' => 5,
            'ORDER_PRICE' => 1000,
            'ORDER_WEIGHT' => 100,
            'BASKET_ITEMS' => [
                [
                    'PRODUCT_ID' => $productId,
                    'PRODUCT_PRICE_ID' => $productPriceId,
                    'PRICE' => $price,
                    'CURRENCY' => 'RUB',
                    'BASE_PRICE' => $price,
                    'QUANTITY' => $quantity,
                    'LID' => 's1',
                    'MODULE' => 'catalog',
                ]
            ]
        ];

        $arOptions = [
            'COUNT_DISCOUNT_4_ALL_QUANTITY' => 'Y'
        ];

        $arErrors = [];
        // TODO: отключить скидки
        \CSaleDiscount::DoProcessOrder($arOrder, $arOptions, $arErrors);

        $resultPrice = $arOrder['BASKET_ITEMS'][0]['PRICE'];
        unset($arOrder, $arOptions, $arErrors);

        return $resultPrice;
    }

//    public static function getPropsValues($arr)
//    {
//        $props = $values = [];
//
//        if (!empty($arr['PROPERTIES'])) {
//            $arPropsD = ['PRICE', 'CML2_BAR_CODE', 'CML2_ARTICLE', 'CML2_ATTRIBUTES', 'CML2_TRAITS', 'CML2_BASE_UNIT', 'CML2_MANUFACTURER', 'CML2_TAXES', 'WOBBLERS', 'SIZES', 'OLD_PRICE'];
//
//            $obCache = new \CPHPCache();
//            $cacheLifetime = CHACHE_LIFE_TIME;
//
//            foreach ($arr['PROPERTIES'] as $code => $prop) {
//                if (!in_array($code, $arPropsD)  &&  $prop['PROPERTY_TYPE'] == 'S') {
//                    $values = [];
//
//                    if (!empty($prop['USER_TYPE_SETTINGS']['TABLE_NAME'])) {
//                        $cacheID = $arr['ID'];
//                        $cachePath = '/getPropsValues/' . $cacheID;
//
//                        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
//                            $valuesHL = $obCache->GetVars();
//                        } elseif ($obCache->StartDataCache()) {
//                            $valuesHL = self::getHighloadBlockData(0, $prop['VALUE'], [], $prop['USER_TYPE_SETTINGS']['TABLE_NAME']);
//                            $obCache->EndDataCache($valuesHL);
//                        }
//
//                        foreach ($valuesHL as $v) {
//                            $values[] = $v['UF_NAME'];
//                        }
//                        $props[$prop['NAME']] = implode(' / ', $values);
//                    } else {
//                        if (is_array($prop['VALUE'])) {
//                            $values = $prop['VALUE'];
//                            $props[$prop['NAME']] = implode(' / ', $values);
//                        } elseif (!empty($prop['VALUE'])) {
//                            $props[$prop['NAME']] = $prop['VALUE'];
//                        }
//                    }
//                }
//            }
//        }
//
//        return $props;
//    }

    public static function getDetailPageUrl($arr = [], $iblockId, $code = '')
    {
        $result = $ids = [];

        $sectionCode = 'eyeglass-frames';
        if ($iblockId == IBLOCK_ID__CATALOG_2)
            $sectionCode = 'sunglasses';
        elseif ($iblockId == IBLOCK_ID__LENSES)
            $sectionCode = 'lenses';

        if (!empty($arr) && $iblockId > 0) {
            if (!empty($arr['ITEMS'])) {
                foreach ($arr['ITEMS'] as $item) {
                    $ids[] = $item['ID'];
                }
            } elseif ($arr['ID'] > 0)
                $ids[] = $arr['ID'];

            $obCache = new \CPHPCache();
            $cacheLifetime = CHACHE_LIFE_TIME;
            $cacheID = serialize([$ids . $iblockId . $code]);
            $cachePath = '/' . $cacheID;

            if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
                $result = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                Loader::includeModule('iblock');

                $rsElem = \CIBlockElement::GetList(
                    ['sort' => 'asc', 'id' => 'desc'],
                    ['IBLOCK_ID' => $iblockId, '=ID' => $ids],
                    false,
                    false,
                    ['ID', 'CODE']
                );
                while ($arElem = $rsElem->Fetch()) {
                    $result[$arElem['ID']] = '/' . $sectionCode . '/' . $arElem['CODE'] . '/';
                }

                $obCache->EndDataCache($result);
            }
        } elseif (!empty($code) && $iblockId > 0) {
            $result[] = '/' . $sectionCode . '/' . $code . '/';
        }

        return $result;
    }

    public static function getSeoFilter($dir)
    {
        $result = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;

        $arFilter = ['IBLOCK_ID' => IBLOCK_ID__SEO, '=PROPERTY_URL' => $dir, 'ACTIVE' => 'Y'];
        $arSelect = ['ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PROPERTY_H1', 'PROPERTY_TITLE', 'PROPERTY_BOTTOM_TEXT', 'PROPERTY_DESCRIPTION', 'PROPERTY_KEYWORDS', 'PROPERTY_DESCRIPTION_HIDDEN', 'PROPERTY_DESCRIPTION_HIDDEN_SPB'];
// хз
		if (SITE_ID == 's2' || $_SESSION['GEO_IP']['NAME'] == 'Санкт-Петербург') {
			$arFilter['!PROPERTY_H1_SPB'] = false;
			$arSelect = ['ID', 'NAME', 'PROPERTY_PREVIEW_TEXT_SPB', 'PROPERTY_DETAIL_TEXT_SPB', 'PROPERTY_H1_SPB', 'PROPERTY_TITLE_SPB', 'PROPERTY_BOTTOM_TEXT_SPB', 'PROPERTY_DESCRIPTION_SPB', 'PROPERTY_KEYWORDS_SPB', 'PROPERTY_DESCRIPTION_HIDDEN_SPB'];
		}
		if (SITE_ID == 'm2' || $_SESSION['GEO_IP']['NAME'] == 'Уфа') {
			$arFilter['!PROPERTY_H1_UFA'] = false;
			$arSelect = ['ID', 'NAME', 'PROPERTY_PREVIEW_TEXT_UFA', 'PROPERTY_DETAIL_TEXT_UFA', 'PROPERTY_H1_UFA', 'PROPERTY_TITLE_UFA', 'PROPERTY_BOTTOM_TEXT_UFA', 'PROPERTY_DESCRIPTION_UFA', 'PROPERTY_KEYWORDS_UFA', 'PROPERTY_DESCRIPTION_HIDDEN_UFA'];
		}

        $cacheID = serialize($arFilter);
        $cachePath = '/getSeoFilter/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $result = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $rsElem = \CIBlockElement::GetList(
                [],
                $arFilter,
                false,
                ['nTopCount' => 1],
                $arSelect
            );
            if ($arElem = $rsElem->GetNext()) {
// хз
				$arElem['PROPERTY_DESCRIPTION_HIDDEN_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_DESCRIPTION_HIDDEN_VALUE']['TEXT']);
				$arElem['PROPERTY_BOTTOM_TEXT_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_BOTTOM_TEXT_VALUE']['TEXT']);
                if (SITE_ID == 's2' || $_SESSION['GEO_IP']['NAME'] == 'Санкт-Петербург') {
                    $arElem['PREVIEW_TEXT'] = htmlspecialchars_decode($arElem['PROPERTY_PREVIEW_TEXT_SPB_VALUE']['TEXT']);
                    $arElem['DETAIL_TEXT'] = htmlspecialchars_decode($arElem['PROPERTY_DETAIL_TEXT_SPB_VALUE']['TEXT']);
                    $arElem['PROPERTY_H1_VALUE'] = $arElem['PROPERTY_H1_SPB_VALUE'];
                    $arElem['PROPERTY_TITLE_VALUE'] = $arElem['PROPERTY_TITLE_SPB_VALUE'];
                    $arElem['PROPERTY_DESCRIPTION_VALUE'] = $arElem['PROPERTY_DESCRIPTION_SPB_VALUE'];
                    $arElem['PROPERTY_KEYWORDS_VALUE'] = $arElem['PROPERTY_KEYWORDS_SPB_VALUE'];
					$arElem['PROPERTY_DESCRIPTION_HIDDEN_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_DESCRIPTION_HIDDEN_SPB_VALUE']['TEXT']);
					$arElem['PROPERTY_BOTTOM_TEXT_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_BOTTOM_TEXT_SPB_VALUE']['TEXT']);
                }
				if (SITE_ID == 'm2' || $_SESSION['GEO_IP']['NAME'] == 'Уфа') {
					$arElem['PREVIEW_TEXT'] = htmlspecialchars_decode($arElem['PROPERTY_PREVIEW_TEXT_UFA_VALUE']['TEXT']);
					$arElem['DETAIL_TEXT'] = htmlspecialchars_decode($arElem['PROPERTY_DETAIL_TEXT_UFA_VALUE']['TEXT']);
					$arElem['PROPERTY_H1_VALUE'] = $arElem['PROPERTY_H1_UFA_VALUE'];
					$arElem['PROPERTY_TITLE_VALUE'] = $arElem['PROPERTY_TITLE_UFA_VALUE'];
					$arElem['PROPERTY_DESCRIPTION_VALUE'] = $arElem['PROPERTY_DESCRIPTION_UFA_VALUE'];
					$arElem['PROPERTY_KEYWORDS_VALUE'] = $arElem['PROPERTY_KEYWORDS_UFA_VALUE'];
					$arElem['PROPERTY_DESCRIPTION_HIDDEN_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_DESCRIPTION_HIDDEN_UFA_VALUE']['TEXT']);
					$arElem['PROPERTY_BOTTOM_TEXT_VALUE'] = htmlspecialchars_decode($arElem['PROPERTY_BOTTOM_TEXT_UFA_VALUE']['TEXT']);
				}
                $result = $arElem;
            }

            $obCache->EndDataCache($result);
        }

        return $result;
    }

    public static function getDataByCity($city = 0)
    {
        $result = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;

        $arFilter = ['=IBLOCK_ID' => IBLOCK_ID__CITY_DATA, 'ACTIVE' => 'Y', '=PROPERTY_CITY_ID' => $city];
//        if (!empty($city)) {
//            $arFilter['=NAME'] = $city;
//        }

        $cacheID = serialize($arFilter);
        $cachePath = '/getDataByCity/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $result = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $rsElem = \CIBlockElement::GetList(
                [],
                $arFilter,
                false,
                ['nTopCount' => 1],
                ['IBLOCK_ID', 'ID', 'PROPERTY_PHONE_HEADER', 'PROPERTY_PHONE_FOOTER', 'PROPERTY_ADDRESS_FOOTER', 'PROPERTY_TIME', 'PROPERTY_CONTACTS']
            );
            if ($objProp = $rsElem->GetNextElement()) {
                $arProp = $objProp->GetProperties();

                $result = [
                    'PHONE_HEADER' => $arProp['PHONE_HEADER']['VALUE'],
                    'PHONE_FOOTER' => $arProp['PHONE_FOOTER']['VALUE'],
                    'ADDRESS_FOOTER' => htmlspecialchars_decode($arProp['ADDRESS_FOOTER']['VALUE']['TEXT']),
                    'TIME' => htmlspecialchars_decode($arProp['TIME']['VALUE']['TEXT']),
                    'CONTACTS' => htmlspecialchars_decode($arProp['CONTACTS']['VALUE']['TEXT'])
                ];
            }

            $obCache->EndDataCache($result);
        }

        return $result;
    }

    public static function clearPhone( $phone = '' ){
        return preg_replace("/[^,.0-9]/", '', $phone);
    }

    public static function getPhoneHeader($city = 0)
    {
        $phones = self::getDataByCity($city);

        $result = '';
        if (!empty($phones['PHONE_HEADER'])) {
//            $result = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="11" viewbox="0 0 11 11">
//                <defs>
//                    <path id="mg5ha" d="M824.08 27c-.28 0-.57-.05-.84-.14-3.37-1.2-6-3.9-7.12-7.31a2.53 2.53 0 0 1 .87-2.79l.55-.41a1.72 1.72 0 0 1 2.56.58l.92 1.78c.23.45.16 1-.18 1.36l-.2.21a.67.67 0 0 0-.1.76c.32.6.8 1.1 1.41 1.4.25.13.55.1.76-.1l.21-.19c.37-.33.91-.4 1.36-.18l1.79.92a1.72 1.72 0 0 1 .43 2.73l-.62.63c-.47.48-1.12.75-1.8.75z"></path>
//                </defs>
//                <g>
//                    <g transform="translate(-816 -16)">
//                        <use fill="#fff" xlink:href="#mg5ha"></use>
//                    </g>
//                </g>
//            </svg>';

            foreach ($phones['PHONE_HEADER'] as $key => $phone) {
                $_is_phone_num = preg_match("/^[+0-9\s\-()]+$/", $phone);
                $phone = str_replace(' ', '&nbsp;', $phone);
                $result .= $_is_phone_num
                    ? '<a' . ($key ? ' class="hidden-phone_on-mobile"' : '') . ' href="tel:' . self::clearPhone($phone) . '">' . $phone . '</a>'
                    : '<a' . ($key ? ' class="hidden-phone_on-mobile"' : '') . '">' . $phone . '</a>';
            }
        }

        return $result;
    }

	public static function getPhoneHeaderCustomClearForA($city = 0)
    {
        $phones = self::getDataByCity($city);

        $result = '';
        if (!empty($phones['PHONE_HEADER'])) {

            foreach ($phones['PHONE_HEADER'] as $key => $phone) {
                if(!$key)
                    $result = "+".str_replace(array("-", " ", "(", ")"), '', $phone);
            }
        }

        return $result;
    }

    public static function getPhoneHeaderMobile($city = 0)
    {
        $phones = self::getDataByCity($city);

        $result = '';
        if (!empty($phones['PHONE_HEADER'])) {
            foreach ($phones['PHONE_HEADER'] as $phone) {
                $_is_phone_num = preg_match("/^[+0-9\s\-()]+$/", $phone);
                $phone = str_replace(' ', '&nbsp;', $phone);
                $result .= $_is_phone_num
                    ? '<li class="side-menu__phone"><a href="tel:' . self::clearPhone($phone) . '">' . $phone . '</a></li>'
                    : '<li><a>' . $phone . '</a></li>';
            }
        }

        return $result;
    }

    public static function getPhoneFooter($city = 0)
    {
        $phones = self::getDataByCity($city);

        $result = '';
        if (!empty($phones['PHONE_FOOTER'])) {
            $result = '<p class="footer-phones">';
            foreach ($phones['PHONE_FOOTER'] as $phone) {
                $_is_phone_num = preg_match("/^[+0-9\s\-()]+$/", $phone);
                $phone = str_replace(' ', '&nbsp;', $phone);
                $result .= $_is_phone_num
                    ? '<a href="tel:' . self::clearPhone($phone) . '">' . $phone . '</a>'
                    : '<a>' . $phone . '</a>';
            }
            $result .= '</p>';
        }

        return $result;
    }

    public static function getAddressFooter($city = 0)
    {
        $data = self::getDataByCity($city);

        return $data['ADDRESS_FOOTER'];
    }

    public static function getTimes($city = 0)
    {
        $data = self::getDataByCity($city);

        return $data['TIME'];
    }

    public static function getContacts($city = 0)
    {
        $data = self::getDataByCity($city);

        return $data['CONTACTS'];
    }

    public static function getMskSpbPrice(int $id)
    {
        $result = [];

        // $obCache = new \CPHPCache();
        // $cacheLifetime = CHACHE_LIFE_TIME;
        // $cacheID = PRICE_BASE__CODE_ID . $id;
        // $cachePath = '/getMskSpbPrice/' . $cacheID;
        //
        // if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
        //     $result = $obCache->GetVars();
        // } elseif ($obCache->StartDataCache()) {
            $prices = \Bitrix\Catalog\PriceTable::getList([
                'select' => ['*'],
                'filter' => \Bitrix\Iblock\ORM\Query::filter()
                    ->where('PRODUCT_ID', $id)
                    ->whereIn('CATALOG_GROUP_ID', [PRICE_BASE__CODE_ID, PRICE_BASE_SPEC__CODE_ID])
                ,
            ])->fetchAll();

            $currentPrice = current($prices)['PRICE'];
            foreach ($prices as $price) {
                if ($price['PRICE'] > $currentPrice) {
                    continue;
                }

                $result = $price;

                $currentPrice = $price['PRICE'];
            }
            unset($price);

            $count = count($prices);
            $result['IS_SPEC'] = (int) ($count > 1);

            // $db_res = \CPrice::GetList(
            //     [],
            //     ['=PRODUCT_ID' => $id, '=CATALOG_GROUP_ID' => PRICE_BASE__CODE_ID]
            // );
            // if ($ar_res = $db_res->Fetch())
            //     $result = $ar_res;

        //     $obCache->EndDataCache($result);
        // }

        // file_put_contents('/var/www/chernika/prod/upload/tmp_tmp.log', print_r($result, true) . "\n", FILE_APPEND);

        return $result;
    }

    public static function setPropTp(){
        // file_put_contents('/var/www/chernika/prod/upload/1c_bx.log', date('d.m.Y H:i:s') . ' - \PDV\Tools::setPropTp()'.PHP_EOL, FILE_APPEND);
        // ob_start();
        // debug_print_backtrace();
        // file_put_contents('/var/www/chernika/prod/upload/1c_bx.log', ob_get_clean().PHP_EOL, FILE_APPEND);

        Loader::includeModule('iblock');
        Loader::includeModule('catalog');
        Loader::includeModule('sale');

        $el = new \CIBlockElement;
        $from = ConvertTimeStamp(time() - 1*60*60, "FULL");
        $to = ConvertTimeStamp(time()- 0*60*60, "FULL");

        //Оправы
        $rsElem = \CIBlockElement::GetList(
            ['id' => 'desc'],
            [
                'IBLOCK_ID' => IBLOCK_ID__CATALOG,
                'ACTIVE' => 'Y',
                [
                    "LOGIC" => "AND",
                    ['>TIMESTAMP_X' => $from],
                    ['<TIMESTAMP_X' => $to]
                ]
            ],
            false,
            false,
            ['ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_COLOR']
        );
        while ( $arElem = $rsElem->Fetch() ) {

            $countOffers = 0;
            $count = 0;
            $prices = [];
            $pricesMskSpb = [];

            $rsElemTp = \CIBlockElement::GetList(
                array(),
                array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP, 'PROPERTY_CML2_LINK' => $arElem['ID']),
                false,
                false,
                array('ID', 'ACTIVE', 'PREVIEW_PICTURE', 'PROPERTY_COLOR')
            );
            while ( $arElemTp = $rsElemTp->Fetch() ) {
                $countOffers++;

                if ( empty($arElemTp['PROPERTY_COLOR_VALUE']) )
                    \CIBlockElement::SetPropertyValues($arElemTp['ID'], IBLOCK_ID__CATALOG_TP, $arElem['PROPERTY_COLOR_VALUE'], 'COLOR');

                if ( !empty($arElem['PREVIEW_PICTURE']) && empty($arElemTp['PREVIEW_PICTURE']) ) {
                    $el->Update(
                        $arElemTp['ID'],
                        [
                            'PREVIEW_PICTURE' => \CFile::MakeFileArray($arElem['PREVIEW_PICTURE']),
                            'DETAIL_PICTURE' => \CFile::MakeFileArray($arElem['DETAIL_PICTURE'])
                        ]
                    );
                }

                if ( $arElemTp['ACTIVE'] == 'Y' ) {
                    $resCat = \CCatalogProduct::GetList(
                        array(),
                        array('ID' => $arElemTp['ID']),
                        false,
                        array('nTopCount' => 1)
                    );
                    if ( $arresCat = $resCat->Fetch() ) {
                        if ( $arresCat['QUANTITY'] > 0 ) {
                            $salePrice = self::getSalePrice($arElemTp['ID']);
                            if ( $salePrice > 0 )
                                $prices[] = $salePrice;

                            $priceMskArr = self::getMskSpbPrice($arElemTp['ID']);
                            $priceMsk = self::getSalePrice($arElemTp['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                            if ( $priceMsk > 0 )
                                $pricesMskSpb[] = $priceMsk;
                        }

                        $count += $arresCat['QUANTITY'];
                    }
                }
            }
            unset($rsElemTp, $arElemTp);

            if ( $countOffers == 0 ) {
                $resCat = \CCatalogProduct::GetList(
                    array(),
                    array('ID' => $arElem['ID']),
                    false,
                    array('nTopCount' => 1)
                );
                if ( $arresCat = $resCat->Fetch() ) {
                    if ( $arresCat['QUANTITY'] > 0 ) {
                        $prices[] = self::getSalePrice($arElem['ID']);

                        $priceMskArr = self::getMskSpbPrice($arElem['ID']);
                        $priceMsk = self::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                        if ( $priceMsk > 0 )
                            $pricesMskSpb[] = $priceMsk;
                    }

                    $count = $arresCat['QUANTITY'];
                }
            }

            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG, min($prices), 'PRICE');
            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG, min($pricesMskSpb), 'PRISE');

            $sort = 1500;
            $sortMskSpb = 1500;
            if ( $count > 0 && min($prices) > 0 )
                $sort = 500;
            if ( $count > 0 && min($pricesMskSpb) > 0 )
                $sortMskSpb = 500;

            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG, $sortMskSpb, 'SORT');
            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG, $sort, 'SORT_ALL');

            \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(IBLOCK_ID__CATALOG, $arElem['ID']);

            unset($prices, $pricesMskSpb);
        }

        //Солнцезащитные
        $rsElem = \CIBlockElement::GetList(
            ['id' => 'desc'],
            [
                'IBLOCK_ID' => IBLOCK_ID__CATALOG_2,
                'ACTIVE' => 'Y',
                [
                    "LOGIC" => "AND",
                    ['>TIMESTAMP_X' => $from],
                    ['<TIMESTAMP_X' => $to]
                ]
            ],
            false,
            false,
            ['ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_COLOR']
        );
        while ( $arElem = $rsElem->Fetch() ) {

            $countOffers = 0;
            $count = 0;
            $prices = [];
            $pricesMskSpb = [];

            $rsElemTp = \CIBlockElement::GetList(
                array(),
                array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP_2, 'PROPERTY_CML2_LINK' => $arElem['ID']),
                false,
                false,
                array('ID', 'ACTIVE', 'PREVIEW_PICTURE', 'PROPERTY_COLOR')
            );
            while ( $arElemTp = $rsElemTp->Fetch() ) {
                $countOffers++;
                if ( empty($arElemTp['PROPERTY_COLOR_VALUE']) )
                    \CIBlockElement::SetPropertyValues($arElemTp['ID'], IBLOCK_ID__CATALOG_TP_2, $arElem['PROPERTY_COLOR_VALUE'], 'COLOR');

                if ( !empty($arElem['PREVIEW_PICTURE']) && empty($arElemTp['PREVIEW_PICTURE']) ) {
                    $el->Update(
                        $arElemTp['ID'],
                        [
                            'PREVIEW_PICTURE' => \CFile::MakeFileArray($arElem['PREVIEW_PICTURE']),
                            'DETAIL_PICTURE' => \CFile::MakeFileArray($arElem['DETAIL_PICTURE'])
                        ]
                    );
                }

                if ( $arElemTp['ACTIVE'] == 'Y' ) {
                    $salePrice = self::getSalePrice($arElemTp['ID']);
                    if ( $salePrice > 0 )
                        $prices[] = $salePrice;

                    $priceMskArr = self::getMskSpbPrice($arElemTp['ID']);
                    $priceMsk = self::getSalePrice($arElemTp['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                    if ( $priceMsk > 0 )
                        $pricesMskSpb[] = $priceMsk;

                    $resCat = \CCatalogProduct::GetList(
                        array(),
                        array('ID' => $arElemTp['ID']),
                        false,
                        array('nTopCount' => 1)
                    );
                    if ($arresCat = $resCat->Fetch())
                        $count += $arresCat['QUANTITY'];
                }
            }

            if ( $countOffers == 0 ) {
                $prices[] = self::getSalePrice($arElem['ID']);

                $priceMskArr = self::getMskSpbPrice($arElem['ID']);
                $priceMsk = self::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                if ( $priceMsk > 0 )
                    $pricesMskSpb[] = $priceMsk;

                $resCat = \CCatalogProduct::GetList(
                    array(),
                    array('ID' => $arElem['ID']),
                    false,
                    array('nTopCount' => 1)
                );
                if ( $arresCat = $resCat->Fetch() )
                    $count = $arresCat['QUANTITY'];
            }

            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG_2, min($prices), 'PRICE');
            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG_2, min($pricesMskSpb), 'PRISE');

            $sort = 1500;
            $sortMskSpb = 1500;
            if ( $count > 0 && min($prices) > 0 )
                $sort = 500;
            if ( $count > 0 && min($pricesMskSpb) > 0 )
                $sortMskSpb = 500;

            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG_2, $sortMskSpb, 'SORT');
            \CIBlockElement::SetPropertyValues($arElem['ID'], IBLOCK_ID__CATALOG_2, $sort, 'SORT_ALL');

            \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(IBLOCK_ID__CATALOG_2, $arElem['ID']);

            unset($prices,$pricesMskSpb);
        }
    }

    public static function createIblockSitemap( $iblockId ) {
        if ( $iblockId > 0 ) {
            Loader::includeModule('iblock');

            $sectionCode = '';
            if ( $iblockId == IBLOCK_ID__CATALOG )
                $sectionCode = 'eyeglass-frames';
            if ( $iblockId == IBLOCK_ID__CATALOG_2 )
                $sectionCode = 'sunglasses';
            if ( $iblockId == IBLOCK_ID__LENSES )
                $sectionCode = 'lenses';

            $str = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
                false,
                false,
                ['ID', 'CODE', 'DETAIL_PAGE_URL', 'TIMESTAMP_X']
            );
            while ( $arElem = $rsElem->Fetch() ) {
                $url = $arElem['DETAIL_PAGE_URL'];
                if ( !empty($sectionCode) && !empty($arElem['CODE']) )
                    $url = '/'.$sectionCode.'/'.$arElem['CODE'].'/';

                $date = ConvertDateTime($arElem['TIMESTAMP_X'], 'YYYY-MM-DD');
                $time = ConvertDateTime($arElem['TIMESTAMP_X'], 'HH:II:SS');

                $str .= '<url><loc>https://chernika-optika.ru'.$url.'</loc><lastmod>'.$date.'T'.$time.'+03:00</lastmod></url>';
            }

            $str .= '</urlset>';

            if ( $handle = fopen('/var/www/chernika/prod/public/chernika/sitemap-iblock-'.$iblockId.'.xml', 'w') ) {
                fwrite($handle, $str);
                fclose($handle);
            }

            $str = str_replace('https://chernika-optika.ru/', 'https://spb.chernika-optika.ru/', $str);
            if ( $handle = fopen('/var/www/chernika/prod/public/spb/sitemap-iblock-'.$iblockId.'.xml', 'w') ) {
                fwrite($handle, $str);
                fclose($handle);
            }
        }
    }

    public static function createIblockSeoSitemap() {
        Loader::includeModule('iblock');

        $str = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $urls = [];
        $rsElem = \CIBlockElement::GetList(
            ['sort' => 'asc', 'id' => 'desc'],
            ['IBLOCK_ID' => IBLOCK_ID__SEO, 'ACTIVE' => 'Y', '!PROPERTY_URL' => false],
            false,
            false,
            ['ID', 'TIMESTAMP_X', 'PROPERTY_URL']
        );
        while ( $arElem = $rsElem->Fetch() ) {
            if ( !in_array($arElem['PROPERTY_URL_VALUE'], $urls) ) {
                $date = ConvertDateTime($arElem['TIMESTAMP_X'], 'YYYY-MM-DD');
                $time = ConvertDateTime($arElem['TIMESTAMP_X'], 'HH:II:SS');

                $str .= '<url><loc>https://chernika-optika.ru'.$arElem['PROPERTY_URL_VALUE'].'</loc><lastmod>'.$date.'T'.$time.'+03:00</lastmod></url>';

                $urls[] = $arElem['PROPERTY_URL_VALUE'];
            }
        }

        $str .= '</urlset>';

        if ( $handle = fopen('/var/www/chernika/prod/public/chernika/sitemap-iblock-'.IBLOCK_ID__SEO.'.xml', 'w') ) {
            fwrite($handle, $str);
            fclose($handle);
        }

        $str = str_replace('https://chernika-optika.ru/', 'https://spb.chernika-optika.ru/', $str);
        if ( $handle = fopen('/var/www/chernika/prod/public/spb/sitemap-iblock-'.IBLOCK_ID__SEO.'.xml', 'w') ) {
            fwrite($handle, $str);
            fclose($handle);
        }
    }

    public static function createSitemap(){
        self::createIblockSitemap( IBLOCK_ID__CATALOG );
        self::createIblockSitemap( IBLOCK_ID__CATALOG_2 );
        self::createIblockSitemap( IBLOCK_ID__LENSES );
        self::createIblockSeoSitemap();
    }

    public static function deactiveProduct()
    {
        Loader::includeModule('iblock');

        $el = new \CIBlockElement;

        $rsElem = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => IBLOCK_ID__CATALOG, 'ACTIVE' => 'Y'],
            false,
            false,
            ['IBLOCK_ID', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'ACTIVE', 'PROPERTY_MORE_PHOTO']
        );
        while ($arElem = $rsElem->Fetch()) {
            $active = 'Y';
            if (empty($arElem['PREVIEW_PICTURE']) && empty($arElem['DETAIL_PICTURE']) && empty($arElem['PROPERTY_MORE_PHOTO_VALUE']))
                $active = 'N';

            if ($active != $arElem['ACTIVE'] && $active == 'N') {
                $el->Update(
                    $arElem['ID'],
                    ['ACTIVE' => $active]
                );
            }
        }

        $rsElem = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => IBLOCK_ID__CATALOG_2, 'ACTIVE' => 'Y'],
            false,
            false,
            ['IBLOCK_ID', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'ACTIVE', 'PROPERTY_MORE_PHOTO']
        );
        while ($arElem = $rsElem->Fetch()) {
            $active = 'Y';
            if (empty($arElem['PREVIEW_PICTURE']) && empty($arElem['DETAIL_PICTURE']) && empty($arElem['PROPERTY_MORE_PHOTO_VALUE']))
                $active = 'N';

            if ($active != $arElem['ACTIVE'] && $active == 'N') {
                $el->Update(
                    $arElem['ID'],
                    ['ACTIVE' => $active]
                );
            }
        }
    }

    public static function getSliderIdsByCity($city = '')
    {
        $result = $arrBanners = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = IBLOCK_ID__SLIDER;
        $cachePath = '/getSliderIdsByCity/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arrBanners = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__SLIDER, 'ACTIVE' => 'Y'],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_CITY']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arrBanners[] = $arElem;
            }

            $obCache->EndDataCache($arrBanners);
        }

        if (!empty($city)) {
            foreach ($arrBanners as $banner) {
                if ($city == $banner['PROPERTY_CITY_VALUE'])
                    $result[] = $banner['ID'];
            }
        }
        if (empty($result)) {
            foreach ($arrBanners as $banner) {
                if (empty($banner['PROPERTY_CITY_VALUE']))
                    $result[] = $banner['ID'];
            }
        }
        if (empty($result))
            $result = [0];

        return $result;
    }

	    public static function getLinzSliderIdsByCity($city = '')
    {
        $result = $arrBanners = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = IBLOCK_ID__LINZSLIDER;
        $cachePath = '/getLinzSliderIdsByCity/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arrBanners = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__LINZSLIDER, 'ACTIVE' => 'Y'],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_CITY']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arrBanners[] = $arElem;
            }

            $obCache->EndDataCache($arrBanners);
        }

        if (!empty($city)) {
            foreach ($arrBanners as $banner) {
                if ($city == $banner['PROPERTY_CITY_VALUE'])
                    $result[] = $banner['ID'];
            }
        }
        if (empty($result)) {
            foreach ($arrBanners as $banner) {
                if (empty($banner['PROPERTY_CITY_VALUE']))
                    $result[] = $banner['ID'];
            }
        }
        if (empty($result))
            $result = [0];

        return $result;
    }

    public static function getActionIdsByCity($city = '')
    {
        $result = $arrActions = [0];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = IBLOCK_ID__ACTION;
        $cachePath = '/getActionIdsByCity/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arrActions = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $arrActions = [];
            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__ACTION, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_CITY']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arrActions[] = $arElem;
            }

            $obCache->EndDataCache($arrActions);
        }

        if (!empty($city)) {
            foreach ($arrActions as $action) {
                if ($city == $action['PROPERTY_CITY_VALUE'])
                    $result[] = $action['ID'];
            }
        }
        if (empty($result)) {
            foreach ($arrActions as $action) {
                if (empty($action['PROPERTY_CITY_VALUE']))
                    $result[] = $action['ID'];
            }
        }
        if (empty($result))
            $result = [0];

        return $result;
    }

    // miv

    public static function getLinzIdsByCity($city = '')
    {
        $result = $arrActions = [];

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        $cacheID = IBLOCK_ID__LINSES_ARTICLES;
        $cachePath = '/getLinzIdsByCity/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $arrActions = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $arrActions = [];
            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__LINSES_ARTICLES, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_CITY']
            );
            while ($arElem = $rsElem->Fetch()) {
                $arrActions[] = $arElem;
            }

            $obCache->EndDataCache($arrActions);
        }

        if (!empty($city)) {
            foreach ($arrActions as $action) {
                if ($city == $action['PROPERTY_CITY_VALUE'])
                    $result[] = $action['ID'];
            }
        }
        if (empty($result)) {
            foreach ($arrActions as $action) {
                if (empty($action['PROPERTY_CITY_VALUE']))
                    $result[] = $action['ID'];
            }
        }
        if (empty($result))
            $result = [0];

        return $result;
    }
    //

//хз
    public static function changeSpbHead( &$content ) {
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		if(!$request->isAdminSection()) //< ^ если не в админке
		{
			if ( SITE_ID == 's2' || $_SESSION['GEO_IP']['NAME'] == 'Санкт-Петербург' ) {
				$searchFrom = array('Москве и Санкт-Петербурге', 'с Москвы', 'в Москве', 'в Москву', 'по Москве', 'Москва');
				$replaceTo = array('Санкт-Петербурге', 'с Санкт-Петербурга', 'в Санкт-Петербурге', 'в Санкт-Петербург', 'по Санкт-Петербургу', 'Санкт-Петербург');

				$arr = explode('<body>', $content);
				$arr[0] = str_replace($searchFrom, $replaceTo, $arr[0]);

				$content = implode('<body>', $arr);
				unset($arr);
			}
			if ( SITE_ID == 'm2' || $_SESSION['GEO_IP']['NAME'] == 'Уфа' ) {
				$searchFrom = array('Москве и Санкт-Петербурге', 'с Москвы', 'в Москве', 'в Москву', 'по Москве', 'Москва');
				$replaceTo = array('Уфе', 'с Уфы', 'в Уфе', 'в Уфу', 'по Уфе', 'Уфа');

				$arr = explode('<body>', $content);
				$arr[0] = str_replace($searchFrom, $replaceTo, $arr[0]);

				$content = implode('<body>', $arr);
				unset($arr);
			}
			$content = str_replace(" type=\"text/javascript\"", "", $content);
			$content = str_replace(" type='text/javascript'", "", $content);
			$content = preg_replace("/<link(.*?)\/>/i", '<link$1>', $content);
		}
    }

    public function OnSuccessCatalogImport1CFunctions(){
        // file_put_contents('/var/www/chernika/prod/upload/1c_bx.log', date('d.m.Y H:i:s') . ' - \PDV\Tools::OnSuccessCatalogImport1CFunctions()'.PHP_EOL, FILE_APPEND);
        self::setPropTp();
        self::createSitemap();

        return "";
    }

    public function OnSuccessCatalogImport1C(){
        // file_put_contents('/var/www/chernika/prod/upload/1c_bx.log', date('d.m.Y H:i:s') . ' - \PDV\Tools::OnSuccessCatalogImport1C()'.PHP_EOL, FILE_APPEND);
        \CAgent::AddAgent(
            "\PDV\Tools::OnSuccessCatalogImport1CFunctions();",
            "",
            "Y",
            86400,
            "",
            "Y",
            date('d.m.Y H:i:s', time() + 10)
        );
    }

    public static function showPrice($arr)
    {
        $result = true;

        $obCache = new \CPHPCache();
        $cacheLifetime = CHACHE_LIFE_TIME;
        if ($arr['PROPERTIES']['BRAND']['VALUE'] > 0) {
            $cacheID = serialize(IBLOCK_ID__BRAND . $arr['PROPERTIES']['BRAND']['VALUE']);
            $brandValue = $arr['PROPERTIES']['BRAND']['VALUE'];
        } elseif ($arr['PROPERTY_BRAND_VALUE'] > 0) {
            $cacheID = serialize(IBLOCK_ID__BRAND . $arr['PROPERTY_BRAND_VALUE']);
            $brandValue = $arr['PROPERTY_BRAND_VALUE'];
        }
        $cachePath = '/showPrice/' . $cacheID;

        if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)) {
            $result = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            Loader::includeModule('iblock');

            $db_props = \CIBlockElement::GetProperty(
                IBLOCK_ID__BRAND,
                $brandValue,
                ['sort' => 'asc'],
                ['CODE' => 'NOT_SHOW_PRICE']
            );
            if ($ar_props = $db_props->Fetch()) {
                if (!empty($ar_props['VALUE']))
                    $result = false;
            }

            $obCache->EndDataCache($result);
        }

        return $result;
    }

    public static function resizeImageForRetina($image = 0, $imgWidth, $imgHeight, $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL, $filters = []) {
        if(!empty($image) && is_array($image))
            $arImage = $image;
        else
            $arImage = (int)$image > 0 ? \CFile::GetFileArray($image) : static::getNoPhotoImgArr();

        $resultArr = [];
        $resultArr['1X'] =
            array_change_key_case(\CFile::ResizeImageGet($arImage, ['width' => $imgWidth, 'height' => $imgHeight], $resizeType, true, $filters), CASE_UPPER);
        if ($arImage['WIDTH'] >= ($imgWidth * 2)) {
            $resultArr['2X'] =
                array_change_key_case(\CFile::ResizeImageGet($arImage, ['width' => ($imgWidth * 2), 'height' => ($imgHeight * 2)], $resizeType, true, $filters), CASE_UPPER);
        }

        return $resultArr;
    }

    public static function getNoPhotoImgArr() {
        $noPhotoImg = '/upload/no-photo/no_photo.png';

        $arFile = [];
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . $noPhotoImg)) {
            $arSize = getimagesize($_SERVER['DOCUMENT_ROOT'] . $noPhotoImg);
            $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $noPhotoImg);
            $arFile['FILE_NAME'] = $arFile['name'];
            $arFile['ORIGINAL_NAME'] = $arFile['name'];
            $arFile['FILE_SIZE'] = filesize($_SERVER['DOCUMENT_ROOT'] . $noPhotoImg);
            $arFile['WIDTH'] = $arSize[0];
            $arFile['HEIGHT'] = $arSize[1];
            $arFile['CONTENT_TYPE'] = $arFile['type'];
            $arFile['SRC'] = $noPhotoImg;
            $arFile['SUBDIR'] = 'no-photo';
        }

        return $arFile;
    }

    public static function ceilCoefficient($number, $rate = 50) {
        $number = ceil($number);
        $rest = ceil($number / $rate) * $rate;
        return $rest;
    }
}