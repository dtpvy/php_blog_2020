<?php 
	session_start(); 
	include 'connect.php';
	if (!isset($_SESSION["username"]) && !isset($_GET["username"])) {
		header("Location: index.php");
		exit(); die();
	} else {
		if (isset($_GET["username"])) $username = $_GET["username"];
		else $username = $_SESSION["username"];
		$sql = "SELECT * FROM users WHERE username='$username'";
		$res = $conn -> query($sql);
		$row = $res -> fetch_assoc();
		$user_id = $row["id"];
		$email = $row["email"];
		$img = $row["image"];
		$intro = $row["intro"];
	}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Trang cá nhân</title>
   <link REL="SHORTCUT ICON" HREF="folder/v.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style type="text/css">
		html, body {
			height: 100%;
			width: 100%;
			margin: 0px;
		}

		.bd-placeholder-img {
		   font-size: 1.125rem;
		   text-anchor: middle;
		   -webkit-user-select: none;
		   -moz-user-select: none;
		   -ms-user-select: none;
		   user-select: none;
		}

		.search {
			width: 50%;
		}

		.search input {
			border: none;
			margin-left: 18px;
			margin-right: 20px;
			padding: 0;
		}

		.bg {
		   position: relative;
		   background: url('bg2.png');
			width: 100%; 
			height: 350px; 
		}

		.page-item {
			list-style: none;
			display: inline;
		}

		@media (min-width: 700px) {
		   .bd-placeholder-img-lg {
		   	font-size: 3.5rem;
		   }

		   nav {
		    	display: flex;
		   }

		   .box {
		   	width: 700px;
		   	padding-left: 50px;
		   	padding-top: 50px;
		   }
		}

		@media (max-width: 700px) {
		   .search {
		    	width: 100%;
		   }
		}
	</style>
</head>
<body class="bg-light">
<?php  
	if (isset($_SESSION["err"])) {
		echo $_SESSION["err"];
		unset($_SESSION["err"]);
	}
?>
	
	<nav class="align-items-center pl-4 pr-4 py-1 shadow bg-white fixed-top text-center">
	   <i style="font-size: 40px;" class="ml-3 fab fa-vimeo-v text-info font-weight-bold"><i class="fab fa-yoast"></i></i>
	   <a style="box-shadow: none; font-size: 18px;" class="btn text-info font-weight-bold" href="index.php">Trang chủ</a>
	   <a style="font-size: 18px;" class="btn text-info font-weight-bold" href="news.php">Bài viết</a>
	   <div class="dropdown">
	    	<button style="font-size: 18px;" type="button" class="btn text-info font-weight-bold dropdown-toggle" data-toggle="dropdown">Danh mục</button>
	    	<div class="dropdown-menu">
<?php  
	$sqlse = "SELECT * FROM category";
	$resse = $conn -> query($sqlse);
	while ($rowse = $resse -> fetch_assoc()) {
		echo '<a class="dropdown-item" href="news.php?cat='.$rowse["id"].'">'.$rowse["category"].'</a>';
	}
?>
	    	</div>
	  	</div>
<?php if (isset($_SESSION["username"])) { ?>
		<div style="order: 1;" class="d-flex align-items-center">
	    	<a style="font-size: 20px;" class="btn btn-info font-weight-bold ml-2 mr-2" href="profile.php">
	    		<i class="fas fa-user"></i> <?php echo $_SESSION["username"]; ?>
	    	</a>
	    	<a style="font-size: 30px;" class="btn text-info font-weight-bold p-0" href="signin.php?signout=1">
	    		<i class="fas fa-sign-out-alt"></i>
	    	</a>
	   </div>  
<?php } else { ?>
	   <div style="order: 1;">
	   	<button onclick="dangki()" style="font-size: 18px;" class="btn btn-link text-info" data-toggle="modal" data-target="#join">Đăng kí</button>
	   	<button onclick="dangnhap()" style="font-size: 18px;" class="btn btn-info" data-toggle="modal" data-target="#join">Đăng nhập</button>
		</div>
<?php } ?>
	   <form action="news.php" method="GET" class="border border-info rounded-pill d-flex align-items-center ml-auto search my-1">
	    	<input style="box-shadow: none;" class="form-control" type="text" name="search" placeholder="Tìm kiếm...">
	    	<input id="submit" style="display: none;" type="submit">
	    	<label for="submit" class="btn text-info m-0" title="Tìm kiếm">
	    		<i style="font-size: 25px;" class="fas fa-search font-weight-bold "></i>
	    	</label>
	   </form>
	</nav>

  	<div class="container-fluid" style="margin-top: 110px;">
   	<div class="row ml-5 mr-5 mt-5">
	   	<div class="col-8 pr-0">
	   		<div class="bg-white shadow rounded-lg p-4 mb-4 ">
	   			<div class="row align-items-center ml-auto mr-auto mb-4">
			      	<img src="<?php echo $img; ?>" alt="avatar" width="200" height="200" class="border border-info rounded-circle">
			      	<div class="col-5 text-info border-right border-info">
			      		<h1 class="mb-0"><b><?php echo $username; ?></b></h1>
			      		<h5><i><?php echo $email; ?></i></h5>
			      		<h6 style="text-align: justify;"><?php echo $intro; ?></h6>
