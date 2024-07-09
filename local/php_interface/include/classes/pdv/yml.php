<?php
namespace PDV;

use \Bitrix\Main\Loader;

class YML {
    private static function yandex_replace_special($arg)
    {
        if (in_array($arg[0], array("&quot;", "&amp;", "&lt;", "&gt;")))
            return $arg[0];
        else
            return " ";
    }

    private static function iconvToW1251( $text ){
        global $APPLICATION;

        return $APPLICATION->ConvertCharset($text, LANG_CHARSET, 'windows-1251');
    }

    private static function getDetailPageUrl($arr, $iblockId) {
        $sectionCode = 'eyeglass-frames';
        if ( $iblockId == IBLOCK_ID__CATALOG_2 )
            $sectionCode = 'sunglasses';

        return '/'.$sectionCode.'/'.$arr['CODE'].'/';
    }

    private static function yandex_text2xml($text, $bHSC = false, $bDblQuote = false)
    {
        $bHSC = (true == $bHSC ? true : false);
        $bDblQuote = (true == $bDblQuote ? true: false);

        if ($bHSC)
        {
            $text = htmlspecialcharsbx($text);
            if ($bDblQuote)
                $text = str_replace('&quot;', '"', $text);
        }
        $text = preg_replace('/[\x01-\x08\x0B-\x0C\x0E-\x1F]/', "", $text);
        $text = str_replace("'", "&apos;", $text);
        $text = str_replace("&", "&amp;", $text);
        $text = self::iconvToW1251($text);

        return $text;
    }

