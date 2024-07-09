<?php
//ES -- 31_10_2023
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/iblock/lib/template/functions/fabric.php');
//ES -- 31_10_2023

use Bitrix\Main\Loader,
    Bitrix\Main\Page\Asset;

$includeFilesList = [
    $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/defines.php',
    $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/price_defines.php',
    $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/redirect.php',
    $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/autoload.php',
    $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/handlers.php',
];


foreach ($includeFilesList as $fileToInclude) {
    if (file_exists($fileToInclude)) {
        include_once($fileToInclude);
    }
}

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    //$arOrder = CSaleOrder::GetByID($orderID);

    //$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);

    //Energosoft 2023
    $dbBasketItems = CSaleBasket::GetList(false,
        array(
            'ORDER_ID' => $orderID
        ),
        false,
        false,
        array(
            'PRODUCT_ID','NAME','PRICE'
        )
    );
    while ($arItems = $dbBasketItems->Fetch()) {
        $orderedItems[] = $arItems['PRODUCT_ID']."/". $arItems['NAME']."/".$arItems['PRICE'];
    }

    $orderList = "";
    if(count($orderedItems) >= 1) {
        $orderList = implode(', ',$orderedItems);
    }

   $add_info = 'Служба доставки: ';
    $arOrder = CSaleOrder::GetByID($orderID);
    
if($arOrder[DELIVERY_ID] == 'rus_post:land'){$add_info.="Почта России Наземная доставка";}
if($arOrder[DELIVERY_ID] == '3'){$add_info.="Самовывоз из салона — м. Новые Черёмушки";}
if($arOrder[DELIVERY_ID] == '16'){$add_info.="Доставка по Санкт-Петербургу, более 6000 руб";}
if($arOrder[DELIVERY_ID] == '17'){$add_info.="Доставка по Санкт-Петербургу, 0.00 руб";}
if($arOrder[DELIVERY_ID] == '11'){$add_info.="Самовывоз из салона — м. Белорусская";}
if($arOrder[DELIVERY_ID] == '12'){$add_info.="Самовывоз из салона — м. Технологический институт";}
if($arOrder[DELIVERY_ID] == '13'){$add_info.="Самовывоз из салона — м. Проспект Просвещения";}
    $order_props = CSaleOrderPropsValue::GetOrderProps(4810);
    while ($arProps = $order_props->Fetch()){
        // adress
        if ($arProps['ORDER_PROPS_ID']==5){
            $add_info.=' Адрес доставки: '.$arProps['VALUE'];
        }
    }

    // end----

    $name  = $_POST["ORDER_PROP_1"];
    $email = $_POST["ORDER_PROP_2"];
    $phone = $_POST["ORDER_PROP_3"];

    $referer     = $_POST["referer"];
    $freferer    = $_POST["freferer"];
    $clientID    = $_POST["clientID"];
    $utm_content = urldecode($_SESSION['utm_content']);

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: info@chernika-optika.ru\r\n";
    $headers .= "Reply-To: info@chernika-optika.ru\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = "<b>Заявка с сайта</b><br/><br/>";
    $message .= "Номер заказа: " . $orderID . "<br/>";
    $message .= "Имя: " . $name . "<br/>";
    $message .= "Email: " . $email . "<br/>";
    $message .= "Телефон: " . $phone . "<br/>";
    $message .= "<b>UTM</b><br/><br/>";
    $message .= "utm_source: " . $_SESSION['utm_source'] . "<br/>";
    $message .= "utm_medium: " . $_SESSION['utm_medium'] . "<br/>";
    $message .= "utm_campaign: " . $_SESSION['utm_campaign'] . "<br/>";
    $message .= "utm_content: " . $utm_content . "<br/>";
    $message .= "utm_term: " . $_SESSION['utm_term'] . "<br/>";

    mail('leads+chernika@idclient.ru', 'chernika-optika', $message, $headers);

//Energo-soft 2023 - Report
$es_source = "Заявка ".date('Y-m-d H:i:s');
$es_description = "Номер заказа:".$orderID." Товары:".$orderList." ".$add_info;
$es_contact = "Имя:".$name." Email:".$email;
$es_phone=$phone;

