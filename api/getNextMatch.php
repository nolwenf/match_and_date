<?php
    session_start();
    function getUserByName()
    {
        $users = file("../users.csv");
        foreach ($users as $user)
        {
            if (trim(explode(",", $user)[2]) == trim($_SESSION["currentUser"]))
            {
                return $user;
            }
        }
        return null;
    }
    function getRandomUser()
    {
        $users = file("../users.csv");
        if (count($users) == 1)
        {
            echo '<div id="nomatch">No more matches !!!</div>';
        }
        $randomUser = $users[rand(0, count($users) - 1)];
        while (trim(explode(",",$randomUser)[2]) == trim($_SESSION["currentUser"]) || trim(explode(",", $randomUser)[4]) == trim(explode(",", getUserByName())[4]))
        {
            $randomUser = $users[rand(0, count($users) - 1)];
        }
        return $randomUser;
    }

    function getAgeByUser($user)
    {
        return explode(",", $user)[5];
    }
    function getVilleByUser($user)
    {
        return explode(",", $user)[6];
    }
    function getBiographieByUser($user)
    {
        return explode(",", $user)[7];
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $randomUser = getRandomUser();
        $biographie = getBiographieByUser($randomUser);
        $age = getAgeByUser($randomUser);
        $qualite = getVilleByUser($randomUser);
        if (explode(",", $randomUser)[4] == 'm')
            echo '<img src="image/homme.jpg" alt="photo" class="photo">';
        else
            echo '<img src="image/femme.jpg" alt="photo" class="photo">';
        echo '<div id="prenom">' . explode(",", $randomUser)[0] . '</div>';
        echo '<div id="username">' . explode(",", $randomUser)[2] . '</div>';
        echo '<div id="biographie">' . $biographie . '</div>';
        echo '<div id="age">' . $age . ' ans</div>';
        echo '<div id="ville">' . $qualite . '</div>';
        echo '<div id="bouton">
                    <img src="image/like.png" alt="like" class="like" onclick="likeUser()">
                    <img src="image/dislike.png" alt="dislike" class="dislike" onclick="dislikeUser()">
                </div>';
        $html = ob_get_clean();
        echo $html;
    }

?>