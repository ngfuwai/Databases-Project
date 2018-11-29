<?php 
session_start();
include 'callApi.php';
?>

<?php
$username = $_GET['username'];
$password = $_GET['password'];
$response = callApi("api/users", "POST", array("username" => $username, "password" => $password));

echo $response;
$data = json_decode($response);

if (!$data) {
  echo "Signup Failed Please retry signup: <a href='index.php'>Log in</a>";
} else {
  $_SESSION['user_id'] = $data->user_id;
  $_SESSION['username'] = $data->username;
  $_SESSION['password'] = $data->password;

  header("Location: header.php");
  exit();
}

?>
