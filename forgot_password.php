<?php
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

if(isset($_POST['submit'])){
    $new_password = generateRandomPassword(10);

    $to = $_POST['email'];
    $subject = 'Elfelejtett jelszó';
    $message = 'Az új jelszó: ' . $new_password;
    $headers = 'From: your_email@example.com';

    if(mail($to, $subject, $message, $headers)){
        echo 'Az új jelszó elküldve az email címre!';
    } else {
        echo 'Hiba történt az email küldése közben.';
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Elfelejtett jelszó</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<div class="form-container">
   <form action="newpassword.php" method="post">
      <h3>Elfelejtett jelszó</h3>
      <input type="email" name="email" required placeholder="Adja meg az email címét!">
      <input type="submit" name="submit" value="Email küldése" class="form-btn">
   </form>
</div>

</body>
</html>
