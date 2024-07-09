<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $USER;

$IBLOCK_TYPE_ID = 18;
$IBLOCK_TYPE_LINSES_ID = 27;
$IBLOCK_TYPE_LINSES_COLORS_ID = 29;

Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('sale');

if ( isset($_GET['id']) )
    $_SESSION['PODBOR_PRODUCT_ID'] = intval($_GET['id']);

if ( $_SESSION['PODBOR_PRODUCT_ID'] == 0 ) {
    unset($_SESSION['PODBOR_REQUEST']);
    LocalRedirect('/');
}

//unset($_SESSION['PODBOR_REQUEST']);
if ( isset($_POST['STEP']) )
    unset($_SESSION['PODBOR_REQUEST']);

foreach ( $_POST as $code => $value ) {
    $_SESSION['PODBOR_REQUEST'][ $code ] = $value;
}

$arResult = [];
$arResult['PODBOR_REQUEST'] = $_SESSION['PODBOR_REQUEST'];

$arResult['PRODUCT'] = [];
$dbBasketItems = \CSaleBasket::GetList(
    [],
    [ 'PRODUCT_ID' => $_SESSION['PODBOR_PRODUCT_ID'] ],
    false,
    false,
    ['ID', 'PRODUCT_ID', 'NAME', 'PRICE']
);
if ( $arItem = $dbBasketItems->Fetch() )
{
    $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture( $arItem['PRODUCT_ID'] );
    $arItem['ARTICLE'] = \PDV\Tools::getArticleProduct( $arItem['PRODUCT_ID'] );

    $size = [];
    $color = '';
    $arElem['BASKET_PROPS'] = [];
    $db_res = \CSaleBasket::GetPropsList(
        [ 'sort' => 'asc', 'name' => 'asc' ],
        [ 'BASKET_ID' => $arItem['ID'] ]
    );
    while ( $prop = $db_res->Fetch() )
    {
        if ( in_array($prop['CODE'], ['DUZHKA','MOST','LINZA','HEIGHT']) )
            $size[] = $prop['VALUE'];
        elseif ( $prop['CODE'] == 'COLOR' )
            $color = $prop['VALUE'];

        $arItem['BASKET_PROPS'][] = $prop;
    }

    if ( !empty($size) )
        $arItem['SIZE'] = implode('-',$size);

    if ( !empty($color) )
        $arItem['COLOR'] = $color;

    $arItem['PRICE'] = \PDV\Tools::getSalePrice($arItem['PRODUCT_ID']);

    $arResult['PRODUCT'] = $arItem;
}

$arResult['DESCRIPTION'] = '';
$rsIblock = \CIBlock::GetById($IBLOCK_TYPE_ID);
if ( $arIblock = $rsIblock->GetNext() )
    $arResult['DESCRIPTION'] = $arIblock['DESCRIPTION'];

$arResult['STEP'] = (intval($arResult['PODBOR_REQUEST']['STEP']) > 0) ? intval($arResult['PODBOR_REQUEST']['STEP']) : 1;

$arResult['TYPES_SECTION'] = [];
$arResult['PODBOR_REQUEST']['type_sect'] = intval($arResult['PODBOR_REQUEST']['type_sect']);

$arResult['TYPES_ELEMENT'] = [];
$arResult['PODBOR_REQUEST']['type_elem'] = intval($arResult['PODBOR_REQUEST']['type_elem']);

