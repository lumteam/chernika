<?php

$psevdo_page_arr = include($_SERVER['DOCUMENT_ROOT'] . "/upload/psevdo_page.php");
foreach ($psevdo_page_arr as $oldUrl => $newUrl) {
    if ($_SERVER['REQUEST_URI'] == $oldUrl) {
        $_SERVER['REQUEST_URI'] = $newUrl;
        break;
    }
}

include($_SERVER['DOCUMENT_ROOT'] . '/bitrix/urlrewrite.php');