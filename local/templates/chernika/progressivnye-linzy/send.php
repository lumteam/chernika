<?php
if(isset($_POST["last_name"]) && $_POST["last_name"] == "") {
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
require_once 'phpmailer/Exception.php';


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
	$promocode			= $_POST['promocode'];
	  

	$utm_source     = $_POST['utm_source'];
	$utm_medium     = $_POST['utm_medium'];
	$utm_content    = $_POST['utm_content'];
	$utm_campaign   = $_POST['utm_campaign'];
	$utm_term       = $_POST['utm_term'];
	$referer        = $_POST['referer'];
	$f_referer      = $_POST['f_referer'];
	$clientID       = '_'.$_POST['clientID'];

	$page           = $_SERVER['HTTP_REFERER'];
	$date_today 		= date("Y-m-d");
	$time 					= date("H:i:s"); 

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

   

  
    for ($ct = 0; $ct < count($_FILES['files']['tmp_name']); $ct++) {
        $uploadfile = tempnam("uploads/", sha1($_FILES['files']['name'][$ct]));
        $filename = $_FILES['files']['name'][$ct];
        if (move_uploaded_file($_FILES['files']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        }
    };
    

    
        // -----------------------
        // Само письмо
        // -----------------------
        $mail->isHTML(true);
    
        $mail->Subject = 'Заявка Прогрессивные линзы';
        $mail->Body    = $mess;
        $mail->send();
       
     sleep(1);

    $mail->ClearAddresses();
   
    //$mail->addAddress('lite.creativ@yandex.ru');
    $mail->addAddress('leads+chernika@idclient.ru');
    
    
    // Само письмо
    $mail->isHTML(true);

    $mail->Subject = 'Заявка Прогрессивные линзы';
    $mail->Body    = $mess . $messUTM;        
    $mail->send();


$t = "INSERT INTO leads_chernica (date, time, url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, telefon, email, message, forma, referer, freferer, clientID)
VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";

$query = sprintf($t, $date_today, $time, $page, $utm_source, $utm_medium, $utm_campaign, $utm_content, $utm_term, $name, $phone, '', $promocode, $form, $referer, $freferer, $clientID);
$result = $mysqli->query($query);


header('Location:/spasibo/');
   	} else {
	header('Location:/');
}
?>
