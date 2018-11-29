<?php 

include("callApi.php");

if(isset($_POST['create'])){
	$playlist_id = $_POST['playlist_id'];
	$playlist_name = $_POST['playlist_name'];
	$user_id = $_POST['user_id'];

	}

	$user_id = 1;
	$no = callApi("api/playlists/".$user_id."/songs", "GET");
	// $list = json_decode($result);
	$list2 = json_decode($no);
	
	// $list->song_id;
	$f = $list2->songs;
	$number = count($f);
	// $f[1]->song_name;



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
        <li><a href="playlist.php">Playlists</a></li>
        
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


<div style="border: black solid 2px; padding: 40px;">
<div>
	
	<h2 style="text-align: center;
    padding: 30px;">Songs</h2>

</div>


<div style="text-align: center;">

	<?php   echo "<table class='table table-dark'><th scope='col'>".$no->playlist_name."</th>";
 for($i=0; $i<$number;$i++){
 $name   = $f[$i]->song_name;
 $address = $f[$i]->artist_name;
 $content = $f[$i]->album_name;
 echo "<tr><td>".$name."</td><td>".$address."</td><td>".$content."</td></tr>";
 // echo "<th scope='col'>#</th>
 //      <th scope='col'>".$name."</th>
 //      <th scope='col'>".$address."</th>
 //      <th scope='col'>".$content."</th>";
 }
 echo "</table>";

 ?>
	
	<!-- <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Song Name</th>
      <th scope="col">Artist</th>
      <th scope="col">Duration</th>
    </tr>
  </thead>

  <tbody>

  	

    <tr>
      <th scope="row">1</th>
      <td>a</td>
      <td><wbr></td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table> -->
</div>



<h5>Add Songs to Playlist</h5>
<form method="post">
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Song Id</label>
  <div class="col-10">
    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
  </div>
</div>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Playlist Id</label>
  <div class="col-10">
    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
  </div>
</div>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Song Playlist Id</label>
  <div class="col-10">
    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
  </div>
</div>
<input type="submit" name="add" value="Add">
</form>




	<div>

		

	</div>
	
</div>	


</body>
</html>

