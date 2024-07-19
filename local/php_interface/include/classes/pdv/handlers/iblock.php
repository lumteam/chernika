<?
namespace PDV\Handlers;

use \Bitrix\Main\Loader;

class Iblock {
    protected static $handlerDisallow = 0;

    public static function disableHandler()
    {
        self::$handlerDisallow--;
    }

    public static function enableHandler()
    {
        self::$handlerDisallow++;
    }

    public static function isEnabledHandler()
    {
        return (self::$handlerDisallow >= 0);
    }

    private static function getCatalogProduct( $ID, $iblockId ) {
        Loader::includeModule('iblock');
        $id = 0;
        $xmlID = '';
        $rsElem = \CIBlockElement::GetList(
            array(),
            array('IBLOCK_ID' => $iblockId, 'ID' => $ID),
            false,
            array('nPageSize' => 1),
            array('XML_ID')
        );
        if ( $arElem = $rsElem->GetNext() ) {
            if ( stripos($arElem['XML_ID'], '#') !== false ) {
                $arr = explode('#', $arElem['XML_ID']);
                $xmlID = trim($arr[0]);
            }
            else
                $xmlID = $arElem['XML_ID'];
        }

        if ( !empty($xmlID) ) {
            $rsElem = \CIBlockElement::GetList(
                array(),
                array('IBLOCK_ID' => IBLOCK_ID__CATALOG, '=XML_ID' => $xmlID),
                false,
                array('nPageSize' => 1),
                array('ID')
            );
            if ( $arElem = $rsElem->GetNext() )
                $id = $arElem['ID'];
        }

        return $id;
    }

    public static function setPriceProduct( $ID ){
        if ( $ID > 0 ) {
            Loader::includeModule('catalog');
            $iblockId = \CIBlockElement::GetIBlockByID($ID);

            if ( in_array($iblockId, array(12,13,14,15)) ) {
                $prodId = self::getCatalogProduct($ID, $iblockId);
                if ( $prodId > 0 ) {
                    $resPrice = \CPrice::GetList(
                        array(),
                        array('PRODUCT_ID' => $ID, 'CATALOG_GROUP_ID' => 2)
                    );
                    if ( $arrPrice = $resPrice->Fetch() ) {
                        $res = \CPrice::GetList(
                            array(),
                            array('PRODUCT_ID' => $prodId, 'CATALOG_GROUP_ID' => 1)
                        );
                        if ( $arr = $res->Fetch() )
                            \CPrice::Update(
                                $arr['ID'],
                                array('PRICE' => $arrPrice['PRICE'])
                            );
                        else
                            \CPrice::Add(array(
                                'PRODUCT_ID' => $prodId,
                                'CATALOG_GROUP_ID' => 1,
                                'PRICE' => $arrPrice['PRICE'],
                                'CURRENCY' => 'RUB'
                            ));
                    }
                }
            }
        }
    }

    public static function setCountProduct( $ID ){
        if ( $ID > 0 ) {
            Loader::includeModule('catalog');
            $iblockId = \CIBlockElement::GetIBlockByID($ID);

            if ( in_array($iblockId, array(12,13,14,15)) ) {
                $prodId = self::getCatalogProduct($ID, $iblockId);
                if ( $prodId > 0 ) {
                    $resCatP = \CCatalogProduct::GetList(
                        array(),
                        array('ID' => $ID),
                        false,
                        array('nTopCount' => 1)
                    );
                    if ( $arresCatP = $resCatP->Fetch() ) {
                        $resCat = \CCatalogProduct::GetList(
                            array(),
                            array('ID' => $prodId),
                            false,
                            array('nTopCount' => 1)
                        );
                        if ( $arresCat = $resCat->Fetch() )
                            \CCatalogProduct::Update(
                                $arresCat['ID'],
                                array(
                                    'WEIGHT' => $arresCatP['WEIGHT'],
                                    'QUANTITY' => $arresCatP['QUANTITY'],
                                    'LENGTH' => $arresCatP['LENGTH'],
                                    'WIDTH' => $arresCatP['WIDTH'],
                                    'HEIGHT' => $arresCatP['HEIGHT']
                                )
                            );
                        else
                            \CCatalogProduct::Add(array(
                                'ID' => $prodId,
                                'WEIGHT' => $arresCatP['WEIGHT'],
                                'QUANTITY' => $arresCatP['QUANTITY'],
                                'LENGTH' => $arresCatP['LENGTH'],
                                'WIDTH' => $arresCatP['WIDTH'],
                                'HEIGHT' => $arresCatP['HEIGHT']
                            ));
                    }
                }
            }
        }
    }

