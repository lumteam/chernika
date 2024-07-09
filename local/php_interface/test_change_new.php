<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$IBLOCK_ID = '12';

$arSelect0 = Array("ID","IBLOCK_ID","PROPERTY_NEW","DATE_CREATE");
$arFilter0 = Array("IBLOCK_ID" => $IBLOCK_ID);
//$arFilter0 = Array("IBLOCK_ID" => $IBLOCK_ID,"ID" => "6028");

$res0 = CIBlockElement::GetList(Array(),$arFilter0, false, Array(), $arSelect0);

$now = new DateTime();
$now = $now->format('d-m-Y H:i:s');

while ($ob0 = $res0->GetNextElement()){
	$arFields0 = $ob0->getFields();
	$elID = $arFields0['ID'];

	$create = date_format(date_create($arFields0["DATE_CREATE"]), 'd-m-Y H:i:s');
	$daysAgo = date_diff(new DateTime($now), new DateTime($create))->days;

	if ($daysAgo <= 183){
		CIBlockElement::SetPropertyValuesEx($elID, false, ['NEW'=>'2371']);
	} else {
		CIBlockElement::SetPropertyValuesEx($elID, false, ['NEW'=>'']);
	}

}

?>