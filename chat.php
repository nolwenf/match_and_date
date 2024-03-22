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
    <link rel="stylesheet" type="text/css" href="style/chat.css"/>
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
        <div id="pv-container">
            <div id="message-content">

            </div>
            <form>
                <input type="text" id="chat-input">
                <input type="submit" id="submit-btn">
            </form>
        </div>
    </div>

    <script>
        var socket = new WebSocket("ws://localhost:8080");
        window.onload = function() {
            var xmlhttp4 = new XMLHttpRequest();
            xmlhttp4.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("chat-container").innerHTML = this.responseText;
                    setMessageBoxGrey();
                }
            };
            xmlhttp4.open("GET", "api/getChat.php", true);
            xmlhttp4.send();
            socket.onopen = function() {
                console.log("Connection opened");
            }
            socket.onmessage = function(event)
            {
                var message = JSON.parse(event.data);
                if (message.to == "<?php echo trim($_SESSION["currentUser"]) ?>")
                {
                    var msg = document.createElement("div");
                    msg.className = "message";
                    msg.innerHTML = "<div class=\"message-by-him\">" + message.message + "</div>";
                    document.getElementById("message-content").appendChild(msg);
                }
            }
        }
        // when page and everything is load execute a function
        document.getElementById("submit-btn").onclick = function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du bouton
            var msg = document.getElementById("chat-input").value;
            if (msg.length < 1)
                return;
            var message = {"message": msg, "from": "<?php echo $_SESSION["currentUser"] ?>", "to": "<?php echo $_GET["id"] ?>"};
            socket.send(JSON.stringify(message));
            document.getElementById("chat-input").value = "";
            // add a message to the chat
            var msg = document.createElement("div");
            msg.className = "message-by-me";
            msg.innerHTML = message.message;
            document.getElementById("message-content").appendChild(msg);
        };
        function goForChat(element)
        {
            // format is prenom (username)
            var username = element.childNodes[1].innerHTML.split("(")[1].split(")")[0];
            window.history.pushState("", "", "chat.php?id=" + username);
            var messages = document.getElementsByClassName("messages");
            for (var i = 0; i < messages.length; i++)
            {
                messages[i].style.backgroundColor = "white";
            }
            element.style.backgroundColor = "#ebebeb";
        }
        function setMessageBoxGrey()
        {
            var messages = document.getElementsByClassName("messages");
            for (var i = 0; i < messages.length; i++)
            {
                if (messages[i].childNodes[1].innerHTML.split("(")[1].split(")")[0] == "<?php echo $_GET["id"] ?>")
                    messages[i].style.backgroundColor ="#ebebeb";
            }
        }
    </script>
</body>
