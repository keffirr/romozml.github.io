<?php
$fio = $_SERVER['fio'];
$email = $_SERVER['email'];
$fio = htmlspecialchars($fio);
$email = htmlspecialchars($email);
$fio = urldecode($fio);
$email = urldecode($email);
$fio = trim($fio);
$email = trim($email);
//echo $fio;
//echo "<br>";
//echo $email;
if (mail("xuipidr0@gmail.com", "Заявка с сайта", "ФИО:".$fio.". E-mail: ".$email ,"From: admin@romoz.ml \r\n"))
 {     echo "сообщение успешно отправлено";
} else {
    echo "при отправке сообщения возникли ошибки";
}?>
