<?php  
	session_start();
	include 'connect.php';
	if (isset($_GET["signout"])) {
		session_destroy();
		header("Location: index.php");
		exit(); die();
	}
	if (isset($_POST["username"])) {
		$username = $_POST["username"];
		$password = substr(md5($_POST["password"]), 0, 30);
		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$res = $conn -> query($sql);
		if ($row = $res -> fetch_assoc()) {
			$_SESSION["user_id"] = $row["id"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["role"] = $row["role"];
			$_SESSION["err"] = "<script>alert('Xin chào $username');</script>"; 
		} else $_SESSION["err"] = "<script>alert('Tên đăng nhập hoặc mật khẩu chưa chính xác');</script>";
		header("Location: ".$_SERVER["HTTP_REFERER"]);
		exit(); die();
	}
?>