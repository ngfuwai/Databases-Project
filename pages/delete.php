<?php 
include("callApi.php");

echo $id = $_GET['id'];
echo $query = callApi("api/playlists/".$id."/songs", "POST", array("song_id"->$id));



// header("Location: playlist.php");
 ?>