<?php 
session_start();
include 'callApi.php';
?>

<?php
$username = $_GET['username'];
$password = $_GET['password'];
$response = callApi("localhost:8000/api/users", "POST", array("username" => $username, "password" => $password);
//create user with credentials $_SESSOIN['username']/password
echo($_SESSION['username']);

?>
