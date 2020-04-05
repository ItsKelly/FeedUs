<?php

If (isset($_POST['mail'])) {
// Load Composer's autoloader
    require 'phpmailer/PHPMailerAutoload.php';

// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer();// Enable verbose debug output
    $mail ->CharSet="UTF-8" ;
    $mail->isSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl'; // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->Port = 465;
    $mail->isHTML(true);
    $mail->Username = 'kaliyoav@gmail.com';                     // SMTP username
    $mail->Password = '318914843';
    $mail->setFrom('kaliyoav@gmail.com', 'FEEDUS');// SMTP password     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->Subject = 'הזמנה מאת FEEDUS';
    $mail->Body = 'מצרפים הזמנה חדשה';
    $mail->addAddress('yoavkal@post.bgu.ac.il');               // Name is optional

    $mail->addAttachment('C:\wamp\www\feedus\images\burger.png','הזמנה');         // Add attachments
    /// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name


    if (!$mail->send()) {
        echo "mail not sent";
    } else {
        echo "mail sent"; // for commiting
    }
}
?>