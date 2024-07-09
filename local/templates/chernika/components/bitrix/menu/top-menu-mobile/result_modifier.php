<?
$arrNewSections = array();
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

        foreach ( $arResult[$i]['PROPERTIES']['POLS'] as $item ) {
            if ( !empty($item['UF_NOT_SHOW_IN_MENU']) ) continue;
            $arResult[$i]['CHILDS'][] = [
                'NAME' => $item['UF_NAME'],
                'SECTION_PAGE_URL' => $item['URL']
            ];
        }
    }
}
?>