<?php
  include("callApi.php");

  $playlist_id = $_POST['playlist_id'];
  $playlist_name = $_POST['playlist_name'];

  $response = callApi("api/playlists/".$playlist_id,"POST", array("playlist_name" => $playlist_name));
  header("Location: playlist.php");
  exit();
?>
