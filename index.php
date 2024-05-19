<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raktár</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="mainBody">
        <div class="upLoadBt">
            <a href="login_form.php" class="blueBtn">Bejelentkezés</a>
            <a href="register_form.php" class="blueBtn">Regisztráció</a>
            <form action="setupDatabase.php" method="post">
                <input type="submit" name="upload" value="Adatbázis feltöltése" class="blueBtn2">
            </form>
            <form action="mail.php" method="post">
                <input type="submit" name="sendEmail" value="Email küldése" class="blueBtn2">
            </form>
        </div>
        
    </div>
</body>
<script src="index.js"></script>
</html>
