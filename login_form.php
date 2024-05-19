<?php
@include 'config.php';
session_start();

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);

    if($pass != $cpass){
        $error[] = 'A jelszavak nem egyeznek!';
    } else {
        $select = "SELECT password, role FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $dbPassword = $row['password'];
            $role = $row['role'];
            

            if($pass == $dbPassword){
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['name'] = $row['name'];
                
                if($role == 'admin'){
                    header('location:indexA.php');
                } elseif($role == 'látogató'){
                    header('location:indexL.php');
                } elseif($role == 'szerkesztő'){
                    header('location:indexSz.php');
                } else {
                    echo 'Ismeretlen szerep';
                }
            } else {
                $error[] = 'Sikertelen bejelentkezés, hibás jelszó!';
            }
        } else {
            $error[] = 'Sikertelen bejelentkezés, nincs ilyen felhasználó!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
<div class="form-container">
    <form action="" method="post">
        <h3>Bejelentkezés</h3>
        <?php if(isset($error)): ?>
            <?php foreach($error as $error): ?>
                <span class="error-msg"><?= $error ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
        <input type="email" name="email" required placeholder="Adja meg az email címét!">
        <input type="password" name="password" required placeholder="Adja meg a jelszavát!">
        <input type="password" name="cpassword" required placeholder="Adja meg újból a jelszavát!">
        <input type="submit" name="submit" value="Bejelentkezés" class="form-btn">
        <a href="forgot_password.php">Elfelejtett jelszó</a>
        <p>Még nincsen fiókja? <a href="register_form.php">Regisztráljon most!</a></p>
    </form>
</div>

</body>
</html>
