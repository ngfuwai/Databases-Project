<?php 
session_start();
include 'callApi.php';

?>

<?php 
function invalid($entry){
  echo("Invalid $entry. Please try again <a href='index.php'>Log in</a>");
  exit();
}

function signUp($username, $password){
  echo("User does not exist, would you like to create an account with credentials entered?<br>");
  echo("<a href='signup.php?username=" . $username . "&password=" . $password . "'>Yes!</a><br>");
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
    $response = callApi("api/users/signin", "POST", array("username" => $username, "password" => $password));
    $data = json_decode($response);

    if ($data->user_id == '') {
      signUp($username, $password);
    } else {
      $_SESSION['user_id'] = $data->user_id;
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;

      header("Location: header.php");
      exit();
    }
  }
}else{
  invalid("empty");
}

?>
