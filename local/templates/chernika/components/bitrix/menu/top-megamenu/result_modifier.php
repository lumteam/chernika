<?
$arrNewSections = array();
$countInColumn = 15;
foreach( $arResult as $i => $arSection )
{
    if ( !empty($arSection['PARAMS']['SECTION_ID']) ) {
        $arResult[$i]['PROPERTIES'] = \PDV\Tools::getParamFilterBySectId($arSection['PARAMS']['IBLOCK_ID'], $arSection['PARAMS']['SECTION_ID']);

        $arResult[$i]['CHILDS'] = [];

        if ( $arResult[$i]['PROPERTIES']['NEW'] )
            $arResult[$i]['CHILDS'][] = [
                'NAME' => 'Новинки',
                'SECTION_PAGE_URL' => $arSection['LINK'].'filter/new-is-y/apply/'
            ];

        if ( !empty($arResult[$i]['PROPERTIES']['BRANDS']) ) {
            $tempBrand = [];
            foreach ( $arResult[$i]['PROPERTIES']['BRANDS'] as $item ) {
                if ( empty($item['PROPERTY_NOT_SHOW_IN_MENU_VALUE']) )
                    $tempBrand[] = $item;
            }
            $arResult[$i]['PROPERTIES']['BRANDS'] = $tempBrand;
            unset($tempBrand);

            $countInRow = ceil(count($arResult[$i]['PROPERTIES']['BRANDS'])/3);
            if ( $countInRow > $countInColumn )
                $countInRow = $countInColumn;
            $tempBrand = [];
            $j = 1;
            $column = 0;
            foreach ( $arResult[$i]['PROPERTIES']['BRANDS'] as $item ) {
                if ( $j <= 3*$countInColumn ) {
                    if ( $j > $column*$countInRow )
                        $column++;

                    $tempBrand[ $column ][] = $item;
                }
                $j++;
            }
            $arResult[$i]['PROPERTIES']['BRANDS'] = [];
            for ( $k=0; $k<=$countInColumn; $k++ ) {
                for ( $j=1; $j<=count($tempBrand); $j++ ) {
                    if ( isset($tempBrand[$j][$k]) )
                        $arResult[$i]['PROPERTIES']['BRANDS'][] = $tempBrand[$j][$k];
                }
            }
            unset($tempBrand);
        }

        if (!empty($arResult[$i]['PROPERTIES']['LENSES_TYPE'])) {
            if (is_array($arResult[$i]['PROPERTIES']['POLS'])) {
                $arResult[$i]['PROPERTIES']['POLS'] = array_merge($arResult[$i]['PROPERTIES']['POLS'], $arResult[$i]['PROPERTIES']['LENSES_TYPE']);
            } else {
                $arResult[$i]['PROPERTIES']['POLS'] = $arResult[$i]['PROPERTIES']['LENSES_TYPE'];
            }
        }

        foreach ( $arResult[$i]['PROPERTIES']['POLS'] as $item ) {
            if ( !empty($item['UF_NOT_SHOW_IN_MENU']) ) continue;
            $arResult[$i]['CHILDS'][] = [
                'NAME' => $item['UF_NAME'],
                'SECTION_PAGE_URL' => $item['URL']
            ];
        }
    }
}
unset($arrBrandsShowInMenu);
?>