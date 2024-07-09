<?php

switch (SITE_ID) {
    case 'm1':
        define('PRICE_BASE__CODE', 'Соглашение МоскваЯ.МаркетЦена');
        define('PRICE_BASE_SPEC__CODE', 'Соглашение МоскваЯ.МаркетСпецЦена');
        define('PRICE_BASE__CODE_ID', 6); //Москва_Я.Маркет_Цена
        define('PRICE_BASE_SPEC__CODE_ID', 7); //Москва_Я.Маркет_СпецЦена
        break;
    case 'm2':
        define('PRICE_BASE__CODE', 'Соглашение СПБЯ.МаркетЦена');
        define('PRICE_BASE_SPEC__CODE', 'Соглашение СПБЯ.МаркетСпецЦена');
        define('PRICE_BASE__CODE_ID', 8); //СПБ_Я.Маркет_Цена
        define('PRICE_BASE_SPEC__CODE_ID', 9); //СПБ_Я.Маркет_СпецЦена
        break;
    default:
        define('PRICE_BASE__CODE', 'Продажа на сайте');
        define('PRICE_BASE__CODE_ID', 2); //Продажа на сайте
        define('PRICE_BASE_SPEC__CODE_ID', 0);
}