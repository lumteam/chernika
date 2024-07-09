<?php
/**
 * Created by Artmix.
 * User: Oleg Maksimenko <oleg.39style@gmail.com>
 * Date: 11.02.2016
 */

use \Bitrix\Main\Page\Asset;

//\Bitrix\Main\Page\Asset::getInstance()->addJs('/bitrix/js/artmix.ajaxpagination/axpajax.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/axpajax.js');