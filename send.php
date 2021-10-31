<?php
// Файлы phpmailer
require 'src/phpmailer/PHPMailer.php';
require 'src/phpmailer/SMTP.php';
require 'src/phpmailer/Exception.php';

// Формирование самого письма
$title = "Новое обращение Best Tour Plan";

if (isset($_POST['send-footer'])) {
    // Переменные, которые отправляет пользователь
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $body = "
    <h2>Новое обращение</h2>
    <b>Имя:</b> $name<br>
    <b>Телефон:</b> $phone<br><br>
    <b>Сообщение:</b><br>$message
    ";
} else if (isset($_POST['send-newslatter'])) {
    $email = $_POST['newslatter-email'];
    $body = "
    <h2>Новое обращение</h2>
    <b>Почта:</b> $email";
}



// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'pidor2740@gmail.com'; // Логин на почте
    $mail->Password   = 'gahyhagan1'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('pidor2740@gmail.com', 'Роман Музылев'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('mohnakirill@gmail.com');

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отравленность сообщения
    if ($mail->send()) {
        $result = "success";
    } else {
        $result = "error";
    }
} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
header('Location: thankyou.html');
