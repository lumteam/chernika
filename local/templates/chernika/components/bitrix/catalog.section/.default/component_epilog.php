<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// echo "<pre>";
// var_dump($arResult);
// echo "</pre>";

if (!$arResult['ITEMS_COUNT'])
{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
}

//echo($navParams['NavNum']);
//$APPLICATION->SetPageProperty("title", "Сертификаты оптики - Черника Оптика Москва");
//$APPLICATION->SetPageProperty("description", "В наших салонах оптики в Москве работают");







?>