<?php if (isset($_SESSION["username"]) && $username == $_SESSION["username"]) {
	echo '<button class="btn btn-outline-info" data-toggle="modal" data-target="#edit">Chỉnh sửa thông tin <i class="fas fa-user-edit"></i></button>';
}?>			      		
			      	</div>
<?php  
	$sqlpage = "SELECT * FROM news WHERE user_id=$user_id";
	$respage = $conn -> query($sqlpage);
	$rowpage = $respage -> num_rows;
	$sqlpage = "SELECT news.user_id, AVG(rate) AS RATE FROM `comment` JOIN news ON news.id = comment.news_id WHERE news.user_id = $user_id GROUP BY news.user_id";
	$respage = $conn -> query($sqlpage);
	$rowrate = $respage -> fetch_assoc();
	if ($rowrate["RATE"] != NULL) $rate = number_format($rowrate["RATE"], 1);
	else $rate = "Chưa";

?>
			      	<div class="col text-info">
			      		<h3 class="mb-0"><?php echo $rowpage." bài viết"; ?></h3>
			      		<h3 class="mb-0"><?php echo $rate; ?> đánh giá</h3>
			      	</div>
		      	</div>
		      	<h2 class="text-center font-weight-bold w-100">DANH SÁCH BÀI VIẾT</h2>
		      	<div class="card-columns"> 			
<?php  
	$size = 8; $start = 0;
	if (isset($_GET['page'])) $start = ($_GET['page']-1)*$size;
	$sqlse = "SELECT * FROM news WHERE user_id=$user_id ORDER BY id DESC LIMIT $start, $size";
	$resse = $conn -> query($sqlse);
	while ($rowse = $resse -> fetch_assoc()) { 
		$sqlsub = "SELECT * FROM subcategory WHERE id=".$rowse["subcat_id"];
		$ressub = $conn -> query($sqlsub);
		$rowsub = $ressub -> fetch_assoc(); 
		$news_id = $rowse["id"];
	
?>
						<div class="card mb-4" style="border: none;">
					    	<img src="<?php echo $rowse['image']; ?>" width="100%" class="border border-info">
					    	<h4 class="mb-0"><?php echo $rowsub['subcategory'].": ".$rowse['title']; ?></h4>
			          	<div class="text-muted"><?php echo $rowse['time']; ?></div>
			          	<p class="card-text mb-auto" style="text-align: justify;"><?php echo $rowse['summary']; ?></p>
			          	<a href="<?php echo 'news.php?news_id='.$rowse['id'] ?>" class="btn btn-info mb-1">Đọc</a>
<?php  if (isset($_SESSION["username"]) && $_SESSION["user_id"] == $user_id) { ?>
	   		<a href="<?php echo 'editnews.php?editnews='.$news_id; ?>" class="btn btn-info mb-1">Sửa</a>
	   		<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><i class="fas fa-trash-alt"></i></button>
<?php } else if (isset($_SESSION["role"]) && $_SESSION["role"] > 0) {?>
				<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><i class="fas fa-trash-alt"></i></button>
<?php } ?>
					  	</div>
<?php } ?>
		      	</div>
		      </div>
	   	</div>
	   	<div class="col">
<?php if (isset($_SESSION["username"])) echo '<a href="addnews.php" class="btn btn-outline-info w-100 mb-4"><h2 class="mb-0">ĐĂNG BÀI <i class="fas fa-feather-alt"></i></h2></a>'; ?>
	   		<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h1 class="w-100">TRANG</h1>
		      	<ul style="padding: 0px; word-spacing: -5px;">
<?php
	$page = $rowpage/$size; $cnt = 0; $pn = 1;
	if (isset($_GET['page'])) $pn = $_GET['page'];
	$cnt = 0;
	while ($page > 0) {
	    ++$cnt; --$page;
		if (isset($_SERVER['QUERY_STRING'])) $link = $_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."&page=".$cnt;
		else $link = $_SERVER["PHP_SELF"]."&page=".$cnt;
		if ($cnt == $pn) echo '<li class="page-item"><a class="btn btn-lg btn-info rounded-0 active" href="'.$link.'">'.$cnt.'</a></li>'; 
		else echo '<li class="page-item"><a class="btn btn-lg btn-info rounded-0" href="'.$link.'">'.$cnt.'</a></li>';
	}
