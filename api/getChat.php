<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        session_start();
        $match = json_decode(file_get_contents("../match.json"), true);
        if (isset($match[$_SESSION["currentUser"]]))
        {
            foreach ($match[$_SESSION["currentUser"]] as $key => $value)
            {
                // search in users.csv the username in [2] position
                $users = file("../users.csv");
                foreach ($users as $user)
                {
                    if (trim(explode(",", $user)[2]) == trim($value))
                    {
                        $value = $user;
                        break;
                    }
                }
                $sexe = explode(",", $value)[4];
                echo "<div class=\"messages\" onclick='goForChat(this)'>";
                if ($sexe == "f")
                    echo '<img src="image/femme.jpg" alt="photo" class="photo-chat">';
                else
                    echo '<img src="image/homme.jpg" alt="photo" class="photo-chat">';
                echo '<div id="nom-chat">' . explode(",", $value)[0] . ' (' . explode(",", $value)[2] . ')</div>';
                echo '<div id="contenu-chat"> Vous avez matché ! </div>';
                echo "</div>";
            }
        }
    }