<?php

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('CHK_EVENT', true);
define('SITE_ID' , 's1');

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__) . "/../..");
$DOCUMENT_ROOT            = $_SERVER["DOCUMENT_ROOT"];

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

\PDV\YML::exportYml(
    '/var/www/chernika/prod/upload/feedMskYml.xml',
    'chernika-optika.ru',
    'msk',
    false,
    's1',
    0,
    ''
);
// /usr/bin/php7.4 /var/www/chernika/prod/public/chernika/local/php_interface/marketMskYml.php