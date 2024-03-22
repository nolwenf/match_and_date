<?php

if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["sexe"]) && isset($_POST["age"]) && isset($_POST["ville"]) && isset($_POST["description"])) {
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sexe = $_POST["sexe"];
    $age = $_POST["age"];
    $qualite = $_POST["ville"];
    $description = $_POST["description"];

    // Ouvrir le fichier users.csv en mode écriture
    $file = fopen("users.csv", "a+");

    if (!is_numeric($age)) {
        echo "Age must be a number";
        exit();
    }
    $found = false;
    while(!feof($file)) {
        $line = fgetcsv($file);
        if($line[2] == $username) {
            $found = true;
            break;
        }
    }
    if($found) {
        echo "Username already exists";
        exit();
    }
    if(strlen($description) > 50) {
        echo "Bio too long";
        exit();
    }
    // Écrire les données de l'utilisateur dans le fichier CSV
    fputcsv($file, array($prenom, $nom, $username, $password, $sexe, $age, $qualite, $description));

    // Fermer le fichier
    fclose($file);

    // Démarrer une session pour l'utilisateur nouvellement créé
    session_start();
    $_SESSION["currentUser"] = $username;
    // Rediriger l'utilisateur vers la page de match
    header("Location: match.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/register.css"/>

    <title>Match & Date</title>
</head>
<body>

    <section class="login" id="login">
        <div class="head">
            <img src="image/logo1.png" alt="logo" class="titre" width="300px" height="200px">
        </div>
        <h2 class="message"> Commencez à matcher !</h2>
        <div class="form">
            <form method="post" action="register.php">
                <label> Prénom : </label> <br><br>
                <input type="text" placeholder="Prénom" class="text" name="prenom" required> <br><br>
                <label> Nom : </label> <br><br>
                <input type="text" placeholder="Nom" class="text" name="nom" required> <br><br>
                <label> Nom d'utilisateur : </label> <br><br>
                <input type ="text" placeholder="Nom d'utilisateur" class="text" name="username" required> <br><br>
                <label> Mot de passe : </label>
                <input type ="password" placeholder="Mot de passe" name="password" class="password">
                <p> Sexe : </p>
                <input type ="radio" name="sexe" id="m" value="m">
                <label for="m">Homme</label>
                <input type="radio" name="sexe" id="f" value="f">
                <label for="f">Femme</label> <br><br>
                <label> Age </label> <br><br>
                <input type="text" placeholder="Age" class="text" name="age" required> <br><br>
                <label> Qualite : </label> <br><br>
                <input type="text" placeholder="Qualite" class="text" name="ville" required> <br><br>
                <label> Bio : </label> <br><br>
                <textarea placeholder="Bio" class="bio" name="description" required></textarea> <br><br>
                <input type="submit" placeholder="S'inscrire" class="btn-login" id="submit" value="S'inscrire"> <br><br>
                <a href="login.php" class="register"> Vous avez déjà un compte ? Se connecter </a>
            </form>
        </div>
    </section>
</body>
</html>