<?php
    session_start();
    if(!isset($_SESSION["currentUser"])) {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/index.css"/>
    <link rel="stylesheet" type="text/css" href="style/match.css"/>
    <link rel="stylesheet" type="text/css" href="style/bouton.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/logo2.ico">
    <title> Match & Date </title>
</head>

    <body>
        <div class="bandeau">
            <div id="log">
                <img src="image/logo2.png" alt="logo" class="logo" width="8%" height="20%">
                <h1> Match & Date </h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="logout.php"><button class="button-17" role="button">Déconnexion</button></a></li>
                </ul>
            </nav>
        </div>

        <div id="match-container">
            <div id="chat-container">
<!--                <div id="messages">-->
<!--                   <img src="image/femme.jpg" alt="photo" class="photo-chat"> -->
<!--                   <div id="nom-chat">Matteo</div>-->
<!--                   <div id="contenu-chat">Vous avez matché</div>-->
<!--                </div>-->
            </div>
            <div id="photo-and-bouton">
                <div id="biographie"></div>
                <div id="prenom"></div>
                <div id="username"></div>
                <div id="age"></div>
                <div id="bouton">
                    <img src="image/like.png" alt="like" class="like" onclick="likeUser()">
                    <img src="image/dislike.png" alt="dislike" class="dislike" onclick="dislikeUser()">
                </div>
            </div>
                <script>
                    window.onload = function() {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("photo-and-bouton").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "api/getNextMatch.php", true);
                        xmlhttp.send();
                    };
                    var xmlhttp4 = new XMLHttpRequest();
                    xmlhttp4.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("chat-container").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp4.open("GET", "api/getChat.php", true);
                    xmlhttp4.send();
                    function dislikeUser() {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("photo-and-bouton").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "api/getNextMatch.php", true);
                        xmlhttp.send();
                    }
                    function likeUser()
                    {
                        var xmlhttp2 = new XMLHttpRequest();
                        xmlhttp2.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // Deuxième requête
                                var xmlhttp3 = new XMLHttpRequest();
                                xmlhttp3.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        if (this.responseText === "true") {
                                            addMatchToMessage(document.getElementById("prenom").innerHTML);
                                        }
                                    }
                                };
                                xmlhttp3.open("POST", "api/checkMatch.php", true);
                                xmlhttp3.setRequestHeader("Content-type", "application/json");
                                xmlhttp3.send(JSON.stringify({ "name": document.getElementById("username").innerHTML }));
                            }
                        };
                        xmlhttp2.open("POST", "api/addMatch.php", true);
                        xmlhttp2.setRequestHeader("Content-type", "application/json");
                        xmlhttp2.send(JSON.stringify({ "name": document.getElementById("username").innerHTML }));
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("photo-and-bouton").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "api/getNextMatch.php", true);
                        xmlhttp.send();
                    }
                    function addMatchToMessage(prenom, username)
                    {
                        // créer un nouveau div pour le message
                        const newMessageDiv = document.createElement("div");
                        newMessageDiv.className = "messages";
                        newMessageDiv.setAttribute("onclick", "goForChat(this)");
                        // ajouter l'image de profil
                        const img = document.createElement("img");
                        img.src = "image/femme.jpg";
                        img.alt = "photo";
                        img.classList.add("photo-chat");
                        newMessageDiv.appendChild(img);

                        // ajouter le nom de la personne likée
                        const nomDiv = document.createElement("div");
                        nomDiv.textContent = prenom + " (" + document.getElementById("username").innerHTML + ")";
                        nomDiv.id = "nom-chat";
                        newMessageDiv.appendChild(nomDiv);

                        // ajouter le message
                        const contenuDiv = document.createElement("div");
                        contenuDiv.textContent = "Vous avez matché";
                        contenuDiv.id = "contenu-chat";
                        newMessageDiv.appendChild(contenuDiv);

                        // ajouter le nouveau message au chat-container
                        const chatContainer = document.getElementById("chat-container");
                        chatContainer.appendChild(newMessageDiv);
                    }
                    function goForChat(element)
                    {
                        // format is prenom (username)
                        var username = element.childNodes[1].innerHTML.split("(")[1].split(")")[0];
                        window.location.href = "chat.php?id=" + encodeURIComponent(username);
                    }
                </script>
        </div>
    </body>

</html>