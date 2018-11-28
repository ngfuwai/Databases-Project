<?php session_start(); ?>

<?php
  //Get all information needed
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Songs</title>
    <meta charset="UTF-8">
  </head>

  <body>

    <h2>Song List</h2>
    <table style="width:100%">
    <tr>
      <th>Song Name</th>
      <th>Artist</th>
      <th>Album</th>
    </tr>
    <?php
      for($i = 0; $i < $songList.length; $i++){
        $song = $songList[i];
        echo("<tr>");
        echo("<td>" + $song.songName + "</td>");
        echo("<td>" + $song.artist + "</td>");
        echo("<td>" + $song.album + "</td>");
        echo("</tr>");
        
      }
    ?>
    </table>

  </body>
</html>
