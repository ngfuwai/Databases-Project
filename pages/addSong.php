<?php 
include("callApi.php");

$Songid = $_GET['song_id'];
$Playlistid = $_GET['playlist_id'];
echo $Songid;
echo $Playlistid;

$query = callApi("api/playlists", "POST", array("song_id" => $Songid, "playlist_id" => $Playlistid));


header("Location: songs_playlist.php?playlist_id=" . $Playlistid);
exit();
 ?>
