<?php
namespace src;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);

 
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($result) > 0) {
     
        $token = bin2hex(random_bytes(4));
        $update_query = "UPDATE users SET token = '$token', token_valid_until = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = '$email'";
        
        if(mysqli_query($conn, $update_query)) {
            echo 'Az új token sikeresen frissítve az adatbázisban!';
            sendMail($email, $token, $conn);
        } else {
            echo 'Hiba történt az új token frissítése közben: ' . mysqli_error($conn);
        }
    } else {
       
        $token = bin2hex(random_bytes(4));
        $insert_query = "INSERT INTO users (email, token, token_valid_until) VALUES ('$email', '$token', DATE_ADD(NOW(), INTERVAL 10 MINUTE))";
        
        if(mysqli_query($conn, $insert_query)) {
            echo 'Az új felhasználó regisztrálva és a token sikeresen mentve az adatbázisba!';
            sendMail($email, $token, $conn);
        } else {
            echo 'Hiba történt az új felhasználó regisztrációja és token mentése közben: ' . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}

function sendMail($to, $token, $conn) {
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
        $mail->Subject = 'Token';
        $mail->Body    = 'Token: ' . $token . '<br> <a href="http://localhost:84/phpBeadando/login_form.php?token='.$token.'">Bejelentkezés</a>';
        $mail->AltBody = 'Token: ' . $token;

        $mail->send();
        echo 'A token elküldve az email címre!';
    } catch (Exception $e) {
        echo "Hiba történt az email küldése közben: {$mail->ErrorInfo}";
    }
}
?>