?>					</ul>
		      </div>
		      <div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h1>TIÊU BIỂU</h1>
		      	<ul class="list-group w-100">
<?php  
	$sqlse = "SELECT * FROM news WHERE user_id=$user_id ORDER BY view DESC LIMIT 5";
	$resse = $conn -> query($sqlse);
	while ($rowse = $resse -> fetch_assoc()) { 
		$sqlsub = "SELECT * FROM subcategory WHERE id=".$rowse["subcat_id"];
		$ressub = $conn -> query($sqlsub);
		$rowsub = $ressub -> fetch_assoc(); 
?>
						<li class="list-group-item list-group-item-action">
							<a href="<?php echo 'news.php?news_id='.$rowse['id']; ?>" class="card-link text-dark">
						  		<h5 class="mb-0"><?php echo $rowsub['subcategory'].": ".$rowse['title']; ?></h5>
						  		<div class="text-muted d-flex">
						  			<h6 class="mb-0"><?php echo $rowse['time']; ?></h6>
						  			<h6 class="badge badge-primary badge-pill ml-auto mb-0"><?php echo $rowse['view']; ?></h6>
						  		</div>
					  		</a>
					  	</li>
<?php } ?>
					</ul>
		      </div>
	   	</div>
   	</div>
 	</div>

 	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     	<div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div style="font-weight: bold; font-size: 20px;" class="modal-header text-info">
               <h3 class="mb-0 font-weight-bold">CHỈNH SỬA THÔNG TIN</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		        	</button>
            </div>
           	<form action="changeinfo.php" method="POST">
            	<div class="modal-body">
            		<div class="text-center">
               		<img src="<?php echo $img; ?>" id="showimg" alt="yourimage" width="150" height="150" class="border border-info rounded-circle"> <br>
               		<input type="file" id="imgInp" style="display: none;">
	            		<input type="text" name="image" id="image" value="<?php echo $img; ?>" hidden>
	            		<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#upload"><i class="fas fa-upload"></i> Chọn ảnh</button> 
            		</div>
                	<h1 class="text-info text-center font-weight-bold"><?php echo $username; ?></h1>
                	Email:<input type="email" class="form-control" name="email" value="<?php echo $email; ?>" maxlength="30" required autofocus>
                	Giới thiệu:<input type="text" class="form-control" name="intro" maxlength="50" value="<?php echo $intro; ?>">
                	Mật khẩu mới:<input type="password" id="password" class="form-control" maxlength="30" name="newpass" placeholder="Mật khẩu mới">
                	Nhập lại mật khẩu mới:<input type="password" id="repassword" class="form-control" placeholder="Nhập lại mật khẩu">
               	Xác nhận mật khẩu:<input type="password" class="form-control" name="password" placeholder="Mật khẩu hiện tại" required>
            	</div>
            	<div class="modal-footer">
            		<h5 style="color: red;" id="err"></h5>
            		<input type="submit" id="myBtn" value="Cập nhật" class="btn btn-info">
            		<label id="text" class="btn text-light btn-danger rounded font-weight-bold active" hidden>Nhập mật khẩu chưa khớp</label>
            	</div>
           	</form>
         </div>
     	</div>
 	</div>
 	
   <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      	<div class="embed-responsive embed-responsive-16by9">
				  <iframe class="embed-responsive-item" src="/filemanager/dialog.php?type=1&field_id=image" allowfullscreen></iframe>
				</div>
	    	</div>
	  	</div>
	</div>

		<div class="modal fade" id="join" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     	<div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header p-0">
               <button id="btndn" onclick="dangnhap()" style="box-shadow: none; font-weight: bold; font-size: 20px;" class="btn btn-block m-0 py-3 text-info">ĐĂNG NHẬP</button>
               <button id="btndk" onclick="dangki()" style="box-shadow: none; font-weight: bold; font-size: 20px;" class="btn btn-block m-0 py-3 text-info">ĐĂNG KÍ</button>
             </div>
           	<form id="dk" style="display: none;" action="signup.php" method="POST">
            	<div class="modal-body">
            		<div class="text-center">
               		<img src="folder/user.png" id="showimg1" alt="yourimage" width="150" height="150" class="border border-info rounded-circle"> <br>
               		<input type="file" id="imgInp" style="display: none;">
	            		<input type="text" name="image" id="image1" value="folder/user.png" hidden>
	            		<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#upload1"><i class="fas fa-upload"></i> Chọn ảnh</button>
            		</div>
                	Tên đăng nhập:<input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" maxlength="30" required>
                	Email:<input type="email" class="form-control" name="email" placeholder="Email" maxlength="30" required autofocus>
                	Giới thiệu:<input type="text" class="form-control" name="intro" placeholder="Viết một cái gì đó về bản thân" maxlength="50">
               	Mật khẩu:<input type="password" id="password" class="form-control" name="password" maxlength="30" placeholder="Mật khẩu" required>
                	Nhập lại mật khẩu:<input type="password" id="repassword" class="form-control" placeholder="Nhập lại mật khẩu" required>
            	</div>
            	<div class="modal-footer">
            		<h5 style="color: red;" id="err"></h5>
            		<input type="submit" id="myBtn1" value="Đăng kí" class="btn btn-info">
            		<label id="text1" class="btn text-light btn-danger rounded font-weight-bold active" hidden>Nhập mật khẩu chưa khớp</label>
            	</div>
           	</form>
           	<form id="dn" action="signin.php" method="POST">
            	<div class="modal-body">
                	Tên đăng nhập:<input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required autofocus>
                	Mật khẩu:<input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
            	</div>
            	<div class="modal-footer"><input type="submit" value="Đăng nhập" class="btn btn-info"></div>
           	</form>
         </div>
     	</div>
 	</div>

 	<div class="modal fade" id="upload1" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      	<div class="embed-responsive embed-responsive-16by9">
				  <iframe class="embed-responsive-item" src="/filemanager/dialog.php?type=1&field_id=image1" allowfullscreen></iframe>
				</div>
	    	</div>
	  	</div>
	</div>

 	<script>
 		function dangnhap() {
			document.getElementById("dk").style.display = "none";
			document.getElementById("dn").style.display = "block";
			document.getElementById("btndk").classList.remove("active");
			document.getElementById("btndk").classList.remove("btn-outline-info");
			document.getElementById("btndk").classList.add("text-info");
			document.getElementById("btndn").classList.remove("text-info");
			document.getElementById("btndn").classList.add("active");
			document.getElementById("btndn").classList.add("btn-outline-info");
		}

		function dangki() {
			document.getElementById("dn").style.display = "none";
			document.getElementById("dk").style.display = "block";
			document.getElementById("btndn").classList.remove("active");
			document.getElementById("btndn").classList.remove("btn-outline-info");
			document.getElementById("btndn").classList.add("text-info");
			document.getElementById("btndk").classList.remove("text-info");
			document.getElementById("btndk").classList.add("active");
			document.getElementById("btndk").classList.add("btn-outline-info");
		}

		var pass; var repass = "";
	   document.getElementById("password1").onkeyup  = function(){
	      pass = document.getElementById("password1").value;
	      if (repass != "" && repass != pass) {
	         document.getElementById("text1").hidden = false;
	         document.getElementById("myBtn1").hidden = true;
	      } else {
	         document.getElementById("text1").hidden = true;
	         document.getElementById("myBtn1").hidden = false;
	      }
	   };
	   document.getElementById("repassword1").onkeyup  = function(){
	      repass = document.getElementById("repassword1").value;
	      if (repass != "" && repass != pass) {
	         document.getElementById("text1").hidden = false;
	         document.getElementById("myBtn1").hidden = true;
	      } else {
	         document.getElementById("text1").hidden = true;
	         document.getElementById("myBtn1").hidden = false;
	      }
	   };
 	</script>

 	<script>
 		function responsive_filemanager_callback(field_id){
	   	$("#showimg").attr('src', document.getElementById("image").value);
			console.log(document.getElementById("image").value);
		 $("#showimg1").attr('src', document.getElementById("image1").value);
			console.log(document.getElementById("image1").value);
		}

		var pass; var repass;
	   document.getElementById("password").onkeyup  = function(){
	      pass = document.getElementById("password").value;
	      if (repass != "" && repass != pass) {
	         document.getElementById("text").hidden = false;
	         document.getElementById("myBtn").hidden = true;
	      } else {
	         document.getElementById("text").hidden = true;
	         document.getElementById("myBtn").hidden = false;
	      }
	   };
	   document.getElementById("repassword").onkeyup  = function(){
	      repass = document.getElementById("repassword").value;
	      if (repass != "" && repass != pass) {
	         document.getElementById("text").hidden = false;
	         document.getElementById("myBtn").hidden = true;
	      } else {
	         document.getElementById("text").hidden = true;
	         document.getElementById("myBtn").hidden = false;
	      }
	   };

 		function deletenews(x) {
		 	var check = confirm("Xác nhận xóa bài viết?");
        	if (check)  {
            window.location="editnews.php?deletenews="+x;
    	 	} 
  		}
 	</script>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>