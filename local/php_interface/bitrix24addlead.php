<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$data = array();

$data['name']   = isset($_POST["name"])   ? $_POST["name"]    : "";
$data['phone']  = isset($_POST["telephone"])   ? $_POST["telephone"]    : "";
$data['email']  = isset($_POST["mail"])   ? $_POST["mail"]    : "";

$data['utm_source']   = isset($_POST["utm_source"])   ? $_POST["utm_source"]    : "";
$data['utm_medium']   = isset($_POST["utm_medium"])   ? $_POST["utm_medium"]    : "";
$data['utm_campaign'] = isset($_POST["utm_campaign"]) ? $_POST["utm_campaign"]  : "";
$data['utm_content']  = isset($_POST["utm_content"])  ? $_POST["utm_content"]   : "";
$data['utm_term']     = isset($_POST["utm_term"])     ? $_POST["utm_term"]      : "";



$title    = 'Лид chernika-optika.ru';
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

?>