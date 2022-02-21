<?php  
	session_start();
	include 'connect.php';
	if (isset($_POST["news_id"]) && isset($_SESSION["user_id"])) {
		$rate = $_POST["rate"];
		$comment = str_replace("'", "&#39;", $_POST["comment"]);
		$user_id = $_SESSION["user_id"];
		$news_id = $_POST["news_id"];
		if ($_POST["act"] == "Gửi") $sql = "INSERT INTO comment(content, rate, user_id, news_id) VALUES ('$comment', $rate, $user_id, $news_id)";
		if ($_POST["act"] == "Sửa") $sql = "UPDATE comment SET content='$comment', rate=$rate WHERE user_id=$user_id AND news_id=$news_id";
		if ($_POST["act"] == "Xóa") $sql = "DELETE FROM comment WHERE user_id=$user_id AND news_id=$news_id";
		$conn -> query($sql);
		$conn -> close();
		header("Location: news.php?news_id=".$news_id);
	} else header("Location: index.php");
?>