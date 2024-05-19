<?php
namespace src;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

function sendMail($to, $new_password) {
    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'localhost';                           // Specify main and backup SMTP servers
        $mail->SMTPAuth = false;                               // Enable SMTP authentication
        $mail->Port = 1025;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('your_hotmail_email@hotmail.com', 'Your Name');
        $mail->addAddress($to);                               // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Elfelejtett jelszó';
        $mail->Body    = 'Az új jelszó: ' . $new_password;
        $mail->AltBody = 'Az új jelszó: ' . $new_password;

        $mail->send();
        echo 'Az új jelszó elküldve az email címre!';
    } catch (Exception $e) {
        echo "Hiba történt az email küldése közben: {$mail->ErrorInfo}";
    }
}

if(isset($_POST['submit'])){
    $new_password = generateRandomPassword(10);  
    sendMail($_POST['email'], $new_password);

    // Adatbázis-kapcsolat létrehozása és új jelszó frissítése
    @include 'config.php';

    $email = $_POST['email'];
    $hashed_password = md5($new_password);

    $update_query = "UPDATE user_form SET password = '$hashed_password' WHERE email = '$email'";

    if(mysqli_query($conn, $update_query)) {
        echo 'Az új jelszó sikeresen frissítve az adatbázisban!';
    } else {
        echo 'Hiba történt az új jelszó frissítése közben: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
