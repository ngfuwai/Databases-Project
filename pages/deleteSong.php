<?php 
include("callApi.php");

$Songid = $_GET['song_id'];
$Playlistid = $_GET['playlist_id'];

$query = callApi("api/playlists/" . $Playlistid . "/songs", "POST", array("song_id" => $Songid));


header("Location: songs_playlist.php?playlist_id=" . $Playlistid);
exit();
 ?>
