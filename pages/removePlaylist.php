<?php
include("callApi.php");

$playlistId = $_GET['playlist_id'];

$query = callApi("api/playlists/" . $playlistId . "/delete", "GET");

header("Location: playlist.php");
exit();