    public static function exportYml( $SETUP_FILE_NAME, $domen, $utm_campaign = '', $withUtm = true, $siteId = 's1', $minPrice = 0, $disableBrands = '' ) {
        $disabledBrands = explode(',',$disableBrands);

        if ( empty($SETUP_FILE_NAME) || empty($domen) )
            return false;

        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $url = 'https://'.$domen;

        if ( $fp = @fopen($SETUP_FILE_NAME, "wb") )
        {
            fwrite($fp, '<?xml version="1.0" encoding="windows-1251"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">');
            fwrite($fp, "\n<yml_catalog date=\"".date("Y-m-d H:i")."\">\n");
            fwrite($fp, "<shop>\n");
            fwrite($fp, "<name>".self::iconvToW1251('Черника Оптика')."</name>\n");
            fwrite($fp, "<company>".self::iconvToW1251('ООО Союз-Оптика')."</company>\n");
            fwrite($fp, "<url>".$url."</url>\n");
            fwrite($fp, "<email>info@chernika-optika.ru</email>\n");

            fwrite($fp, "<currencies>\n");
            fwrite($fp, "<currency id=\"RUB\" rate=\"1\"></currency>\n");
            fwrite($fp, "</currencies>\n");

            $arrPols = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SEX);
            $arrFrameTypes = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__FORMS);
            $arrStyles = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__STYLES);
            $arrMaterials = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__MATERIALS);
            $arrColors = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR);

            $allBrands = [];
            $rsElem = \CIBlockElement::GetList(
                array('sort' => 'asc', 'name' => 'asc'),
                array('IBLOCK_ID' => IBLOCK_ID__BRAND, 'ACTIVE' => 'Y'),
                false,
                false,
                array('ID', 'NAME')
            );
            while ( $arElem = $rsElem->GetNext() ) {
                $allBrands[ $arElem['ID'] ] = $arElem['NAME'];
            }

            $arItems = [];

            //Оправы
            $brands = [];
            $rsElem = \CIBlockElement::GetList(
                ['id' => 'asc'],
                ['IBLOCK_ID' => IBLOCK_ID__CATALOG, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'SECTION_ID' => SECTION_ID__CATALOG, 'INCLUDE_SUBSECTIONS' => 'Y'],
                false,
                false
            );
            while ( $arElemObj = $rsElem->GetNextElement() ) {
                $arElem = $arElemObj->GetFields();
                $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                if ( !empty($allBrands[ $arElem['PROPERTIES']['BRAND']['VALUE'] ]) ) {
                    if ( \PDV\Tools::showPrice($arElem) ) {
                        $arElem['PRODUCT_URL'] = self::getDetailPageUrl($arElem, IBLOCK_ID__CATALOG);

                        if ( !empty($arElem['DETAIL_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['DETAIL_PICTURE'];
                        elseif ( !empty($arElem['PREVIEW_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['PREVIEW_PICTURE'];
                        else
                            $arElem['IMAGE'] = $arElem['PROPERTIES']['MORE_PHOTO']['VALUE'][0];

                        $rsElemTP = \CIBlockElement::GetList(
                            ['id' => 'asc'],
                            ['IBLOCK_ID' => IBLOCK_ID__CATALOG_TP, 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $arElem['ID'], '>CATALOG_QUANTITY' => 0],
                            false,
                            ['nPageSize' => 1],
                            ['ID']
                        );
                        if ( $rsElemTP->SelectedRowsCount() > 0 ) {
                            while ( $arElemTP = $rsElemTP->GetNext() ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElemTP['ID']);

                                $price1 = \PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price1 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];
                                        $arItems[SECTION_ID__CATALOG][ $arElemTP['ID'] ] = [
                                            'ID' => $arElemTP['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE'],
                                            'IS_SPEC_PRICE' => $arPrice['IS_SPEC'],
                                        ];
                                    }
                                }//if price >= $minPrice
                            }
                        }
                        else {
                            $arCatalog = \CCatalogProduct::GetByID($arElem['ID']);
                            if ( $arCatalog['QUANTITY'] > 0 ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                                $price1 = \PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price1 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG][ $arElem['ID'] ] = [
                                            'ID' => $arElem['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE'],
                                            'IS_SPEC_PRICE' => $arPrice['IS_SPEC'],
                                        ];
                                    }
                                } // if price >= $minPrice
                            }
                        }
                    }
                }
            }
            $brands = array_unique($brands);

            $strTmpCat = '<category id="'.SECTION_ID__CATALOG.'">'.self::iconvToW1251('Оправы').'</category>'."\n";
            if ( !empty($brands) ) {
                foreach ( $allBrands as $id => $name ) {
                    if ( in_array($id, $brands) && !in_array($name,$disabledBrands) )
                        $strTmpCat .= '<category id="'.SECTION_ID__CATALOG.$id.'" parentId="'.SECTION_ID__CATALOG.'">'.self::yandex_text2xml('Оправы '.$name).'</category>'."\n";
                }
            }
            unset($brands);

            $idsSolnce = [];
            //Солнцезащитные очки
            $brands = [];
            $rsElem = \CIBlockElement::GetList(
                ['id' => 'asc'],
                ['IBLOCK_ID' => IBLOCK_ID__CATALOG_2, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'SECTION_ID' => SECTION_ID__CATALOG_2, 'INCLUDE_SUBSECTIONS' => 'Y'],
                false,
                false
            );
            while ( $arElemObj = $rsElem->GetNextElement() ) {
                $arElem = $arElemObj->GetFields();
                $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                if ( !empty($allBrands[ $arElem['PROPERTIES']['BRAND']['VALUE'] ]) ) {
                    if ( \PDV\Tools::showPrice($arElem) ) {
                        $arElem['PRODUCT_URL'] = self::getDetailPageUrl($arElem, IBLOCK_ID__CATALOG_2);

                        if ( !empty($arElem['DETAIL_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['DETAIL_PICTURE'];
                        elseif ( !empty($arElem['PREVIEW_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['PREVIEW_PICTURE'];
                        else
                            $arElem['IMAGE'] = $arElem['PROPERTIES']['MORE_PHOTO']['VALUE'][0];

                        $rsElemTP = \CIBlockElement::GetList(
                            ['id' => 'asc'],
                            ['IBLOCK_ID' => IBLOCK_ID__CATALOG_TP_2, 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $arElem['ID'], '>CATALOG_QUANTITY' => 0],
                            false,
                            ['nPageSize' => 1],
                            ['ID']
                        );
                        if ( $rsElemTP->SelectedRowsCount() > 0 ) {
                            while ( $arElemTP = $rsElemTP->GetNext() ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElemTP['ID']);
                                $price2 = \PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price2 >= $minPrice){
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $idsSolnce[] = $arElemTP['ID'];
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG_2][ $arElemTP['ID'] ] = [
                                            'ID' => $arElemTP['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE']
                                        ];
                                    }
                                }
                            }
                        }
                        else {
                            $arCatalog = \CCatalogProduct::GetByID($arElem['ID']);
                            if ( $arCatalog['QUANTITY'] > 0 ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                                $price2 = \PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price2 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $idsSolnce[] = $arElem['ID'];
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];
                                        $arItems[SECTION_ID__CATALOG_2][ $arElem['ID'] ] = [
                                            'ID' => $arElem['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE']
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $brands = array_unique($brands);

            $strTmpCat .= '<category id="'.SECTION_ID__CATALOG_2.'">'.self::iconvToW1251('Солнцезащитные очки').'</category>'."\n";
            if ( !empty($brands) ) {
                foreach ( $allBrands as $id => $name ) {
                    if ( in_array($id, $brands) && !in_array($name,$disabledBrands))
                        $strTmpCat .= '<category id="'.SECTION_ID__CATALOG_2.$id.'" parentId="'.SECTION_ID__CATALOG_2.'">'.self::yandex_text2xml('Солнцезащитные очки '.$name).'</category>'."\n";
                }
            }
            unset($brands);

            //Спортивные очки
            $brands = [];
            $rsElem = \CIBlockElement::GetList(
                ['id' => 'asc'],
                ['IBLOCK_ID' => IBLOCK_ID__CATALOG_2, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'SECTION_ID' => SECTION_ID__CATALOG_3, 'INCLUDE_SUBSECTIONS' => 'Y', '!ID' => $idsSolnce],
                false,
                false
            );
            while ( $arElemObj = $rsElem->GetNextElement() ) {
                $arElem = $arElemObj->GetFields();
                $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                if ( !empty($allBrands[ $arElem['PROPERTIES']['BRAND']['VALUE'] ]) ) {
                    if ( \PDV\Tools::showPrice($arElem) ) {
                        $arElem['PRODUCT_URL'] = self::getDetailPageUrl($arElem, IBLOCK_ID__CATALOG_2);

                        if ( !empty($arElem['DETAIL_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['DETAIL_PICTURE'];
                        elseif ( !empty($arElem['PREVIEW_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['PREVIEW_PICTURE'];
                        else
                            $arElem['IMAGE'] = $arElem['PROPERTIES']['MORE_PHOTO']['VALUE'][0];

                        $rsElemTP = \CIBlockElement::GetList(
                            ['id' => 'asc'],
                            ['IBLOCK_ID' => IBLOCK_ID__CATALOG_TP_2, 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $arElem['ID'], '>CATALOG_QUANTITY' => 0, '!ID' => $idsSolnce],
                            false,
                            ['nPageSize' => 1],
                            ['ID']
                        );
                        if ( $rsElemTP->SelectedRowsCount() > 0 ) {
                            while ( $arElemTP = $rsElemTP->GetNext() ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElemTP['ID']);
                                $price3 = \PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price3 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG_3][ $arElemTP['ID'] ] = [
                                            'ID' => $arElemTP['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE']
                                        ];
                                    }
                                }
                            }
                        }
                        else {
                            $arCatalog = \CCatalogProduct::GetByID($arElem['ID']);
                            if ( $arCatalog['QUANTITY'] > 0 ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                                $price3 = \PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price3 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG_3][ $arElem['ID'] ] = [
                                            'ID' => $arElem['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE']
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            unset($idsSolnce);
            $brands = array_unique($brands);

            $strTmpCat .= '<category id="'.SECTION_ID__CATALOG_3.'">'.self::iconvToW1251('Спортивные очки').'</category>'."\n";
            if ( !empty($brands) ) {
                foreach ( $allBrands as $id => $name ) {
                    if ( in_array($id, $brands) && !in_array($name,$disabledBrands))
                        $strTmpCat .= '<category id="'.SECTION_ID__CATALOG_3.$id.'" parentId="'.SECTION_ID__CATALOG_3.'">'.self::yandex_text2xml('Спортивные очки '.$name).'</category>'."\n";
                }
            }
            unset($brands);

            $strTmpOff = '';
            $strPromoOffers = '';
            foreach ( $arItems as $sectId => $arElems) {
                foreach ( $arElems as $arElem ) {
                    if ( !in_array($allBrands[$arElem['BRAND']],$disabledBrands) ) {
                        if ( $arElem['IMAGE'] > 0 ) {
                            $strTmpOff .= '<offer id="'.$arElem['ID'].'" type="vendor.model" available="true">'."\n";

                            $type = 'Оправа';
                            if ( $sectId == SECTION_ID__CATALOG_2 )
                                $type = 'Солнцезащитные очки';
                            elseif ( $sectId == SECTION_ID__CATALOG_3 )
                                $type = 'Спортивные очки';

                            $strTmpOff .= '<typePrefix>'.self::iconvToW1251($type).'</typePrefix>'."\n";
                            $strTmpOff .= '<vendor>'.self::yandex_text2xml($allBrands[ $arElem['BRAND'] ]).'</vendor>'."\n";
                            $strTmpOff .= '<vendorCode>'.self::yandex_text2xml($arElem['CML2_ARTICLE']).'</vendorCode>'."\n";
                            $strTmpOff .= '<model>'.self::yandex_text2xml($arElem['CML2_ARTICLE']).'</model>'."\n";

                            $urlProd = $url.$arElem['PRODUCT_URL'];
                            if ( $withUtm ) {
                                $urlProd .= self::yandex_text2xml('?utm_source=ya.market&utm_medium=cpc&utm_campaign='.$utm_campaign);
                                $urlProd .= self::yandex_text2xml('&utm_term='.str_replace(' ','%20', implode('_', [$arElem['ID'],$type,$allBrands[ $arElem['BRAND'] ],$arElem['CML2_ARTICLE']])));
                            }

                            $strTmpOff .= '<url>'.$urlProd.'</url>'."\n";

                            
                            $strTmpOff .= '<count>1</count> ';
                            $strTmpOff .= '<weight>0.3</weight>';
                            $strTmpOff .= '<dimensions>20/9/5</dimensions>';
                            

                            $params = [];
                            $params['Производитель'][] = self::yandex_text2xml($allBrands[ $arElem['BRAND'] ]);

                            foreach ( $arElem['POL'] as $pol) {
                                if ( !empty($arrPols[$pol]['UF_NAME']) )
                                    $params['Пол'][] = self::yandex_text2xml($arrPols[$pol]['UF_NAME']);
                            }

                            foreach ( $arElem['STYLE'] as $st ) {
                                if ( !empty($arrStyles[$st]['UF_NAME']) )
                                    $params['Форма оправы'][] = self::yandex_text2xml($arrStyles[$st]['UF_NAME']);
                            }

                            if ( !empty($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']) )
                                $params['Конструкция'][] = self::yandex_text2xml($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']);

                            foreach ( $arElem['MATERIAL'] as $material ) {
                                if ( !empty($arrMaterials[$material]['UF_NAME']) )
                                    $params['Материал оправы'][] = self::yandex_text2xml($arrMaterials[$material]['UF_NAME']);
                            }

                            foreach ( $arElem['COLOR'] as $color ) {
                                if ( !empty($arrColors[$color]['UF_NAME']) )
                                    $params['Цвет'][] = self::yandex_text2xml($arrColors[$color]['UF_NAME']);
                            }

                            $description = '';
                            if ( !emptY($params) ) {
                                $description = '<![CDATA[<ul>';
                                $i = 1;
                                foreach ( $params as $name => $param ) {
                                    $description .= '<li>'.self::yandex_text2xml($name).': '.implode(', ',$param).'</li>';
                                    if ( $i < count($params) ) $description .= '<br/>';
                                    $i++;
                                }
                                $description .= '</ul>]]>';
                            }
                            unset($params);
                            $strTmpOff .= '<description>'.$description.'</description>'."\n";

                            if ( $arElem['PRICE'] <> $arElem['SALE_PRICE'] ) {
                                $strTmpOff .= '<price>'.\PDV\Tools::ceilCoefficient($arElem['SALE_PRICE']).'</price>'."\n";
                                $strTmpOff .= '<oldprice>'.\PDV\Tools::ceilCoefficient($arElem['PRICE']).'</oldprice>'."\n";
                            }
                            else
                                $strTmpOff .= '<price>'.\PDV\Tools::ceilCoefficient($arElem['PRICE']).'</price>'."\n";

                            $strTmpOff .= '<currencyId>RUB</currencyId>'."\n";

                            $strTmpOff .= '<categoryId>'.$sectId.$arElem['BRAND'].'</categoryId>'."\n";

                            $strTmpOff .= '<picture>'.$url.\CFile::GetPath($arElem['IMAGE']).'</picture>'."\n";

                            $strTmpOff .= '<store>true</store>'."\n";
                            $strTmpOff .= '<delivery>true</delivery>'."\n";
                            $strTmpOff .= '<pickup>true</pickup>'."\n";

                            if ( $arElem['SALE_PRICE'] > 6000 ) {
                                $strTmpOff .= '<delivery-options>'."\n";
                                $strTmpOff .= '<option cost="0" days="0-2"/>'."\n";
                                $strTmpOff .= '</delivery-options>'."\n";
                            }

                            $strTmpOff .= '<manufacturer_warranty>true</manufacturer_warranty>'."\n";

                            // if (1 === (int) $arElem['IS_SPEC_PRICE']) {
                            //     $specPriceValue = ($arElem['PRICE'] <> $arElem['SALE_PRICE'] ? $arElem['SALE_PRICE'] : $arElem['PRICE']);
                            //
                            //     $strTmpOff .= '<sales_notes>' . $specPriceValue . self::yandex_text2xml('₽ — цена на оправу при заказе с линзами') . '</sales_notes>' . "\n";
                            //
                            //     $strPromoOffers .= '<product offer-id="'.$arElem['ID'].'">'."\n";
                            //     $strPromoOffers .= '<discount-price currency="RUR">'.$specPriceValue.'</discount-price>'."\n";
                            //     $strPromoOffers .= '</product>'."\n";
                            // } else {
                                $strTmpOff .= '<sales_notes>'.self::yandex_text2xml('Оплата после получения и примерки').'</sales_notes>'."\n";
                            // }

                            foreach ( $arElem['POL'] as $pol) {
                                if ( !empty($arrPols[$pol]['UF_NAME']) )
                                    $strTmpOff .= '<param name="'.self::yandex_text2xml('Пол').'">'.self::yandex_text2xml($arrPols[$pol]['UF_NAME']).'</param>'."\n";
                            }

                            foreach ( $arElem['STYLE'] as $st ) {
                                if ( !empty($arrStyles[$st]['UF_NAME']) )
                                    $strTmpOff .= '<param name="'.self::yandex_text2xml('Форма оправы').'">'.self::yandex_text2xml($arrStyles[$st]['UF_NAME']).'</param>'."\n";
                            }

                            if ( !empty($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']) )
                                $strTmpOff .= '<param name="'.self::yandex_text2xml('Конструкция').'">'.self::yandex_text2xml($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']).'</param>'."\n";


                            foreach ( $arElem['MATERIAL'] as $material ) {
                                if ( !empty($arrMaterials[$material]['UF_NAME']) )
                                    $strTmpOff .= '<param name="'.self::yandex_text2xml('Материал оправы').'">'.self::yandex_text2xml($arrMaterials[$material]['UF_NAME']).'</param>'."\n";
                            }

                            foreach ( $arElem['COLOR'] as $color ) {
                                if ( !empty($arrColors[$color]['UF_NAME']) )
                                    $strTmpOff .= '<param name="'.self::yandex_text2xml('Цвет').'">'.self::yandex_text2xml($arrColors[$color]['UF_NAME']).'</param>'."\n";
                            }

                            $strTmpOff .= '</offer>'."\n";
                        }
                    }
                }
            }

            $strTmpPromos = '';
            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__YML__PROMOCODE, 'ACTIVE' => 'Y', '=PROPERTY_DOMEN' => $domen],
                false,
                false,
                ['NAME', 'CODE', 'PROPERTY_PERCENT', 'PROPERTY_CATEGORY']
            );
            while ( $arElem = $rsElem->GetNext() ) {
                $strTmpPromos .= '<promo id="'.$arElem['CODE'].'" type="promo code">'."\n";
                $strTmpPromos .= '<promo-code>'.$arElem['NAME'].'</promo-code>'."\n";
                $strTmpPromos .= '<discount unit="percent">'.$arElem['PROPERTY_PERCENT_VALUE'].'</discount>'."\n";
                $strTmpPromos .= '<purchase>'."\n";
                $strTmpPromos .= '<product category-id="'.$arElem['PROPERTY_CATEGORY_VALUE'].'"/>'."\n";
                $strTmpPromos .= '</purchase>'."\n";
                $strTmpPromos .= '</promo>'."\n";
            }

            // if (in_array(SITE_ID, MARKET_SITE_ID) && !empty($strPromoOffers)) {
            //     $strTmpPromos .= '<promo id="Promo" type="flash discount">'."\n";
            //     $strTmpPromos .= '<start-date>' . date('Y-m-d') . '</start-date>'."\n";
            //     $strTmpPromos .= '<end-date>' . date('Y-m-d', strtotime('+1 week')) . '</end-date>/'."\n";
            //     $strTmpPromos .= '<description>'.self::yandex_text2xml('Скидка при заказе с линзами').'</description>'."\n";
            //     $strTmpPromos .= '<url>'.$url.'/action/</url>'."\n";
            //     $strTmpPromos .= '<purchase>'."\n";
            //
            //     $strTmpPromos .= $strPromoOffers;
            //
            //     $strTmpPromos .= '</purchase>'."\n";
            //     $strTmpPromos .= '</promo>'."\n";
            // }

            fwrite($fp, "<categories>\n");
            fwrite($fp, $strTmpCat);
            fwrite($fp, "</categories>\n");
            unset($strTmpCat);

            fwrite($fp, "<delivery-options>\n");
            fwrite($fp, "<option cost=\"399\" days=\"0-2\"/>\n");
            fwrite($fp, "</delivery-options>\n");

            fwrite($fp, "<pickup-options>\n");
            fwrite($fp, "<option cost=\"0\" days=\"0-2\"/>\n");
            fwrite($fp, "</pickup-options>\n");

            fwrite($fp, "<offers>\n");
            fwrite($fp, $strTmpOff);
            fwrite($fp, "</offers>\n");
            unset($strTmpOff);

            fwrite($fp, "<promos>\n");
            fwrite($fp, $strTmpPromos);
            fwrite($fp, "</promos>\n");
            unset($strTmpPromos);

            fwrite($fp, "</shop>\n");
            fwrite($fp, "</yml_catalog>\n");
        }
    }

    public static function exportYmlFrames( $SETUP_FILE_NAME, $domen, $utm_campaign = '', $withUtm = true, $siteId = 's1' ) {
        if ( empty($SETUP_FILE_NAME) || empty($domen) )
            return false;

        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $url = 'https://'.$domen;

        if ( $fp = @fopen($SETUP_FILE_NAME, "wb") )
        {
            fwrite($fp, '<?xml version="1.0" encoding="windows-1251"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">');
            fwrite($fp, "\n<yml_catalog date=\"".date("Y-m-d H:i")."\">\n");
            fwrite($fp, "<shop>\n");
            fwrite($fp, "<name>".self::iconvToW1251('Черника Оптика')."</name>\n");
            fwrite($fp, "<company>".self::iconvToW1251('ООО Союз-Оптика')."</company>\n");
            fwrite($fp, "<url>".$url."</url>\n");
            fwrite($fp, "<email>info@chernika-optika.ru</email>\n");

            fwrite($fp, "<currencies>\n");
            fwrite($fp, "<currency id=\"RUB\" rate=\"1\"></currency>\n");
            fwrite($fp, "</currencies>\n");

            $arrPols = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__SEX);
            $arrFrameTypes = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__FORMS);
            $arrStyles = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__STYLES);
            $arrMaterials = \PDV\Tools::getHighloadBlockData(HIGHLOADBLOCK_ID__MATERIALS);
            $arrColors = \PDV\Tools::getHighloadBlockData(HIGHBLOCK_ID__COLOR);

            $allBrands = [];
            $rsElem = \CIBlockElement::GetList(
                array('sort' => 'asc', 'name' => 'asc'),
                array('IBLOCK_ID' => IBLOCK_ID__BRAND, 'ACTIVE' => 'Y'),
                false,
                false,
                array('ID', 'NAME')
            );
            while ( $arElem = $rsElem->GetNext() ) {
                $allBrands[ $arElem['ID'] ] = $arElem['NAME'];
            }

            $arItems = [];

            //Оправы
            $brands = [];
            $rsElem = \CIBlockElement::GetList(
                ['id' => 'asc'],
                ['IBLOCK_ID' => IBLOCK_ID__CATALOG, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'SECTION_ID' => SECTION_ID__CATALOG, 'INCLUDE_SUBSECTIONS' => 'Y'],
                false,
                false
            );
            while ( $arElemObj = $rsElem->GetNextElement() ) {
                $arElem = $arElemObj->GetFields();
                $arElem['PROPERTIES'] = $arElemObj->GetProperties();

                if ( !empty($allBrands[ $arElem['PROPERTIES']['BRAND']['VALUE'] ]) ) {
                    if ( \PDV\Tools::showPrice($arElem) ) {
                        $arElem['PRODUCT_URL'] = self::getDetailPageUrl($arElem, IBLOCK_ID__CATALOG);

                        if ( !empty($arElem['DETAIL_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['DETAIL_PICTURE'];
                        elseif ( !empty($arElem['PREVIEW_PICTURE']) )
                            $arElem['IMAGE'] = $arElem['PREVIEW_PICTURE'];
                        else
                            $arElem['IMAGE'] = $arElem['PROPERTIES']['MORE_PHOTO']['VALUE'][0];

                        $rsElemTP = \CIBlockElement::GetList(
                            ['id' => 'asc'],
                            ['IBLOCK_ID' => IBLOCK_ID__CATALOG_TP, 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $arElem['ID'], '>CATALOG_QUANTITY' => 0],
                            false,
                            ['nPageSize' => 1],
                            ['ID']
                        );
                        if ( $rsElemTP->SelectedRowsCount() > 0 ) {
                            while ( $arElemTP = $rsElemTP->GetNext() ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElemTP['ID']);
                                $price4 = \PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price4 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG][ $arElemTP['ID'] ] = [
                                            'ID' => $arElemTP['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElemTP['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE'],
                                        ];
                                    }
                                }
                            }
                        }
                        else {
                            $arCatalog = \CCatalogProduct::GetByID($arElem['ID']);
                            if ( $arCatalog['QUANTITY'] > 0 ) {
                                $arPrice = \PDV\Tools::getMskSpbPrice($arElem['ID']);
                                $price4 = \PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId);
                                if ($price4 >= $minPrice) {
                                    if ( $arPrice['PRICE'] > 0 ) {
                                        $brands[] = $arElem['PROPERTIES']['BRAND']['VALUE'];

                                        $arItems[SECTION_ID__CATALOG][ $arElem['ID'] ] = [
                                            'ID' => $arElem['ID'],
                                            'NAME' => $arElem['NAME'],
                                            'PRODUCT_URL' => $arElem['PRODUCT_URL'],
                                            'IMAGE' => $arElem['IMAGE'],
                                            'PRICE' => \PDV\Tools::ceilCoefficient($arPrice['PRICE']),
                                            'SALE_PRICE' => \PDV\Tools::ceilCoefficient(\PDV\Tools::getSalePrice($arElem['ID'], $arPrice['ID'], $arPrice['PRICE'], 1, $siteId)),
                                            'CML2_ARTICLE' => $arElem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
                                            'BRAND' => $arElem['PROPERTIES']['BRAND']['VALUE'],
                                            'POL' => $arElem['PROPERTIES']['POL']['VALUE'],
                                            'FRAME_TYPE' => $arElem['PROPERTIES']['FRAME_TYPE']['VALUE'],
                                            'STYLE' => $arElem['PROPERTIES']['STYLE']['VALUE'],
                                            'MATERIAL' => $arElem['PROPERTIES']['MATERIAL']['VALUE'],
                                            'COLOR' => $arElem['PROPERTIES']['COLOR']['VALUE'],
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $brands = array_unique($brands);

            $strTmpCat = '<category id="'.SECTION_ID__CATALOG.'">'.self::iconvToW1251('Оправы').'</category>'."\n";
            if ( !empty($brands) ) {
                foreach ( $allBrands as $id => $name ) {
                    if ( in_array($id, $brands) )
                        $strTmpCat .= '<category id="'.SECTION_ID__CATALOG.$id.'" parentId="'.SECTION_ID__CATALOG.'">'.self::yandex_text2xml('Оправы '.$name).'</category>'."\n";
                }
            }
            unset($brands);

            $strTmpOff = '';
            foreach ( $arItems as $sectId => $arElems) {
                foreach ( $arElems as $arElem ) {
                    if ( $arElem['IMAGE'] > 0 ) {
                        $strTmpOff .= '<offer id="'.$arElem['ID'].'" type="vendor.model" available="true">'."\n";

                        $type = 'Оправа';
                        if ( $sectId == SECTION_ID__CATALOG_2 )
                            $type = 'Солнцезащитные очки';
                        elseif ( $sectId == SECTION_ID__CATALOG_3 )
                            $type = 'Спортивные очки';

                        $strTmpOff .= '<typePrefix>'.self::iconvToW1251($type).'</typePrefix>'."\n";
                        $strTmpOff .= '<vendor>'.self::yandex_text2xml($allBrands[ $arElem['BRAND'] ]).'</vendor>'."\n";
                        $strTmpOff .= '<model>'.self::yandex_text2xml($arElem['CML2_ARTICLE']).'</model>'."\n";

                        $urlProd = $url.$arElem['PRODUCT_URL'];
                        if ( $withUtm ) {
                            $urlProd .= self::yandex_text2xml('?utm_source=ya.market&utm_medium=cpc&utm_campaign='.$utm_campaign);
                            $urlProd .= self::yandex_text2xml('&utm_term='.str_replace(' ','%20', implode('_', [$arElem['ID'],$type,$allBrands[ $arElem['BRAND'] ],$arElem['CML2_ARTICLE']])));
                        }

                        $strTmpOff .= '<url>'.$urlProd.'</url>'."\n";

                        $params = [];
                        $params['Производитель'][] = self::yandex_text2xml($allBrands[ $arElem['BRAND'] ]);

                        foreach ( $arElem['POL'] as $pol) {
                            if ( !empty($arrPols[$pol]['UF_NAME']) )
                                $params['Пол'][] = self::yandex_text2xml($arrPols[$pol]['UF_NAME']);
                        }

                        foreach ( $arElem['STYLE'] as $st ) {
                            if ( !empty($arrStyles[$st]['UF_NAME']) )
                                $params['Форма оправы'][] = self::yandex_text2xml($arrStyles[$st]['UF_NAME']);
                        }

                        if ( !empty($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']) )
                            $params['Конструкция'][] = self::yandex_text2xml($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']);

                        foreach ( $arElem['MATERIAL'] as $material ) {
                            if ( !empty($arrMaterials[$material]['UF_NAME']) )
                                $params['Материал оправы'][] = self::yandex_text2xml($arrMaterials[$material]['UF_NAME']);
                        }

                        foreach ( $arElem['COLOR'] as $color ) {
                            if ( !empty($arrColors[$color]['UF_NAME']) )
                                $params['Цвет'][] = self::yandex_text2xml($arrColors[$color]['UF_NAME']);
                        }

                        $description = '';
                        if ( !emptY($params) ) {
                            $description = '<![CDATA[<ul>';
                            $i = 1;
                            foreach ( $params as $name => $param ) {
                                $description .= '<li>'.self::yandex_text2xml($name).': '.implode(', ',$param).'</li>';
                                if ( $i < count($params) ) $description .= '<br/>';
                                $i++;
                            }
                            $description .= '</ul>]]>';
                        }
                        unset($params);
                        $strTmpOff .= '<description>'.$description.'</description>'."\n";

                        if ( $arElem['PRICE'] <> $arElem['SALE_PRICE'] ) {
                            $strTmpOff .= '<price>'.\PDV\Tools::ceilCoefficient($arElem['SALE_PRICE']).'</price>'."\n";
                            $strTmpOff .= '<oldprice>'.\PDV\Tools::ceilCoefficient($arElem['PRICE']).'</oldprice>'."\n";
                        }
                        else
                            $strTmpOff .= '<price>'.\PDV\Tools::ceilCoefficient($arElem['PRICE']).'</price>'."\n";

                        $strTmpOff .= '<currencyId>RUB</currencyId>'."\n";

                        $strTmpOff .= '<categoryId>'.$sectId.$arElem['BRAND'].'</categoryId>'."\n";

                        $strTmpOff .= '<picture>'.$url.\CFile::GetPath($arElem['IMAGE']).'</picture>'."\n";

                        $strTmpOff .= '<store>true</store>'."\n";
                        $strTmpOff .= '<delivery>true</delivery>'."\n";
                        $strTmpOff .= '<pickup>true</pickup>'."\n";

                        if ( $arElem['SALE_PRICE'] > 6000 ) {
                            $strTmpOff .= '<delivery-options>'."\n";
                            $strTmpOff .= '<option cost="0" days="2-3"/>'."\n";
                            $strTmpOff .= '</delivery-options>'."\n";
                        }

                        $strTmpOff .= '<manufacturer_warranty>true</manufacturer_warranty>'."\n";
                        $strTmpOff .= '<sales_notes>'.self::yandex_text2xml('Оплата после получения и примерки').'</sales_notes>'."\n";

                        foreach ( $arElem['POL'] as $pol) {
                            if ( !empty($arrPols[$pol]['UF_NAME']) )
                                $strTmpOff .= '<param name="'.self::yandex_text2xml('Пол').'">'.self::yandex_text2xml($arrPols[$pol]['UF_NAME']).'</param>'."\n";
                        }

                        foreach ( $arElem['STYLE'] as $st ) {
                            if ( !empty($arrStyles[$st]['UF_NAME']) )
                                $strTmpOff .= '<param name="'.self::yandex_text2xml('Форма оправы').'">'.self::yandex_text2xml($arrStyles[$st]['UF_NAME']).'</param>'."\n";
                        }

                        if ( !empty($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']) )
                            $strTmpOff .= '<param name="'.self::yandex_text2xml('Конструкция').'">'.self::yandex_text2xml($arrFrameTypes[$arElem['FRAME_TYPE']]['UF_NAME']).'</param>'."\n";


                        foreach ( $arElem['MATERIAL'] as $material ) {
                            if ( !empty($arrMaterials[$material]['UF_NAME']) )
                                $strTmpOff .= '<param name="'.self::yandex_text2xml('Материал оправы').'">'.self::yandex_text2xml($arrMaterials[$material]['UF_NAME']).'</param>'."\n";
                        }

                        foreach ( $arElem['COLOR'] as $color ) {
                            if ( !empty($arrColors[$color]['UF_NAME']) )
                                $strTmpOff .= '<param name="'.self::yandex_text2xml('Цвет').'">'.self::yandex_text2xml($arrColors[$color]['UF_NAME']).'</param>'."\n";
                        }

                        $strTmpOff .= '</offer>'."\n";
                    }
                }
            }

            $strTmpPromos = '';
            $rsElem = \CIBlockElement::GetList(
                ['sort' => 'asc', 'id' => 'desc'],
                ['IBLOCK_ID' => IBLOCK_ID__YML__PROMOCODE, 'ACTIVE' => 'Y', '=PROPERTY_DOMEN' => $domen],
                false,
                false,
                ['NAME', 'CODE', 'PROPERTY_PERCENT', 'PROPERTY_CATEGORY']
            );
            while ( $arElem = $rsElem->GetNext() ) {
                $strTmpPromos .= '<promo id="'.$arElem['CODE'].'" type="promo code">'."\n";
                $strTmpPromos .= '<promo-code>'.$arElem['NAME'].'</promo-code>'."\n";
                $strTmpPromos .= '<discount unit="percent">'.$arElem['PROPERTY_PERCENT_VALUE'].'</discount>'."\n";
                $strTmpPromos .= '<purchase>'."\n";
                $strTmpPromos .= '<product category-id="'.$arElem['PROPERTY_CATEGORY_VALUE'].'"/>'."\n";
                $strTmpPromos .= '</purchase>'."\n";
                $strTmpPromos .= '</promo>'."\n";
            }

            fwrite($fp, "<categories>\n");
            fwrite($fp, $strTmpCat);
            fwrite($fp, "</categories>\n");
            unset($strTmpCat);

            fwrite($fp, "<delivery-options>\n");
            fwrite($fp, "<option cost=\"399\" days=\"0-2\"/>\n");
            fwrite($fp, "</delivery-options>\n");

            fwrite($fp, "<pickup-options>\n");
            fwrite($fp, "<option cost=\"0\" days=\"0-2\"/>\n");
            fwrite($fp, "</pickup-options>\n");

            fwrite($fp, "<offers>\n");
            fwrite($fp, $strTmpOff);
            fwrite($fp, "</offers>\n");
            unset($strTmpOff);

            fwrite($fp, "<promos>\n");
            fwrite($fp, $strTmpPromos);
            fwrite($fp, "</promos>\n");
            unset($strTmpPromos);

            fwrite($fp, "</shop>\n");
            fwrite($fp, "</yml_catalog>\n");

        }
    }
}