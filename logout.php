<!-- เสร็จสมบรูณ์แล้ว -->
<?php
session_start();
require_once 'dbconnect.php';

if(isset($_SESSION['user'])){
	$name = $_SESSION['user'];

	$sql = "INSERT INTO log_file (name, status)
			VALUES ('$name', '2')";
	mysqli_query($conn, $sql);

	session_destroy();
 	header("location: home.php");
}

if(isset($_SESSION['user_tm'])){

	$name1 = $_SESSION['user_tm'];

	$sql1 = "INSERT INTO log_file (name, status)
			VALUES ('$name1', '2')";
	mysqli_query($conn, $sql1);

	session_destroy();
 	header("location: home.php");
}

if(isset($_SESSION['user_m'])){
	
	$name2 = $_SESSION['user_m'];

	$sql2 = "INSERT INTO log_file (name, status)
			VALUES ('$name2', '2')";
	mysqli_query($conn, $sql2);

	session_destroy();
 	header("location: home.php");
}
?>