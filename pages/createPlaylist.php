<html>

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

<h5>Create A Playlist</h5>
<form>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Playlist Id</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="example-text-input">
  </div>
</div>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Playlist Name</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="example-text-input">
  </div>
</div>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">User Id</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="example-text-input">
  </div>
</div>
<input type="submit" name="create" value="Create">
</form>


</html>