    public static function updatePrice( $ID, $arFields ){
        //self::setPriceProduct( $arFields['PRODUCT_ID'] );
        self::changeParamProduct( $ID );
        self::setPriceFilter( $ID );
    }

    public static function updateCount( $ID, $arFields ){
        //self::setCountProduct( $ID );
        self::changeParamProduct( $ID );
    }

    public static function changeParamProduct( $ID ) {
        if ( $ID > 0 ) {
            Loader::includeModule('iblock');
            Loader::includeModule('catalog');
            $iblockId = \CIBlockElement::GetIBlockByID($ID);
            global $USER;
            $userID = $USER->GetID();

            if ( in_array($iblockId, array(IBLOCK_ID__CATALOG, IBLOCK_ID__CATALOG_2)) ) {
                $rsElem = \CIBlockElement::GetList(
                    array(),
                    array('IBLOCK_ID' => $iblockId, 'ID' => $ID),
                    false,
                    array('nPageSize' => 1)
                );
                if ( $arElemObj = $rsElem->GetNextElement() ) {
                    $arElem = $arElemObj->GetFields();
                    $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                    $active = 'Y';
                    if ( empty($arElem['PREVIEW_PICTURE']) && empty($arElem['DETAIL_PICTURE']) && empty($arElem['PROPERTIES']['MORE_PHOTO']['VALUE']) )
                        $active = 'N';

                    $iblockTpId = IBLOCK_ID__CATALOG_TP;
                    if ( $iblockId == IBLOCK_ID__CATALOG_2 )
                        $iblockTpId = IBLOCK_ID__CATALOG_TP_2;

                    $count = 0;
                    $price = 0;
                    $priceMskSpb = 0;
                    $rsElement = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => $iblockTpId, 'PROPERTY_CML2_LINK' => $arElem['ID']),
                        false,
                        false,
                        array('ID', 'ACTIVE')
                    );
                    if ( $rsElement->SelectedRowsCount() > 0 ) {
                        while ( $arElement = $rsElement->GetNext() ) {
                            if ( $arElement['ACTIVE'] == 'Y' ) {
                                $resCat = \CCatalogProduct::GetList(
                                    array(),
                                    array('ID' => $arElement['ID']),
                                    false,
                                    array('nTopCount' => 1)
                                );
                                if ( $arresCat = $resCat->Fetch() )
                                    $count += $arresCat['QUANTITY'];

                                $arPrice = \CCatalogProduct::GetOptimalPrice($arElement['ID'], 1);
                                $price += $arPrice['DISCOUNT_PRICE'];

                                $priceMskArr = \PDV\Tools::getMskSpbPrice($arElement['ID']);
                                $priceMskSpb += $priceMskArr['PRICE'];
                            }
                        }
                    }
                    else {
                        $resCat = \CCatalogProduct::GetList(
                            array(),
                            array('ID' => $arElem['ID']),
                            false,
                            array('nTopCount' => 1)
                        );
                        if ( $arresCat = $resCat->Fetch() )
                            $count = $arresCat['QUANTITY'];

                        $arPrice = \CCatalogProduct::GetOptimalPrice($arElem['ID'], 1);
                        $price = $arPrice['DISCOUNT_PRICE'];

                        $priceMskArr = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                        $priceMskSpb = $priceMskArr['PRICE'];
                    }

                    $sort = 1500;
                    $sortMskSpb = 1500;
                    if ( $count > 0 && $price > 0 )
                        $sort = 500;
                    if ( $count > 0 && $priceMskSpb > 0 )
                        $sortMskSpb = 500;

                    \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $sortMskSpb, 'SORT');
                    \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $sort, 'SORT_ALL');

