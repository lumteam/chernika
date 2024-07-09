<?
$arrNewSections = array();
foreach ($arResult['SECTIONS'] as $i => $arSection)
{
    if ( $arSection['DEPTH_LEVEL'] == 1 ) {
        $dl1 = $arSection['ID'];
        $arrNewSections[ $dl1 ] = $arSection;
    }
    else
        $arrNewSections[ $dl1 ]['CHILDS'][ $arSection['ID'] ] = $arSection;
}
unset($arResult['SECTIONS']);

$arResult['SECTIONS'] = $arrNewSections;

foreach ($arResult['SECTIONS'] as $i => $arSection)
{
    $arResult['SECTIONS'][$i]['PARAMS'] = \PDV\Tools::getParamFilterBySectId($arParams['IBLOCK_ID'], $arSection['ID']);
}
?>