$queryParams = [
    'source' => $es_source,
    'description' => $es_description,
    'contact' => $es_contact,
    'phone' => $es_phone,
];
$queryUrl ='https://script.google.com/macros/s/AKfycbwhhgMKf6rFpOrWkt40Nvq5vPjOS54cW9RbgpoONiLbfvWwz4I-MJUHMPwzSFZ599yR/exec?';

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_POST => 1,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_ENCODING => 0,
  CURLOPT_URL => $queryUrl,
  CURLOPT_POSTFIELDS =>$queryParams,
));
$result = curl_exec($curl);
curl_close($curl);

// end

//Energo-soft 2023-B24 lead add
$data = array();

$data['name']   = $name;
$data['phone']  = $phone;
$data['email']  = $email;
$data['comments'] = "Товары : ".$orderList." ".$add_info ;

$str1 = $_COOKIE['sbjs_current'];
$arData = array();
foreach(explode("|||", $str1) as $v1)
{
    $v2= explode("=", $v1);
    if(count((array)$v2) == 2) $arData[$v2[0]] = $v2[1];
}

$data['utm_source']   = $arData['typ'];
$data['utm_medium']   = $arData['mdm'];
$data['utm_campaign'] = $arData['cmp'] ;
$data['utm_content']  = $arData['src'];
$data['utm_term']     = $arData['trm'];

$data['clientID']     = isset($_POST["clientID"])     ? str_replace('_', '', $_POST["clientID"])      : "";


$title    = 'Заявка с сайта. Заказ №'.$orderID;
$user_id  = 9;
$queryUrl = 'https://chernika-optica.bitrix24.ru/rest/35/9ny4r63m4mixzhty/crm.lead.add.json';

$queryData = http_build_query(
    array(
        'fields' => array(
            "TITLE"          => $title, 
            "NAME"           => $data['name'], 
            "ASSIGNED_BY_ID" => $user_id, 
            'SOURCE_ID'      => "WEB",
            "STATUS_ID"      => "NEW",
            "OPENED"         => "Y",
            "EMAIL"          => array( array( 'VALUE' => $data['email'], 'VALUE_TYPE' => 'HOME' ) ) ,
            "PHONE"          => array( array( 'VALUE' => $data['phone'], 'VALUE_TYPE' => 'HOME' ) ) , 
"COMMENTS" => $data['comments'],           
            // utm-метки
            'UTM_CAMPAIGN' => $data['utm_campaign'],    
            'UTM_CONTENT'  => $data['utm_content'],
            'UTM_MEDIUM'   => $data['utm_medium'],
            'UTM_SOURCE'   => $data['utm_source'],
            'UTM_TERM'     => $data['utm_term'],
        ), 'params' => array("REGISTER_SONET_EVENT" => "Y")
    )
);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, 1);

if (array_key_exists('error', $result)) echo "Ошибка: ".$result['error_description']."";


// end ----

    //$hostname = '185.105.226.25';
    //$username = 'chernika_leads';
    //$password = 'VK6HogEAysDay8NX';
    //$dbName   = 'chernika_leads';
    $hostname = '5.188.28.75';
    $username = 'leads_chern_usr';
    $password = 'tEZDAdWoHg92Jq7x';
    $dbName   = 'leads_chernikaoptika';
    // Подключение к БД.
    $mysqli = new mysqli($hostname, $username, $password);
    $mysqli->query("SET NAMES 'utf8';");
    $mysqli->query("SET CHARACTER SET 'utf8';");
    $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");
    $mysqli->select_db($dbName);

    $t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
                  VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

    $page       = SITE_DOMAIN . '/personal/cart/';
    $date_today = date("Y-m-d");
    $time       = date("H:i:s");

    $query = sprintf($t, $date_today, $time, $page, $_SESSION['utm_source'], $_SESSION['utm_medium'],
        $_SESSION['utm_campaign'], $utm_content, $_SESSION['utm_term'], $name, $phone, $email,
        "Номер заказа: " . $orderID, 'Корзина', $referer, $freferer, "_" . $clientID);


    $result = $mysqli->query($query);
}

