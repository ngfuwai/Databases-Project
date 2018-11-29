<html>
<?php

include "callApi.php";
session_start();
?>

<body>
<?php
 $playlist_name = trim($_POST['playlist_name']);
$response = callApi("api/users/". $_SESSION['user_id'] ."/playlists" , "POST", array("playlist_name" => $playlist_name));
$list = json_decode($response);
header("Location: playlist.php");
exit();

	  
?>

<body>


</html>
