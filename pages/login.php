<?php session_start(); ?>

<?php 
function invalid($entry){
  echo("Invalid $entry. Please try again <a href='index.php'>Log in</a>");
  exit();
}

function signUp($username, $password){
  echo("User does not exist, would you like to create an account with credentials entered?<br>");
  echo("<a href='signup.php'>Yes!</a><br>");
  echo("<a href='index.php'>No</a>");
}

if(isset($_POST['username']) && isset($_POST['password'])){
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  if(!ctype_alnum($username)){
    invalid("Username"); //Add later sign up and check if in database
  }else if(!ctype_alnum($password)){
    invalid("Password"); //same as previous comment 
  }else{
    //Run validations for a correct username/password
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    //valid passthrough
    header("Location: header.php");
    exit();
  }
}else{
  invalid("empty");
}
?>
