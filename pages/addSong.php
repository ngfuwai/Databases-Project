<?php 
include("callApi.php");

$Songid = $_GET['song_id'];
$Playlistid = $_GET['playlist_id'];

$query = callApi("api/playlists/" . $Playlistid, "POST", array("song_id" => $Songid, "playlist_id" => $Playlistid));


header("Location: songs_playlist.php?playlist_id=" . $Playlistid);
exit();
 ?>
