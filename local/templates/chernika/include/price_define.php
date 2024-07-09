<?php

switch (SITE_ID) {
    case 'm1':
        define('PRICE_BASE__CODE', 'Москва_Я.Маркет_Цена');
        define('PRICE_BASE_SPEC__CODE', 'Москва_Я.Маркет_СпецЦена');
        // define('PRICE_MARKET__CODE', 'Москва_Я.Маркет_Цена');
        // define('PRICE_SPEC_MARKET__CODE', 'Москва_Я.Маркет_СпецЦена');
        break;
    case 'm2':
        define('PRICE_BASE__CODE', 'СПБ_Я.Маркет_Цена');
        define('PRICE_BASE_SPEC__CODE', 'СПБ_Я.Маркет_СпецЦена');
        // define('PRICE_MARKET__CODE', 'СПБ_Я.Маркет_Цена');
        // define('PRICE_SPEC_MARKET__CODE', 'СПБ_Я.Маркет_СпецЦена');
        break;
    default:
        define('PRICE_BASE__CODE', 'Продажа на сайте');
        define('PRICE_BASE_SPEC__CODE', '');
    // define('PRICE_MARKET__CODE', '');
    // define('PRICE_SPEC_MARKET__CODE', '');
}

// var_dump(SITE_ID);
// var_dump(PRICE_BASE__CODE);
// var_dump(PRICE_MARKET__CODE);
// var_dump(PRICE_SPEC_MARKET__CODE);