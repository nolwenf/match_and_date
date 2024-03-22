<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $userId = $_SESSION["currentUser"];
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];
        $likedUsers = json_decode(file_get_contents("../like.json"), true);
        if (!isset($likedUsers[$userId]))
        {
            $likedUsers[$userId] = array();
        }
        if (in_array($name, $likedUsers[$userId]))
        {
            return;
        }
        // we receive {name:"username"} in POST
        $likedUsers[$userId][] = $name;
        file_put_contents("../like.json", json_encode($likedUsers));
    }

?>

