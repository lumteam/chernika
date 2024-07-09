<?
foreach( $arResult["ITEMS"] as $i => $arItem ) {
    $arResult["ITEMS"][$i]['PICTURE'] = '';
    $resizeImg = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>480, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arResult["ITEMS"][$i]['PICTURE'] = $resizeImg['src'];
    unset($resizeImg);
}
?>