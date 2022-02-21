<?php  
	$server = "localhost";
	$user = "id13818792_root";
	$pass = "@Dtpvy02022002";
	$db = "id13818792_myweb";
	$conn = new mysqli($server, $user, $pass, $db);
	if ($conn -> connect_error) die("Kết nối không thành công".$conn->connect_error);
	else "Kết nối thành công";
	$conn -> query("set names 'utf8'");
?>