<?php
/**
 * Created by Artmix.
 * User: Oleg Maksimenko <oleg.39style@gmail.com>
 * Date: 11.02.2016
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$deleteParams = array('ajax_page');

$arResult['sUrlPathParams'] = CHTTP::urlDeleteParams($arResult['sUrlPathParams'], $deleteParams);

parse_str(html_entity_decode($arResult['NavQueryString']), $queryString);

if (is_array($queryString)) {
    $arResult['NavQueryString'] = http_build_query(
        array_diff_key(
            $queryString,
            array_flip($deleteParams)
        )
    );
}