function getHeaderInfo($cityName)
{
    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();

    $headerInfoContent = '';
    //    $cacheId = 'header_info';
    $arrFilter = [
        'IBLOCK_ID'   => 66, // ИБ Инфо в шапке
        'ACTIVE'      => 'Y',
        'ACTIVE_DATE' => 'Y',
    ];
    if (isset($cityName)) {
        $arrFilter['PROPERTY_CITY'] = $cityName;
    }
    $cacheTtl = 60 * 60 * 3; // 3 часа
    $cacheId  = serialize($arrFilter);

    if ($cache->read($cacheTtl, $cacheId)) {
        $headerInfoContent = $cache->get($cacheId); // достаем переменные из кеша
    } elseif (Loader::includeModule('iblock')) {
        $dbElements = \CIBlockElement::GetList(
            [
                'sort' => 'asc',
            ],
            $arrFilter,
            false,
            [
                'nTopCount' => 1,
            ],
            [
                'ID', 'CODE', 'NAME', 'DETAIL_TEXT', 'PROPERTY_MESSAGE_TYPE',
            ]
        );

        if ($arFields = $dbElements->Fetch()) {
            $headerInfoContent = $arFields['DETAIL_TEXT'];

            if ( ! empty($arFields['PROPERTY_MESSAGE_TYPE_VALUE'])) {
                $headerInfoContent
                    = '<div class="header-info-container collapsible" style="background-color:'
                    . $arFields['PROPERTY_MESSAGE_TYPE_VALUE'] . '">' .
                    '<div class="header-info-container_wrapper">' .
                    '<div class="position_r">' .
                    $headerInfoContent .
                    '<button id="header-info-container_close-btn" type="button" class="btn-close">×</button>' .
                    '</div>' .
                    '</div>' .
                    '</div>';
            }
        }
        unset($arFields, $dbElements);

        $cache->set($cacheId, $headerInfoContent); // записываем в кеш
    }

    if ( ! empty($headerInfoContent)) {
        $asset = Asset::getInstance();
        $asset->addJs(SITE_TEMPLATE_PATH . '/js/headerInfo.js');
    }

    return $headerInfoContent;
}




if (!function_exists('custom_mail') && COption::GetOptionString("webprostor.smtp", "USE_MODULE") == "Y")
{
   function custom_mail($to, $subject, $message, $additional_headers='', $additional_parameters='')
   {
      if(CModule::IncludeModule("webprostor.smtp"))
      {
         $smtp = new CWebprostorSmtp("s1");
         $result = $smtp->SendMail($to, $subject, $message, $additional_headers, $additional_parameters);

         if($result)
            return true;
         else
            return false;
      }
   }
}

class ESAgents
{
	public static function GIS()
	{
		file_get_contents("https://chernika-optika.ru/gis.php");
		file_get_contents("https://spb.chernika-optika.ru/gis.php");
		return "ESAgents::GIS();";
	}

	public static function SEO()
	{
		$js = file_get_contents("https://mc.yandex.ru/metrika/tag.js");
		if($js !== false && $js !== "") file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/chernika/js/seo/tag.js", $js);;

		$js = file_get_contents("https://my.zadarma.com/js/ct_phone.min.js");
		if($js !== false && $js !== "") file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/chernika/js/seo/ct_phone.min.js", $js);;

		return "ESAgents::SEO();";
	}
}

//ES -- 31_10_2023
$eventManager = Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler("iblock", "OnTemplateGetFunctionClass", "myOnTemplateGetFunctionClass");
function myOnTemplateGetFunctionClass(Bitrix\Main\Event $event)
{
	$arParam = $event->getParameters();
	$functionClass = $arParam[0];
	if(is_string($functionClass) && class_exists($functionClass) && $functionClass=='city')
	{
		$result = new Bitrix\Main\EventResult(1, $functionClass);
		return $result;
	}
}
class city extends Bitrix\Iblock\Template\Functions\FunctionBase
{
	public function onPrepareParameters(\Bitrix\Iblock\Template\Entity\Base $entity, $parameters)
	{
		$arguments = array();
		/** @var \Bitrix\Iblock\Template\NodeBase $parameter */
		foreach ($parameters as $parameter)
		{
			$arguments[] = $parameter->process($entity);
		}
		return $arguments;
	}

	public function calculate(array $parameters)
	{
		return $_SESSION['GEO_IP']['NAME_DECLENSION'];
	}
}
//ES -- 31_10_2023
