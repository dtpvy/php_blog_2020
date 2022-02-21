<?php 
	session_start(); 
	include 'connect.php';
	if (!isset($_SESSION["username"])) {
		header("Location: index.php");
		exit(); die();
	} 
	if (isset($_POST["title"])) {
	    $username = $_SESSION["username"];
	    $link = "";
		$user_id = $_SESSION["user_id"];
		$title = str_replace("'", "&#39;", $_POST["title"]);
		$summary = str_replace("'", "&#39;", $_POST["summary"]);
		$subcat_id = $_POST["subcat_id"];
		$image = $_POST["image"];
		$imgtmp = substr($image, -strpos(strrev($image), '/'));
		if ($image == "folder/background.png") $link = $image;
		$image = "folder/".$username."/".$imgtmp;
		if ($link == "folder/background.png") copy($link, $image);
		$content = str_replace("'", "&#39;", $_POST["content"]);
		if ($content == "") $_SESSION["err"] = "<script>alert('Nội dung không để trống!!!');</script>";
		else {
			$sql = "INSERT INTO news(title, summary, subcat_id, content, user_id, image) VALUES ('{$title}', '{$summary}', $subcat_id, '{$content}', $user_id, '{$image}')";
			$res = $conn -> query($sql);
			$sql = "SELECT * FROM news ORDER BY id DESC";
			$res = $conn->query($sql);
			$row = $res -> fetch_assoc();
			$news_id = $row["id"];
			header("Location: news.php?news_id=".$news_id);
			exit(); die();
		}
	}

	if (isset($_GET["category"])) {
		$category = $_GET["category"];
		$sql = "SELECT * FROM category WHERE category='$category'";
		$res = $conn->query($sql);
		if ($res -> fetch_assoc()) $_SESSION["err"] = "<script>alert('Thêm thất bại! Danh mục đã tồn tại.');</script>";
		else {
			$sql = "INSERT INTO category(category) VALUES ('$category')";
			$conn -> query($sql);
			$_SESSION["err"] = "<script>alert('Thêm thành công!');</script>";
		}
		header("Location: addnews.php");
		exit(); die();
	}

	if (isset($_GET["subcat"])) {
		$subcat = $_GET["subcat"];
		$cat_id = $_GET["cat_id"];
		$sql = "SELECT * FROM subcategory WHERE subcategory='$subcat' AND category_id=$cat_id";
		$res = $conn->query($sql);
		if ($res -> fetch_assoc()) $_SESSION["err"] = "<script>alert('Thêm thất bại! Chuyên mục đã tồn tại.');</script>";
		else {
			$sql = "INSERT INTO subcategory(subcategory, category_id) VALUES ('$subcat', $cat_id)";
			$conn -> query($sql);
			$_SESSION["err"] = "<script>alert('Thêm thành công!');</script>";
		}
		header("Location: addnews.php");
		exit(); die();
	}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Tạo bài viết</title>
   <link REL="SHORTCUT ICON" HREF="folder/v.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"></script>
   <script src="https://cdn.tiny.cloud/1/uphwoflqqrnt30bdkocaxpc4z5205wjlc8q6aaagaf3yxg2o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
   <script type="text/javascript">
   	    tinymce.init({
		    selector: "#content", height: 800,
		    plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
		   ],
		   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
		   image_advtab: true ,
		   
		   external_filemanager_path:"/filemanager/",
		   filemanager_title:"Responsive Filemanager" ,
		   external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
	 	});
   </script>
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

		.borbt {
		    border: none;
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
	   		<div class="bg-white shadow rounded-lg p-4 mb-5 ml-auto mr-auto">
	   			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	         		<div class="text-center">
	            		<img src="folder/background.png" id="showimg" width="100%" class="border border-info rounded"> <br>
	            		<input type="file" id="imgInp" style="display: none;">
	            		<input type="text" name="image" id="image" value="folder/background.png" hidden>
	            		<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#upload"><i class="fas fa-upload"></i> Chọn ảnh</button> 
	         		</div>
	         		Tiêu đề:<input type="text" class="form-control" name="title" placeholder="Tiêu đề (150 kí tự)" maxlength="150" required>
	         		Chuyên mục: 
	         		<select name="subcat_id" class="form-control">
<?php  
	$sqlsub = "SELECT subcategory.id, subcategory, category FROM subcategory, category WHERE category_id = category.id";
	$ressub = $conn -> query($sqlsub);
	while ($rowsub = $ressub -> fetch_assoc()) {
		echo "<option value='".$rowsub['id']."'>".$rowsub['subcategory']." (".$rowsub['category'].")</option>"; 
	}
?>
	         		</select>  
	         		Tóm tắt:<textarea class="form-control" name="summary" rows="3" maxlength="500" required></textarea>
	         		Nội dung:
	         		<textarea class="form-control" id="content" name="content" rows="4"></textarea>
	         		<input type="submit" value="Đăng bài" class="btn btn-info btn-block btn-lg">
	        		</form>
		      </div>
	   	</div>
	   	<div class="col">
				<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h2 class="w-100">THÊM DANH MỤC</h2>
		      	<form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-100">
	        			Danh mục:
	        			<input type="text" class="form-control" name="category" placeholder="Danh mục" maxlength="20" required>
	        			<input type="submit" class="btn btn-info btn-block mt-2" value="Thêm">
        			</form>
		      </div>
	   		<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h2 class="w-100">THÊM CHUYÊN MỤC</h2>
		      	<form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-100">
	        			Danh mục: 
	         		<select name="cat_id" class="form-control">
<?php  
	$sqlcat = "SELECT * FROM category";
	$rescat = $conn -> query($sqlcat);
	while ($rowcat = $rescat -> fetch_assoc()) {
		echo "<option value='".$rowcat['id']."'>".$rowcat['category']."</option>"; 
	}
?>
	         		</select>
	         		Chuyên mục:
	        			<input type="text" class="form-control" name="subcat" placeholder="Chuyên mục" maxlength="20" required>
	        			<input type="submit" class="btn btn-info btn-block mt-2" value="Thêm">
        			</form>
        		</div>
        		<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h2>THAM KHẢO</h2>
		      	<ul class="list-group w-100">
<?php  
	$sqlse = "SELECT * FROM news ORDER BY RAND ( ) LIMIT 5";
	$resse = $conn -> query($sqlse);
	$cnt = 0;
	while ($rowse = $resse -> fetch_assoc()) { 
		$sqlsub = "SELECT * FROM subcategory WHERE id=".$rowse["subcat_id"];
		$ressub = $conn -> query($sqlsub);	
		$rowsub = $ressub -> fetch_assoc(); 
?>
						<li class="list-group-item list-group-item-action">
							<a target="_blank" href="news.php?news_id=<?php echo $rowse['id']; ?>" class="card-link text-dark">
						  		<h5 class="mb-0"><?php echo $rowsub['subcategory'].": ".$rowse['title']; ?></h5>
						  		<div class="text-muted d-flex">
						  			<h6 class="mb-0"><?php echo $rowse['time']; ?></h6>
						  		</div>
					  		</a>
					  	</li>
<?php } ?>
					</ul>
		      </div>
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

  	<script>
	   function responsive_filemanager_callback(field_id){
	   	$("#showimg").attr('src', document.getElementById("image").value);
			console.log(document.getElementById("image").value);
		}
 	</script>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>