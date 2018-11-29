<?php
include 'callApi.php';

$playlist_id = $_GET['playlist_id'];


?>
<html>
  <body>
    <form method="post" action="changeName.php">
      <div class="form-group row">
        <label for="example-text-inpu" class="col-2 col-form-label">New Name</label>
        <div class="col-10">
          <input class="form-control" type="text" value="playlist name" name="playlist_name">
          <?php echo "<input name='playlist_id' type='hidden' value='". $playlist_id."'>" ?>
        </div>
      </div>
      <input type="submit" name="edit" value="edit">
    </form>
  </body>
</html>