$arResult['SELECT_TYPE'] = '';
$rsSect = \CIBlockSection::GetList(
    ['sort' => 'asc', 'id' => 'desc'],
    ['IBLOCK_ID' => $IBLOCK_TYPE_ID, 'ACTIVE' => 'Y'],
    false,
    ['ID', 'NAME']
);
while ( $arSect = $rsSect->GetNext() )
{
    $arSect['CHECKED'] = false;
    if  ( $arResult['PODBOR_REQUEST']['type_sect'] == $arSect['ID'] ) {
        $arSect['CHECKED'] = true;

        if ( $arResult['PODBOR_REQUEST']['type_sect'] > 0 ) {
            $rsElem = \CIBlockElement::GetList(
                array('sort' => 'asc', 'id' => 'desc'),
                array('IBLOCK_ID' => $IBLOCK_TYPE_ID, 'ACTIVE' => 'Y', 'SECTION_ID' => $arResult['PODBOR_REQUEST']['type_sect']),
                false,
                false,
                array('ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT')
            );
            while ( $arElem = $rsElem->GetNext() ) {
                if  ( $arResult['PODBOR_REQUEST']['type_elem'] == $arElem['ID'] ) {
                    $arElem['CHECKED'] = true;
                    $arResult['SELECT_TYPE'] = $arElem['NAME'].' ('.$arSect['NAME'].')';
                }

                $arResult['TYPES_ELEMENT'][] = $arElem;
            }
        }
    }

    $arResult['TYPES_SECTION'][] = $arSect;
}

