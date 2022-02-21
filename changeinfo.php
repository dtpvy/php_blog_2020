<?php  
	session_start();
	include 'connect.php';
	if (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
		$email = $_POST["email"];
		$intro = $_POST["intro"];
		$image = $_POST["image"];
		$imgtmp = substr($image, -strpos(strrev($image), '/'));
		$image = "folder/".$username."/".$imgtmp;
		$password = substr(md5($_POST["password"]), 0, 30);
		$newpass = $_POST["newpass"];
		$sqlch = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$resch = $conn -> query($sqlch);
		if ($resch -> fetch_assoc()) {
			if ($newpass == "") $newpass = $password;
			else $newpass = substr(md5($newpass), 0, 30);
			$sql = "UPDATE users SET email='$email', intro='$intro', image='$image', password='$newpass' WHERE username='$username'";
			$conn -> query($sql);
			$conn -> close(); 
			$_SESSION["err"] = "<script>alert('Cập nhật thành công!');</script>"; 
		} else $_SESSION["err"] = "<script>alert('Mật khẩu xác nhận chưa chính xác!!!');</script>";
		header('Location: profile.php');
		exit(); die();
	} else {
		header('Location: index.php');
		exit(); die();
	}
?>