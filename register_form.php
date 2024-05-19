<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $role = mysqli_real_escape_string($conn, $_POST['role']);

   $select = "SELECT * FROM users WHERE email = '$email'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'Ilyen felhasználó már létezik!';

   } else {

      if($pass != $cpass){
         $error[] = 'A jelszó nem egyezik!';
      } else {
         $insert = "INSERT INTO users(name, email, password, role) VALUES('$name','$email','$pass','$role')";
         mysqli_query($conn, $insert);
         require_once 'C:\xampp\htdocs\phpBeadando\token.php';
         header('location:token.php');
      }
   }

};
?>

<!DOCTYPE html>
<html lang="hu">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Regisztrációs űrlap</title>
   <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Regisztráljon most!</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Adja meg a nevét!">
      <input type="email" name="email" required placeholder="Adja meg az email címét!">
      <input type="password" name="password" required placeholder="Adja meg a jelszavát!">
      <input type="password" name="cpassword" required placeholder="Írja be még egyszer a jelszavát!">
      <select name="role" required>
         <option value="látogató">Látogató</option>
         <option value="szerkesztő">Szerkesztő</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Regisztráció" class="form-btn">
      <p>Már van fiókja? <a href="login_form.php">Bejelentkezés most</a></p>
   </form>

</div>

</body>
</html>