                    if ( !empty($arElem['PROPERTIES']['SALE_50']['VALUE']) || !empty($arElem['PROPERTIES']['SALE_40']['VALUE']) || !empty($arElem['PROPERTIES']['SALE_60']['VALUE']) || !empty($arElem['PROPERTIES']['SALE_70']['VALUE']) ) {
                        if ( $iblockId == IBLOCK_ID__CATALOG )
                            \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, ['VALUE' => 2373], 'SALE');
                        elseif ( $iblockId == IBLOCK_ID__CATALOG_2 )
                            \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, ['VALUE' => 2392], 'SALE');
                    }
                    else
                        \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, '', 'SALE');

                    \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex($iblockId, $arElem['ID']);

                    if ( $active != $arElem['ACTIVE'] && $active == 'N' ) {
                        if ( !self::isEnabledHandler() )
                            return;

                        self::disableHandler();

                        $el = new \CIBlockElement;
                        $el->Update(
                            $arElem['ID'],
                            [
                                'ACTIVE' => $active
                            ]
                        );

                        self::enableHandler();
                    }

                    if($userID == 21 && !empty($arElem['PROPERTIES']['NAME_TMP']['VALUE'])) {
                        if ( !self::isEnabledHandler() )
                            return;

                        self::disableHandler();

                        $el = new \CIBlockElement;
                        $el->Update(
                            $arElem['ID'],
                            [
                                'NAME' => $arElem['PROPERTIES']['NAME_TMP']['VALUE']
                            ]
                        );

                        self::enableHandler();

                    }
                    else{
                        \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $arElem['NAME'], 'NAME_TMP');
                    }

                }
            }
            elseif ( in_array($iblockId, array(IBLOCK_ID__CATALOG_TP, IBLOCK_ID__CATALOG_TP_2)) ) {
                $mxResult = \CCatalogSku::GetProductInfo($ID);
                $needId = $mxResult['ID'];

                $needIblockId = IBLOCK_ID__CATALOG;
                if ( $iblockId == IBLOCK_ID__CATALOG_TP_2 )
                    $needIblockId = IBLOCK_ID__CATALOG_2;

                $rsElem = \CIBlockElement::GetList(
                    array(),
                    array('IBLOCK_ID' => $needIblockId, 'ID' => $needId),
                    false,
                    array('nPageSize' => 1),
                    array('ID', 'SORT')
                );
                if ( $arElem = $rsElem->GetNext() ) {
                    $count = 0;
                    $price = 0;
                    $priceMskSpb = 0;
                    $rsElement = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => $iblockId, 'PROPERTY_CML2_LINK' => $arElem['ID']),
                        false,
                        false,
                        array('ID', 'ACTIVE', 'PROPERTY_NAME_TMP')
                    );
                    while ( $arElement = $rsElement->GetNext() ) {
                        if ( $arElement['ACTIVE'] == 'Y' ) {
                            $resCat = \CCatalogProduct::GetList(
                                array(),
                                array('ID' => $arElement['ID']),
                                false,
                                array('nTopCount' => 1)
                            );
                            if ( $arresCat = $resCat->Fetch() )
                                $count += $arresCat['QUANTITY'];

                            $arPrice = \CCatalogProduct::GetOptimalPrice($arElement['ID'], 1);
                            $price += $arPrice['DISCOUNT_PRICE'];

                            $priceMskArr = \PDV\Tools::getMskSpbPrice($arElement['ID']);
                            $priceMskSpb += $priceMskArr['PRICE'];


                            if($userID == 21 && !empty($arElement['PROPERTIES']['NAME_TMP']['VALUE'])) {
                                if ( !self::isEnabledHandler() )
                                    return;

                                self::disableHandler();

                                $el = new \CIBlockElement;
                                $el->Update(
                                    $arElement['ID'],
                                    [
                                        'NAME' => $arElement['PROPERTY_NAME_TMP_VALUE']
                                    ]
                                );

                                self::enableHandler();

                            }
                            else
                            {
                                \CIBlockElement::SetPropertyValues($arElement['ID'], $iblockId, $arElement['NAME'], 'NAME_TMP');
                            }


                        }
                    }

                    $sort = 1500;
                    $sortMskSpb = 1500;
                    if ( $count > 0 && $price > 0 )
                        $sort = 500;
                    if ( $count > 0 && $priceMskSpb > 0 )
                        $sortMskSpb = 500;

                    \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $sortMskSpb, 'SORT');
                    \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $sort, 'SORT_ALL');


                    \CIBlockElement::SetPropertyValues($arElem['ID'], $iblockId, $arElem['NAME'], 'NAME_TMP');

                }
            }
        }
    }

    public static function updateElement( $arFields ) {
        //self::setPriceProduct( $arFields['ID'] );
        //self::setCountProduct( $arFields['ID'] );
        self::changeParamProduct( $arFields['ID'] );
        self::setPriceFilter( $arFields['ID'] );
        //self::setTPProps( $arFields['ID'] );
    }

    public static function updateElementValues( $ELEMENT_ID ) {
        //self::setTPProps( $ELEMENT_ID );
    }

    public static function MyOnAdminListDisplay( &$list )
    {
        $iblockId = intval($_REQUEST['IBLOCK_ID']);
        global $APPLICATION;
        if ( $iblockId === IBLOCK_ID__CATALOG && $APPLICATION->GetCurPage() == '/bitrix/admin/iblock_element_admin.php' ) {
            $list->aVisibleHeaders["IBLOCK_SECTION"] =
                array(
                    "id" => "IBLOCK_SECTION",
                    "content" => 'Привязка к разделам',
                    "sort" => false,
                    "default" => true,
                    "align" => "left",
                );

            $list->arVisibleColumns[] = 'IBLOCK_SECTION';

            $sectionArrTree = [];
            $rsSections = \CIBlockSection::GetTreeList(
                array("IBLOCK_ID" => $iblockId),
                array("ID", "NAME", "DEPTH_LEVEL")
            );
            while ( $ar = $rsSections->GetNext() )
            {
                $sectionArrTree[] = $ar;
            }

            foreach ( $list->aRows as $row ) {
                $elementId = intval(str_replace('E', '', $row->id));
                if ( $elementId > 0 ) {
                    $sections = [];
                    $sectionCurrent = [];
                    $rsSect = \CIBlockElement::GetElementGroups($elementId, false, array('ID', 'NAME', 'IBLOCK_ID'));
                    while ( $arSect = $rsSect->Fetch() ) {
                        if ( $arSect['IBLOCK_ID'] == $iblockId ) {
                            $sections[] = $arSect['NAME'] . ' [<a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . $iblockId . '&type=' . htmlspecialchars($_REQUEST['type']) . '&lang=' . htmlspecialchars($_REQUEST['lang']) . '&find_section_section=' . $arSect['ID'] . '" title="Перейти к списку элементов раздела">' . $arSect['ID'] . '</a>]';

                            $sectionCurrent[] = $arSect['ID'];
                        }
                    }

                    $row->addField(
                        'IBLOCK_SECTION',
                        implode(' / ', $sections),
                        true
                    );

                    $sectionTree = '<select name="IBLOCK_SECTION['.$elementId.'][]" multiple><option value="-1">нет</option><option value="0">Верхний уровень</option>';
                    foreach ( $sectionArrTree as $ar )
                    {
                        $sel = '';
                        if ( in_array($ar['ID'], $sectionCurrent) )
                            $sel = ' selected';

                        $sectionTree .= '<option value="'.$ar["ID"].'"'.$sel.'>'.str_repeat(" . ", $ar["DEPTH_LEVEL"]).$ar["NAME"].'</option>';
                    }
                    $sectionTree .= '</select>';

                    $row->AddEditField(
                        'IBLOCK_SECTION',
                        $sectionTree
                    );
                }
            }
        }
    }

    public static function setPriceFilter( $ID ){
        if ( $ID > 0 ) {
            Loader::includeModule('iblock');
            Loader::includeModule('catalog');
            $iblockId = \CIBlockElement::GetIBlockByID($ID);

            if ( in_array($iblockId, [IBLOCK_ID__CATALOG, IBLOCK_ID__CATALOG_TP]) ) {
                if ( $iblockId == IBLOCK_ID__CATALOG )
                    $needId = $ID;
                elseif ( $iblockId == IBLOCK_ID__CATALOG_TP ) {
                    $mxResult = \CCatalogSku::GetProductInfo($ID);
                    $needId = $mxResult['ID'];
                }

                if ( $needId > 0 ) {
                    $prices = [];
                    $pricesMskSpb = [];
                    $rsElem = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP, 'PROPERTY_CML2_LINK' => $needId),
                        false,
                        false,
                        array('ID')
                    );
                    while ( $arElem = $rsElem->GetNext() ) {
                        $salePrice = \PDV\Tools::getSalePrice($arElem['ID']);
                        if ( $salePrice > 0 )
                            $prices[] = \PDV\Tools::getSalePrice($arElem['ID']);

                        $priceMskArr = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                        $priceMsk = \PDV\Tools::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                        if ( $priceMsk > 0 )
                            $pricesMskSpb[] = $priceMsk;
                    }

                    if ( empty($prices) && empty($pricesMskSpb) ) {
                        $prices[] = \PDV\Tools::getSalePrice($needId);

                        $priceMskArr = \PDV\Tools::getMskSpbPrice($needId);
                        $priceMsk = \PDV\Tools::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                        $pricesMskSpb[] = $priceMsk;
                    }

                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG, min($prices), 'PRICE');
                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG, min($pricesMskSpb), 'PRISE');

                    \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(IBLOCK_ID__CATALOG, $needId);
                }
            }
            elseif ( in_array($iblockId, [IBLOCK_ID__CATALOG_2, IBLOCK_ID__CATALOG_TP_2]) ) {
                if ( $iblockId == IBLOCK_ID__CATALOG_2 )
                    $needId = $ID;
                elseif ( $iblockId == IBLOCK_ID__CATALOG_TP_2 ) {
                    $mxResult = \CCatalogSku::GetProductInfo($ID);
                    $needId = $mxResult['ID'];
                }

                if ( $needId > 0 ) {
                    $prices = [];
                    $pricesMskSpb = [];
                    $rsElem = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP_2, 'PROPERTY_CML2_LINK' => $needId),
                        false,
                        false,
                        array('ID')
                    );
                    while ( $arElem = $rsElem->GetNext() ) {
                        $salePrice = \PDV\Tools::getSalePrice($arElem['ID']);
                        if ( $salePrice > 0 )
                            $prices[] = \PDV\Tools::getSalePrice($arElem['ID']);

                        $priceMskArr = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                        $priceMsk = \PDV\Tools::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                        if ( $priceMsk > 0 )
                            $pricesMskSpb[] = $priceMsk;
                    }

                    if ( empty($prices) && empty($pricesMskSpb) ) {
                        $prices[] = \PDV\Tools::getSalePrice($needId);

                        $priceMskArr = \PDV\Tools::getMskSpbPrice($needId);
                        $priceMsk = \PDV\Tools::getSalePrice($arElem['ID'], $priceMskArr['ID'], $priceMskArr['PRICE']);
                        $pricesMskSpb[] = $priceMsk;
                    }

                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG_2, min($prices), 'PRICE');
                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG_2, min($pricesMskSpb), 'PRISE');
                    \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(IBLOCK_ID__CATALOG_2, $needId);
                }
            }
        }
    }

    private static function setTPProps( $ID ) {
        if ( $ID > 0 ) {
            Loader::includeModule('iblock');
            Loader::includeModule('catalog');
            $iblockId = \CIBlockElement::GetIBlockByID($ID);

            if ( $iblockId == IBLOCK_ID__CATALOG_TP ) {
                $mxResult = \CCatalogSku::GetProductInfo($ID);
                $needId = $mxResult['ID'];

                if ( $needId > 0 ) {
                    $colors = [];
                    $rsElem = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP, 'PROPERTY_CML2_LINK' => $needId),
                        false,
                        false,
                        array('PROPERTY_COLOR')
                    );
                    while ( $arElem = $rsElem->GetNext() ) {
                        if ( !empty($arElem['PROPERTY_COLOR_VALUE']) )
                            $colors[] = $arElem['PROPERTY_COLOR_VALUE'];
                    }

                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG, $colors, 'COLOR');
                }
            }
            elseif ( $iblockId == IBLOCK_ID__CATALOG_TP_2 ) {
                $mxResult = \CCatalogSku::GetProductInfo($ID);
                $needId = $mxResult['ID'];

                if ( $needId > 0 ) {
                    $colors = [];
                    $rsElem = \CIBlockElement::GetList(
                        array(),
                        array('IBLOCK_ID' => IBLOCK_ID__CATALOG_TP_2, 'PROPERTY_CML2_LINK' => $needId),
                        false,
                        false,
                        array('PROPERTY_COLOR')
                    );
                    while ( $arElem = $rsElem->GetNext() ) {
                        if ( !empty($arElem['PROPERTY_COLOR_VALUE']) )
                            $colors[] = $arElem['PROPERTY_COLOR_VALUE'];
                    }

                    \CIBlockElement::SetPropertyValues($needId, IBLOCK_ID__CATALOG_2, $colors, 'COLOR');
                }
            }
        }
    }

    public static function onBeforeIBlockElementUpdate(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == IBLOCK_ID__CATALOG_2)
        {
            global $USER;

            if ($USER->GetID() == USER_1C_ID)
            {
                if (($arFields['IBLOCK_SECTION_ID'] && $arFields['IBLOCK_SECTION_ID'] != SECTION_ID__CATALOG_3)
                    || ($arFields['IBLOCK_SECTION'] && !in_array(SECTION_ID__CATALOG_3, $arFields['IBLOCK_SECTION']))
                    || !($arFields['IBLOCK_SECTION_ID'] || $arFields['IBLOCK_SECTION']))
                {
                    $_ibe = \CIBlockElement::GetElementGroups($arFields['ID']);
                    $_sec_ids = [];
                    
                    while ($_ibe_arr = $_ibe->Fetch())
                        $_sec_ids[] = $_ibe_arr['ID'];

                    if (in_array(SECTION_ID__CATALOG_3, $_sec_ids))
                    {
                        if (!isset($arFields['IBLOCK_SECTION']))
                            $arFields['IBLOCK_SECTION'] = [];
                        $arFields['IBLOCK_SECTION'][] = SECTION_ID__CATALOG_3;
                    }
                }
            }
        }
    }
}