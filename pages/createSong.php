<html>
<body>
<?php
include "callApi.php";

$song_name = trim($_POST['playlist_name']);
$response = callApi("api/playlists" , "POST", array("song_name" => $song_name, ""));
$list = json_decode($response);
header("Location: playlist.php");

      exit();
?>
</body>

</html>