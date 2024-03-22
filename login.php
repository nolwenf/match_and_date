<?php
    //called php when button is pressed

    session_start();
    // open users.csv and check if user == username and password == password
    // if yes, set $_SESSION["currentUser"] = username
    // else, display error message
    // if user is already logged in, redirect to match.php
    if(isset($_SESSION["currentUser"])) {
        header("Location: match.php");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $file = fopen("users.csv", "r");
        $found = false;
        while (!feof($file)) {
            $line = fgetcsv($file);
            if ($line[2] == $username && $line[3] == $password) {
                $found = true;
                break;
            }
        }
        fclose($file);
        if ($found) {
            $_SESSION["currentUser"] = $username;
            header("Location: match.php");
            exit();
        } else {
            echo "<script>alert('Wrong username or password');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/login.css"/>

    <title>Match & Date</title>
</head>
<body>

    <section class="login" id="login">
        <div class="head">
            <img src="image/logo1.png" alt="logo" class="titre" width="300px" height="200px">
        </div>
        <h2 class="message"> Prêt à matcher ?</h2>
        <div class="form">
            <form method="post" action="login.php">
                <input type ="text" placeholder="Nom d'utilisateur" class="text" name="username" required>
                <br>
                <input type ="password" placeholder="Mot de passe" class="password" name="password">
                <br>
                <input type="submit" placeholder="Se connecter" class="btn-login" id="submit" value="Se connecter">
                <br>
                <br>
                <a href="register.php" class="register"> Vous n'avez pas encore de compte ? S'inscrire </a>
            </form>
        </div>
    </section>
</body>
</html>