if ( $arResult['STEP'] > 1 ) {
    $arResult['SPH'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 19, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['SPH'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['CYL'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 20, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['CYL'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['OSY'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 21, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['OSY'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['ADD'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 22, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['ADD'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['PRIZMA_DIRECTION'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 23, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['PRIZMA_DIRECTION'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['PRIZMA_POWER'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 24, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['PRIZMA_POWER'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['PD_63'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 25, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['PD_63'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['PD_32'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 26, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        $arResult['PD_32'][ $arElem['ID'] ] = $arElem;
    }

    if ( isset($arResult['PODBOR_REQUEST']['type_pd']) )
        $arResult['PODBOR_REQUEST']['type_pd_current'] = ( $arResult['PODBOR_REQUEST']['type_pd'] == 'pd_63' ) ? 'pd_63' : 'pd_32';
}

if ( $arResult['PODBOR_REQUEST']['type_recept'] == 'use') {
    if ( $USER->IsAuthorized() ) {
        $rsUser = CUser::GetByID( $USER->GetId() );
        $arResult['USER'] = $rsUser->Fetch();
    }
}

$arResult['SELECT_RECEPT_TYPE'] = '';
switch ( $arResult['PODBOR_REQUEST']['type_recept'] ) {
    case 'enter';
        $arResult['SELECT_RECEPT_TYPE'] = 'данные введены';
        break;
    case 'use';
        $arResult['SELECT_RECEPT_TYPE'] = 'использовать сохраненный';
        break;
    case 'send';
        $arResult['SELECT_RECEPT_TYPE'] = 'отправлю по почте';
        break;
}

$arResult['PRICE_LINSES'] = 0;
if ( $arResult['STEP'] > 2 ) {
    $arResult['TYPES_SECTION_LINSES'] = [];
    $arResult['PODBOR_REQUEST']['type_sect_linses'] = intval($arResult['PODBOR_REQUEST']['type_sect_linses']);

    $arResult['TYPES_ELEMENT_LINSES'] = [];
    $arResult['PODBOR_REQUEST']['type_elem_linses'] = intval($arResult['PODBOR_REQUEST']['type_elem_linses']);

    $arResult['SELECT_TYPE_LINSES'] = '';
    $rsSect = \CIBlockSection::GetList(
        ['sort' => 'asc', 'id' => 'desc'],
        ['IBLOCK_ID' => $IBLOCK_TYPE_LINSES_ID, 'ACTIVE' => 'Y'],
        false,
        ['ID', 'NAME']
    );
    while ( $arSect = $rsSect->GetNext() )
    {
        if ( empty($arResult['PODBOR_REQUEST']['type_sect_linses']) )
            $arResult['PODBOR_REQUEST']['type_sect_linses'] = $arSect['ID'];

        $arSect['CHECKED'] = false;
        if  ( $arResult['PODBOR_REQUEST']['type_sect_linses'] == $arSect['ID'] ) {
            $arSect['CHECKED'] = true;

            if ( $arResult['PODBOR_REQUEST']['type_sect_linses'] > 0 ) {
                $rsElem = \CIBlockElement::GetList(
                    array('sort' => 'asc', 'id' => 'desc'),
                    array('IBLOCK_ID' => $IBLOCK_TYPE_LINSES_ID, 'ACTIVE' => 'Y', 'SECTION_ID' => $arResult['PODBOR_REQUEST']['type_sect_linses']),
                    false,
                    false,
                    array('ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT')
                );
                while ( $arElem = $rsElem->GetNext() ) {
                    $arPrice = CCatalogProduct::GetOptimalPrice($arElem['ID'], 1, $USER->GetUserGroupArray());
                    $arElem['PRICE'] = $arPrice['PRICE']['PRICE'];

                    if  ( $arResult['PODBOR_REQUEST']['type_elem_linses'] == $arElem['ID'] ) {
                        $arElem['CHECKED'] = true;
                        $arResult['SELECT_TYPE_LINSES'] = $arElem['NAME'].' ('.$arSect['NAME'].')';
                        $arResult['PRICE_LINSES'] = $arElem['PRICE'];
                    }

                    $arResult['TYPES_ELEMENT_LINSES'][ $arElem['ID'] ] = $arElem;
                }
            }
        }

        $arResult['TYPES_SECTION_LINSES'][] = $arSect;
    }
}

if ( $arResult['STEP'] > 3 ) {
    $arResult['LINSES_COLORS']['DESCRIPTION'] = '';
    $rsIblock = \CIBlock::GetById($IBLOCK_TYPE_LINSES_COLORS_ID);
    if ( $arIblock = $rsIblock->GetNext() )
        $arResult['LINSES_COLORS']['DESCRIPTION'] = $arIblock['DESCRIPTION'];

    $arResult['TYPES_SECTION_LINSES_COLORS'] = [];
    $arResult['PODBOR_REQUEST']['type_sect_linses_colors'] = intval($arResult['PODBOR_REQUEST']['type_sect_linses_colors']);

    $arResult['TYPES_ELEMENT_LINSES_COLORS'] = [];
    $arResult['PODBOR_REQUEST']['type_elem_linses_colors'] = intval($arResult['PODBOR_REQUEST']['type_elem_linses_colors']);

    $arResult['SELECT_TYPE_LINSES_COLORS'] = '';
    $rsSect = \CIBlockSection::GetList(
        ['sort' => 'asc', 'id' => 'desc'],
        ['IBLOCK_ID' => $IBLOCK_TYPE_LINSES_COLORS_ID, 'ACTIVE' => 'Y'],
        false,
        ['ID', 'NAME']
    );
    while ( $arSect = $rsSect->GetNext() )
    {
        if ( empty($arResult['PODBOR_REQUEST']['type_sect_linses_colors']) )
            $arResult['PODBOR_REQUEST']['type_sect_linses_colors'] = $arSect['ID'];

        $arSect['CHECKED'] = false;
        if  ( $arResult['PODBOR_REQUEST']['type_sect_linses_colors'] == $arSect['ID'] ) {
            $arSect['CHECKED'] = true;
            $arResult['SELECT_TYPE_LINSES_COLORS'] = $arSect['NAME'];

            if ( $arResult['PODBOR_REQUEST']['type_sect_linses_colors'] > 0 ) {
                $rsElem = \CIBlockElement::GetList(
                    array('sort' => 'asc', 'id' => 'desc'),
                    array('IBLOCK_ID' => $IBLOCK_TYPE_LINSES_COLORS_ID, 'ACTIVE' => 'Y', 'SECTION_ID' => $arResult['PODBOR_REQUEST']['type_sect_linses_colors']),
                    false,
                    false,
                    array('ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT')
                );
                while ( $arElem = $rsElem->GetNext() ) {
                    $arPrice = CCatalogProduct::GetOptimalPrice($arElem['ID'], 1, $USER->GetUserGroupArray());
                    $arElem['PRICE'] = $arPrice['PRICE']['PRICE'];

                    if  ( $arResult['PODBOR_REQUEST']['type_elem_linses_colors'] == $arElem['ID'] ) {
                        $arElem['CHECKED'] = true;
                        $arResult['SELECT_TYPE_LINSES_COLORS'] = $arElem['NAME'].' ('.$arSect['NAME'].')';
                        $arResult['PRICE_LINSES_COLORS'] = $arElem['PRICE'];
                    }

                    $arResult['TYPES_ELEMENT_LINSES_COLORS'][ $arElem['ID'] ] = $arElem;
                }
            }
        }

        $arResult['TYPES_SECTION_LINSES_COLORS'][] = $arSect;
    }
}

if ( $arResult['STEP'] >= 5 ) {
    $arResult['POKRYTIE'] = [];
    $rsElem = \CIBlockElement::GetList(
        array('sort' => 'asc', 'id' => 'desc'),
        array('IBLOCK_ID' => 30, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT')
    );
    while ( $arElem = $rsElem->GetNext() ) {
        if  ( $arResult['PODBOR_REQUEST']['pokrytie'] == $arElem['ID'] )
            $arElem['CHECKED'] = true;

        $arResult['POKRYTIE'][ $arElem['ID'] ] = $arElem;
    }

    $arResult['PODBOR_VALUES'] = [
        'sph_right' => $arResult['SPH'][ $arResult['PODBOR_REQUEST']['sph_right'] ]['NAME'],
        'cyl_right' => $arResult['CYL'][ $arResult['PODBOR_REQUEST']['cyl_right'] ]['NAME'],
        'ocy_right' => $arResult['OSY'][ $arResult['PODBOR_REQUEST']['ocy_right'] ]['NAME'],
        'add_right' => $arResult['ADD'][ $arResult['PODBOR_REQUEST']['add_right'] ]['NAME'],
        'sph_left' => $arResult['SPH'][ $arResult['PODBOR_REQUEST']['sph_left'] ]['NAME'],
        'cyl_left' => $arResult['CYL'][ $arResult['PODBOR_REQUEST']['cyl_left'] ]['NAME'],
        'ocy_left' => $arResult['OSY'][ $arResult['PODBOR_REQUEST']['ocy_left'] ]['NAME'],
        'add_left' => $arResult['ADD'][ $arResult['PODBOR_REQUEST']['add_left'] ]['NAME'],

        'prizma_direction_right' => $arResult['PRIZMA_DIRECTION'][ $arResult['PODBOR_REQUEST']['prizma_direction_right'] ]['NAME'],
        'prizma_power_right' => $arResult['PRIZMA_POWER'][ $arResult['PODBOR_REQUEST']['prizma_power_right'] ]['NAME'],
        'prizma_direction_left' => $arResult['PRIZMA_DIRECTION'][ $arResult['PODBOR_REQUEST']['prizma_direction_left'] ]['NAME'],
        'prizma_power_left' => $arResult['PRIZMA_POWER'][ $arResult['PODBOR_REQUEST']['prizma_power_left'] ]['NAME'],
        'pd_63' => ( $arResult['PODBOR_REQUEST']['pd_63'] > 0 ) ? $arResult['PD_63'][ $arResult['PODBOR_REQUEST']['pd_63'] ]['NAME'] : '',
        'pd_32_right' => ( $arResult['PODBOR_REQUEST']['pd_32_right'] > 0 ) ? $arResult['PD_32'][ $arResult['PODBOR_REQUEST']['pd_32_right'] ]['NAME'] : '',
        'pd_32_left' => ( $arResult['PODBOR_REQUEST']['pd_32_left'] > 0 ) ? $arResult['PD_32'][ $arResult['PODBOR_REQUEST']['pd_32_left'] ]['NAME'] : '',
        'type_elem_linses' => $arResult['TYPES_ELEMENT_LINSES'][ $arResult['PODBOR_REQUEST']['type_elem_linses'] ]['NAME'],
        'type_elem_linses_colors' => $arResult['TYPES_ELEMENT_LINSES_COLORS'][ $arResult['PODBOR_REQUEST']['type_elem_linses_colors'] ]['NAME'],
        'pokrytie' => ''
    ];

    $pokrytie = [];
    foreach ( $arResult['PODBOR_REQUEST']['pokrytie'] as $id ) {
        $pokrytie[] = $arResult['POKRYTIE'][ $id ]['NAME'];
    }
    $arResult['PODBOR_VALUES']['pokrytie'] = implode(', ', $pokrytie);
    unset($pokrytie);
}

$arResult['MODALS'] = [];
$rsElem = \CIBlockElement::GetList(
    [],
    ['IBLOCK_ID' => 31, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
    false,
    false,
    ['CODE', 'NAME', 'PREVIEW_TEXT']
);
while ( $arElem = $rsElem->GetNext() ) {
    $arResult['MODALS'][] = $arElem;
}

if ( $arResult['STEP'] == 6 ) {
    $el = new \CIBlockElement;
    $newId = 0;
    $price = round($arResult['PRODUCT']['PRICE'] + $arResult['PRICE_LINSES'] + $arResult['PRICE_LINSES_COLORS']);

    $props = [
        'CML2_ARTICLE' => $arResult['PRODUCT']['ARTICLE'],
        'PRODUCT_ID' => $arResult['PRODUCT']['PRODUCT_ID'],
        'LINSES' => $arResult['PODBOR_VALUES']['type_elem_linses'],
        'LINSES_COLORS' => $arResult['PODBOR_VALUES']['type_elem_linses_colors']
    ];
    $xmlId = md5(implode(',',$props).','.$price);
    $rsElem = \CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 32, '=XML_ID' => $xmlId],
        false,
        ['nPageSize' => 1],
        ['ID']
    );
    if ( $arElem = $rsElem->GetNext() )
        $newId = $arElem['ID'];
    else {
        $newId = $el->Add([
            'IBLOCK_ID' => 32,
            'NAME' => $arResult['PRODUCT']['NAME'],
            'PREVIEW_PICTURE' => \CFile::MakeFileArray($arResult['PRODUCT']['PICTURE']),
            'XML_ID' => $xmlId,
            'PROPERTY_VALUES' => $props
        ]);

        $resCat = \CCatalogProduct::GetList(
            array(),
            array('ID' => $props['PRODUCT_ID']),
            false,
            array('nTopCount' => 1)
        );
        if ( $arresCat = $resCat->Fetch() )
            \CCatalogProduct::Add(array(
                'ID' => $newId,
                'WEIGHT' => $arresCat['WEIGHT'],
                'QUANTITY' => 1,
                'VAT_INCLUDED' => 'Y',
                'LENGTH' => $arresCat['LENGTH'],
                'WIDTH' => $arresCat['WIDTH'],
                'HEIGHT' => $arresCat['HEIGHT'],
            ));

        \CPrice::Add(array(
            'PRODUCT_ID' => $newId,
            'CATALOG_GROUP_ID' => PRICE__CATALOG_GROUP_ID,
            'PRICE' => $price,
            'CURRENCY' => 'RUB'
        ));

        unset($props,$xmlId);
    }

    if ( $newId > 0 ) {
        $receptId = 0;
        if ( $arResult['PODBOR_REQUEST']['type_recept'] == 'enter' ) {
            $props = [
                'USER_ID' => $USER->GetId(),
                'sph_right' => $arResult['PODBOR_VALUES']['sph_right'],
                'cyl_right' => $arResult['PODBOR_VALUES']['cyl_right'],
                'ocy_right' => $arResult['PODBOR_VALUES']['ocy_right'],
                'add_right' => $arResult['PODBOR_VALUES']['add_right'],
                'sph_left' => $arResult['PODBOR_VALUES']['sph_left'],
                'cyl_left' => $arResult['PODBOR_VALUES']['cyl_left'],
                'ocy_left' => $arResult['PODBOR_VALUES']['ocy_left'],
                'add_left' => $arResult['PODBOR_VALUES']['add_left']
            ];

            if ( !empty($arResult['PODBOR_REQUEST']['prizma']) ) {
                $props['prizma_direction_right'] = $arResult['PODBOR_VALUES']['prizma_direction_right'];
                $props['prizma_power_right'] = $arResult['PODBOR_VALUES']['prizma_power_right'];
                $props['prizma_direction_left'] = $arResult['PODBOR_VALUES']['prizma_direction_left'];
                $props['prizma_power_left'] = $arResult['PODBOR_VALUES']['prizma_power_left'];
            }

            if ( $arResult['PODBOR_REQUEST']['type_pd_current'] == 'pd_63' ) {
                $props['pd_63'] = $arResult['PODBOR_VALUES']['pd_63'];
            }
            else {
                $props['pd_32_right'] = $arResult['PODBOR_VALUES']['pd_32_right'];
                $props['pd_32_left'] = $arResult['PODBOR_VALUES']['pd_32_left'];
            }

            $xmlId = md5(implode(',', $props));
            $rsElem = \CIBlockElement::GetList(
                [],
                ['IBLOCK_ID' => 28, '=XML_ID' => $xmlId],
                false,
                ['nPageSize' => 1],
                ['ID']
            );
            if ( $arElem = $rsElem->GetNext() )
                $receptId = $arElem['ID'];
            else
                $receptId = $el->Add([
                    'IBLOCK_ID' => 28,
                    'NAME' => $arResult['PODBOR_REQUEST']['recept'],
                    'PREVIEW_TEXT' => $arResult['PODBOR_REQUEST']['text'],
                    'XML_ID' => $xmlId,
                    'PROPERTY_VALUES' => $props
                ]);
        }

        $arProductParams = array();

        foreach ( $arResult['PRODUCT']['BASKET_PROPS'] as $prop ) {
            if ( in_array($prop['CODE'], ['DUZHKA', 'MOST', 'LINZA', 'HEIGHT', 'COLOR']) )
                $arProductParams[] = array('NAME' => $prop['NAME'], 'CODE' => $prop['CODE'], 'VALUE' => $prop['VALUE']);
        }

        if ( !empty($arResult['SELECT_RECEPT_TYPE']) )
            $arProductParams[] = array('NAME' => 'Рецепт', 'CODE' => 'RECEPT_TYPE', 'VALUE' => $arResult['SELECT_RECEPT_TYPE']);

        if ( $receptId > 0 )
            $arProductParams[] = array('NAME' => 'Рецепт (данные)', 'CODE' => 'RECEPT_ID', 'VALUE' => $receptId);

        if ( !empty($arResult['PODBOR_VALUES']['type_elem_linses']) ) {
            $price = ($arResult['PRICE_LINSES'] > 0 ) ? ' ('.round($arResult['PRICE_LINSES']).'₽)' : ' (Бесплатно)';
            $arProductParams[] = array('NAME' => 'Линза', 'CODE' => 'LINSES', 'VALUE' => $arResult['PODBOR_VALUES']['type_elem_linses'].$price);
        }

        if ( !empty($arResult['PODBOR_VALUES']['type_elem_linses_colors']) ) {
            $price = ($arResult['PRICE_LINSES_COLORS'] > 0 ) ? ' ('.round($arResult['PRICE_LINSES_COLORS']).'₽)' : ' (Бесплатно)';
            $arProductParams[] = array('NAME' => 'Цветовые опции', 'CODE' => 'LINSES_COLOR', 'VALUE' => $arResult['PODBOR_VALUES']['type_elem_linses_colors'].$price);
        }

        if ( !empty($arResult['PODBOR_VALUES']['pokrytie']) )
            $arProductParams[] = array('NAME' => 'Покрытие', 'CODE' => 'POKRYTIE', 'VALUE' => $arResult['PODBOR_VALUES']['pokrytie']);

        Add2BasketByProductID($newId, 1, array(), $arProductParams);

        if ( \CSaleBasket::Delete($arResult['PRODUCT']['ID']) ) {
            $arResult['FINISH'] = true;
            unset($_SESSION['PODBOR_REQUEST']);
        }
    }
}

$this->includeComponentTemplate();