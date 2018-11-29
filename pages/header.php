<?php 

include("callApi.php");

?>

 

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>


	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Music Share</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="playlist.php">Playlist</a></li>
        
      </ul>
      <form method="post" action="header.php" class="navbar-form navbar-left" role="search">
		  <div class="form-group">
		    <input type="text" name="search" class="form-control" placeholder="Search">
		  </div>
		  <input type="radio" name="artist">Artist 
		  <input type="radio" name="playlist">Playlist
		  <input type="radio" name="song">Song
		  <button type="submit" name="submit" class="btn btn-default">Submit</button>
		</form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	

<div>
	
	<?php 

	if(isset($_POST['submit'])){
		$search = $_POST['search'];




		if(isset($_POST['artist'])){

			$query = callApi("api/search/artists/" . $search , "GET");
			$number = count(json_decode($query));
			for($i=0; $i< $number; $i++){

			$de = json_decode($query);
			$name = $de[0]->artist_name;
			echo $name . "<br>"
			$only_id = $de[0]->artist_id;
			$query2 = callApi("api/artists/". $only_id . "/songs", "GET");
			$de2 = json_decode($query2);
			echo $de2[$i]->song_name;
		}
			// echo $artist_id = $query->artists_id;
			// echo $song_query = callApi("api/artists/" . $artists_id . "/songs" , "GET");
			// $query = mysqli_query($con, "SELECT * FROM Artist where artist_name='$search'");
			// $row = mysqli_fetch_array($query);
			// while($row) {
			// 	echo $row['artist_name'];
			// }
		}
		if(isset($_POST['song'])){
			echo $query = callApi("api/search/songs/" . $search , "GET");
			// $query = mysqli_query($con, "SELECT * FROM Song where song_name='$search'");
			// while ($row = mysqli_fetch_array($query)) {

   //  			$name = $row['song_name'];
   //  			$song_id = $row['song_id'];
   //  			$song_date = $row['date'];
   //  			$song_duration = $row['duration'];
   //  			$song_album_id = $row['album_id'];

   //  			echo "<div>" . "Song Id: " .  $song_id . " Date Uploaded: " .  $song_date . " Song Duration: " .  $song_duration .  " Album Id: " .  $song_album_id . " Song name: " .  $name ." </div>";

			// foreach($row as $key => $var)
			// {
			//     echo $var . '<br />';
			// }


			}
			
		
		if(isset($_POST['playlist'])){
			echo $query = callApi("api/search/playlists/" . $search , "GET");
			// $query = mysqli_query($con, "SELECT * FROM Playlist where playlist_name='$search'");
			
			
   //  		while ($row = mysqli_fetch_array($query)) {

   //  			$name = $row['playlist_name'];

   //  			echo "<div>" . $name ." </div>";

			// // foreach($row as $key => $var)
			// // {
			// //     echo $var . '<br />';
			// // }


			// }
}
		
	} 
	?>

</div>

</body>
</html>
