<?php 

$con = mysqli_connect("localhost", "root", "", "Music");

	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysqli_connect_errno();
	}

if(isset($_SESSION['userLoggedIn'])) {
  $username = $_SESSION['userLoggedIn'];

}



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
    padding: 30px;">Playlists</h2>

</div>


<div style="text-align: center;">
	
	<form method="post">
	<input type="submit" name="myPlaylist" value="My Playlist">
	<input type="submit" name="createPlaylist" value="Create Playlist">	
	</form>

</div>

	<div>

		<?php

			if(isset($_POST['myPlaylist'])){
				
			}

		 ?>

	</div>
	
</div>	


</body>
</html>

