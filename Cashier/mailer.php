<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';


$mail = new PHPMailer(true);

//$mail->SMPTDebug = SMPT::DEBUG SERVER;

$mail->isSMTP();
$mail->SMPTAuth =true;

$mail->Host ='smtp.gmail.com';
$mail->SMPTSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = 'kasunshyapabodi2002@gmail.com';
$mail->Password = 'tvca kcbr kxtq ryrv';

$mail->isHtml(true);
return $mail;

?>






