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
        <li class="active"><a href="header.php">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="playlist.php">Playlist</a></li>
        
      </ul>
      <form method="post" action="header.php" class="navbar-form navbar-left" role="search">
		  <div class="form-group">
		    <input type="text" name="search" class="form-control" placeholder="Search"/>
		  </div>
		  <input type="radio" name="artist">Artist</input>
		 
		  <input type="radio" name="song">Song</input>
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
      $search = str_replace(' ', '%20', $search);
			$query = callApi("api/search/artists/" . $search , "GET");
			
			$number = count(json_decode($query));
			for($i=0; $i< $number; $i++){
				$de = json_decode($query);
			
				$name = $de[0]->artist_name;
				echo "<h4 style=''>" . $name . "</h4>";
				$artist_id = $de[0]->artist_id;
				$query2 = callApi("api/artists/" . $artist_id . "/songs", "GET");
				$number2 = count(json_decode($query2));
				for($i=0; $i< $number2; $i++){
					$de2 = json_decode($query2);
					$name = $de2[$i]->song_name;
					$song_duration = $de2[$i]->duration;
					$album_name = $de2[$i]->album_name;
				

					echo "<h5>Song Name: " . $name . "</h5><br>";
					echo "<p>Song Duration: " . $song_duration . "</p><br><br>";
					echo "<p>Album: " . $album_name . "</p><br>";
				
				}
			}
		// 	$only_id = $de[0]->artist_id;
		// 	echo $name . "<br>" . $only_id . "<a href='artists.php?id=" .$only_id.  "'>" . $name .  "</a>";
		// 	// $query2 = callApi("api/artists/". $only_id . "/songs", "GET");
		// 	// $de2 = json_decode($query2);
		// 	// echo $de2[$i]->song_name;
		// }
			// echo $artist_id = $query->artists_id;
			// echo $song_query = callApi("api/artists/" . $artists_id . "/songs" , "GET");


		
			// $query = mysqli_query($con, "SELECT * FROM Artist where artist_name='$search'");
			// $row = mysqli_fetch_array($query);
			// $number = count($row);
			// while($row = mysqli_fetch_array($query)) {
			// 	$artist_id = $row['artist_id'];
			// 	echo "<h5 style=''>" . $row['artist_name'] . "</h5>";

			// 	$query2 = mysqli_query($con, "SELECT * from Song where album_id=(select album_id from Album where artist_id='$artist_id');");
			// 	while ($row2 = mysqli_fetch_array($query2)) {
			// 		echo "<p>" . $row2['song_name'] . "</p><br>";
			// 	}
			// }
			
		}
		if(isset($_POST['song'])){
			$query = callApi("api/search/songs/" . $search , "GET");

			$number = count(json_decode($query));

			for($i=0; $i< $number; $i++){
				$de = json_decode($query);
			
				$song_name = $de[$i]->song_name;
				$song_id = $de[$i]->song_id;
				$duration = $de[$i]->duration;
				$genre_name = $de[$i]->genre_name;
				$album_name = $de[$i]->album_name;
				$artist_name = $de[$i]->artist_name;

				echo "<h5>Song Name: " . $song_name . "</h5><br>Song Id: " .$song_id. "<br>Duration: " . $duration . "<br>Genre: " . $genre_name . "<br>Album Name: "  . $album_name . "<br>Artist Name: ". $artist_name . "<br><br>";
			}
			// while ($row = mysqli_fetch_array($query)) {
   //  			$name = $row['song_name'];
   //  			$song_id = $row['song_id'];
   //  			$song_date = $row['date'];
   //  			$song_duration = $row['duration'];
   //  			$song_album_id = $row['album_id'];
   //  			echo "<div>" . "Song Id: " .  $song_id . " Date Uploaded: " .  $song_date . " Song Duration: " .  $song_duration .  " Album Id: " .  $song_album_id . " Song name: " .  $name ." </div>";
			// }


			// $json = json_decode($query);

			// foreach ($json['items'] as $address)
			// 	{
			// 	    echo "items:". $address['address'] ."\n";
			// 	};

			}
			
		
// 		if(isset($_POST['playlist'])){
// 			$query = callApi("api/search/playlists/" . $search , "GET");

// 			$number = count(json_decode($query));

// 			for($i=0; $i< $number; $i++){
// 				$de = json_decode($query);

// 				$playlist_id = $de[$i]->playlist_id;
				
// 				echo $no = callApi("api/playlists/".$playlist_id."/songs", "GET");
// 				$list2 = json_decode($no);


// 				$f = $list2->songs;
// 				echo $number2 = count($f);
// 				for($i=0; $i<$number2;$i++){
// 					$id = $f[$i]->song_id;
// 					$name   = $f[$i]->song_name;
// 					$address = $f[$i]->artist_name;
// 					$content = $f[$i]->album_name;
// 					echo "<table class='table table-dark'><th scope='col'>"."</th>";
// 				    echo "<tr><td>".$name."</td><td>".$address."</td><td>".$content."</td><td><button><a href='delete.php?id=". $id . "'>Delete From Playlist</a></button></td></tr>"  ;
// 					echo "</table>";

//  }

// 			}
			
			

			
// 			// while ($row = mysqli_fetch_array($query)) {
//    //  			$name = $row['playlist_name'];
//    //  			echo "<h5 style=''>" . $name . "</h5>";
//    //  			$playlist_id = $row['playlist_id'];
//    //  			$query2 = mysqli_query($con, "SELECT * FROM Song_Playlist where playlist_id='$playlist_id'");
//    //  			while ($row2 = mysqli_fetch_array($query2)) {
//    //  				$song_id =  $row2['song_id'];
//    //  				$query3 = mysqli_query($con, "SELECT * FROM Song where song_id='$song_id'");
//    //  				while ($row3 = mysqli_fetch_array($query3)) {
//    //  					echo "<p>" . $row3['song_name'] . "</p><br>";
//    //  				}
//    //  			}
// 			// // foreach($row as $key => $var)
// 			// // {
// 			// //     echo $var . '<br />';
// 			// // }
// 			// }


// 			// $playlist_row = json_decode($query);
// 			// $playlist_row_name = $playlist_row[0]->playlist_name;
			
// 			// $playlist_row_id = $playlist_row[0]->playlist_id;
// 			// echo $playlist_row_name . "<br>" . $playlist_row_id . "<a href='playlist.php?id=" .$playlist_row_id.  "'>" . $playlist_row_name .  "</a>";
			
// }
		
	} 
	?>

</div>

</body>
</html>
