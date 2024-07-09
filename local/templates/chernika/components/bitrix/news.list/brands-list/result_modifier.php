<? // Получаем все активные разделы ИБ
$rsSections = CIBlockSection::GetList(
    Array("SORT" => "ASC"),
    Array(
        "=IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "=ACTIVE"    => "Y"
    )
);

// Собираем разделы в массив
while ($arSection = $rsSections->GetNext())
    $arSections[] = $arSection;

// Фильтруем элементы по принадлежности к разделу
// Получаем итоговый массив со структурой: [SECTION] => [ELEMENTS]
foreach ($arSections as $arSection){
    foreach ($arResult["ITEMS"] as $arItem){
        if ($arItem["IBLOCK_SECTION_ID"] == $arSection["ID"])
            $arSection["ELEMENTS"][] = $arItem;
    }
    $arElementGroups[] = $arSection;
}

$arResult["ITEMS"] = $arElementGroups;
?>