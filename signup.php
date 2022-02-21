<?php  
	session_start();
	include 'connect.php';
	if (isset($_POST["username"])) {
		$username = $_POST["username"];
		$email = $_POST["email"];
		$intro = $_POST["intro"];
		$image = $_POST["image"];
		$password = substr(md5($_POST["password"]), 0, 30);
		$sql = "SELECT * FROM users WHERE username='$username'";
		$res = $conn->query($sql);
		if ($res -> fetch_assoc()) $_SESSION["err"] = "<script>alert('Tên đăng nhập đã tồn tại');</script>";
		else {
		    $imgtmp = substr($image, -strpos(strrev($image), '/'));
			if ($image == "folder/user.png") $link = $image;
			else $link = "folder/img/".$imgtmp;
			$image = "folder/".$username."/".$imgtmp;
			mkdir('folder/'.$username);
			copy($link, $image);
			$sql = "INSERT INTO users (username, password, email, intro, image) VALUES ('$username', '$password', '$email', '$intro', '$image')";
			$res = $conn->query($sql);
			$sql = "SELECT * FROM users WHERE username='$username'";
			$res = $conn->query($sql);
			$row = $res->fetch_assoc();
			$_SESSION["user_id"] = $row["id"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["role"] = $row["role"];
			$_SESSION["err"] = "<script>alert('Đăng kí thành công! Xin chào $username');</script>"; 
		} 
		header("Location: ".$_SERVER["HTTP_REFERER"]);
		exit(); die();
	}
?>