<?php
if(isset($_POST["last_name"]) && $_POST["last_name"] == "") {

require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';
require_once 'phpmailer/src/Exception.php';


$hostname = '5.188.28.75';
$username = 'leads_chern_usr';
$password = 'tEZDAdWoHg92Jq7x';
$dbName   = 'leads_chernikaoptika';

$mysqli = new mysqli($hostname, $username, $password);
$mysqli->query("SET NAMES 'utf8';");
$mysqli->query("SET CHARACTER SET 'utf8';");
$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");
$mysqli->select_db($dbName);



	$name           = $_POST['name'];
	$phone          = $_POST['phone'];
	$form           = $_POST['form'];
	$promocode		= $_POST['promocode'];
	$comment		= $_POST['comment'];
	$salonID 		= $_POST['rezrvSalonID'];
	$product 		= $_POST['product'];
	  
	$utm_source     = $_POST['utm_source'];
	$utm_medium     = $_POST['utm_medium'];
	$utm_content    = $_POST['utm_content'];
	$utm_campaign   = $_POST['utm_campaign'];
	$utm_term       = $_POST['utm_term'];
	$referer        = $_POST['referer'];
	$f_referer      = $_POST['f_referer'];
	$clientID       = '_'.$_POST['clientID'];

	$page           = $_SERVER['HTTP_REFERER'];
	$date_today 	= date("Y-m-d");
	$time 			= date("H:i:s"); 

if ($salonID=='5981'){
	$salonID = 'МСК | Бутырский Вал, дом 4';
}else if ($salonID=='49436') {
	$salonID = 'МСК | Профсоюзная д. 64';
}else if ($salonID=='3') {
	$salonID = 'СПБ | 1-я Красноармейская дом 8-1';
}else if ($salonID=='4') {
	$salonID = 'СПБ | Просвещения, дом 32';
}

$mess = "<h3> Заявка</h3>
	<table cellpadding='5' cellspacing='5' border='1' width='100%'>
		<tr>
			<td width='200'>Клиент:</td>
			<td>$name</td>
		</tr>
		<tr>
			<td>Телефон:</td>
			<td>$phone</td>
		</tr>
		<tr>
			<td>Комментарий:</td>
			<td>$comment</td>
		</tr>
		<tr>
			<td>Товар:</td>
			<td>$product</td>
		</tr>
		<tr>
			<td>Салон:</td>
			<td>$salonID</td>
		</tr>
	</table>
	<h3>Форма</h3>
	<table cellpadding='5' cellspacing='5' border='1' width='100%'>
		<tr>
			<td width='100'>Форма</td>
			<td>$form</td>
		</tr>
		<tr>
			<td>Промокод:</td>
			<td>$promocode</td>
		</tr>
	</table>";
$messUTM = "<h3>UTM метки</h3>
	<table cellpadding='5' cellspacing='5' border='1' width='100%'>
		<tr>
			<td width='200'>utm_source</td>
			<td>$utm_source</td>
		</tr>
		<tr>
			<td width='100'>utm_medium</td>
			<td>$utm_medium</td>
		</tr>
		<tr>
			<td width='100'>utm_campaign</td>
			<td>$utm_campaign</td>
		</tr>
		<tr>
			<td width='100'>utm_content</td>
			<td>$utm_content</td>
		</tr>
		<tr>
			<td width='100'>utm_term</td>
			<td>$utm_term</td>
		</tr>
		<tr>
			<td width='100'>Url</td>
			<td>$page</td>
		</tr>
		<tr>
			<td width='100'>Referer</td>
			<td>$referer</td>
		</tr>
		<tr>
			<td width='100'>First referer</td>
			<td>$f_referer</td>
		</tr>
		<tr>
			<td width='100'>ClientID</td>
			<td>$clientID</td>
		</tr>
	</table>";

   
$mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;
    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера 
    $mail->Username   = 'chernikaoptika@mail.ru'; // Логин на почте
    $mail->Password   = '6gzxKVzuTbevjnaPDChJ'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('chernikaoptika@mail.ru', 'Черника оптика'); // Адрес самой почты и имя отправителя
    // Получатель письма
    //$mail->addAddress('lite.creativ@yandex.ru');
    $mail->addAddress('anastasia.souz-optika@yandex.ru');
    $mail->addAddress('mega-optika@yandex.ru');
    $mail->addAddress('megaoptika.ru@gmail.com');
 $mail->addAddress('info@chernika-optika.ru');

  


    
        // -----------------------
        // Само письмо
        // -----------------------
        $mail->isHTML(true);
    
        $mail->Subject = 'Резерв в салоне'.' - '.$salonID;
        $mail->Body    = $mess;
        $mail->send();
       
     sleep(1);

    $mail->ClearAddresses();
   
    //$mail->addAddress('lite.creativ@yandex.ru');
    $mail->addAddress('leads+chernika@idclient.ru');
    
    
    // Само письмо
    $mail->isHTML(true);

    $mail->Subject = 'Резерв в салоне'.' - '.$salonID;
    $mail->Body    = $mess . $messUTM;        
    $mail->send();


$t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

$query = sprintf($t, $date_today, $time, $page, $utm_source, $utm_medium, $utm_campaign, $utm_content, $utm_term, $name, $phone, '', $promocode, $form, $referer, $freferer, $clientID);
$result = $mysqli->query($query);


header('Location:/spasibo');
   	} else {
	header('Location:/');
}

//Energo-soft 2023 - Report
$es_source = "Примерка в салоне ".date('Y-m-d H:i:s');
$es_description = "Товар:".$product.",Комментарий:".$comment.", Салон:".$salonID;
$es_contact = $name;
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

?>
