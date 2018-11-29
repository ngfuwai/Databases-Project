<html>
<body>
<?php
include "callApi.php";

$song_name = trim($_POST['playlist_name']);
$response = callApi("api/users/1/playlists" , "POST", array("playlist_name" => $playlist_name));
$list = json_decode($response);
header("Location: playlist.php");

      exit();
?>
</body>

</html>