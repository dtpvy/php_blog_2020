<?php 
	session_start(); 
	include 'connect.php';
	if (isset($_GET["news_id"])) { 
		$news_id = $_GET["news_id"];
		$news = "news_id".$news_id;
		if (!isset($_COOKIE[$news])) {
			setcookie($news, 1, time() + 3600);
			$sql = "UPDATE news SET view=view+1 WHERE id=".$news_id;
			$res = $conn -> query($sql);
		}
		$sql = "SELECT * FROM news WHERE id=$news_id";
		$res = $conn -> query($sql);
		$row = $res -> fetch_assoc();
		$user_id = $row["user_id"];
	}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title><?php  
		if (isset($_GET["news_id"])) echo $row['title'];
		else echo "Bài viết";
	?></title>
	<link REL="SHORTCUT ICON" HREF="folder/v.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdn.tiny.cloud/1/uphwoflqqrnt30bdkocaxpc4z5205wjlc8q6aaagaf3yxg2o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
		
		@media (min-width: 808px) {
		   .colm {
		       width: 66.67%;
		   }
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

		#bg {
		    -webkit-box-align: center;
		    -ms-flex-align: center;
		    align-items: center;
		    -webkit-box-pack: center;
		    -ms-flex-pack: center;
		    justify-content: center;
		    display: -webkit-box;
		    display: -ms-flexbox;
		    display: flex;
		    height: 100vh;
		    width: 100%;
		    position: relative;
		}

		#rangevalue,  {
		    position: relative;
		    font-weight: bold;
		    margin: 0px;
		    
		    &:after {
		        content: '%';
		    }
		}
		#fillrangevalue {
		    width: 200px;
		    height: 40px;
		    z-index: 1;
		}

		#range {
		    position: relative;
		    background-color: black;
		    background: url("folder/icon.png") repeat-x;";
		    width: 200px;
		    height: 40px;
		    outline: none;
		    -webkit-appearance: none;
		    overflow: hidden;
		}

		#range::-webkit-slider-thumb {
		    visibility: hidden;
		}

		.ellipsis {
		 	overflow: hidden;
		   text-overflow: ellipsis;
		   -webkit-line-clamp: 1;
		   display: -webkit-box;
		   -webkit-box-orient: vertical;
		}

		.block-ellipsis {
		   overflow: hidden;
		   text-overflow: ellipsis;
		   -webkit-line-clamp: 3;
		   display: -webkit-box;
		   -webkit-box-orient: vertical;
		}

		.page-item {
			list-style: none;
			display: inline;
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

<?php if (isset($_GET["news_id"])) { 
	$sqlse = "SELECT * FROM users WHERE id=$user_id";
	$resse = $conn -> query($sqlse);
	$rowse = $resse -> fetch_assoc();
	$sqlsub = "SELECT * FROM subcategory WHERE id=".$row['subcat_id'];
	$ressub = $conn -> query($sqlsub);
	$rowsub = $ressub -> fetch_assoc();
	$sqlrate = "SELECT AVG(rate) AS RATE, COUNT(*) AS CNT FROM comment WHERE news_id=$news_id";
	$resrate = $conn -> query($sqlrate);
	$rowrate = $resrate -> fetch_assoc();
	if ($rowrate["RATE"] != NULL) $rate = number_format($rowrate["RATE"], 1);
	else $rate = "...";
?>
  	<div class="container-fluid" style="margin-top: 110px;">
   	<div class="row ml-5 mr-5 mt-5">
	   	<div class="colm pr-0">
	   		<div class="bg-white shadow rounded-lg p-4 mb-5 ml-auto mr-auto">
	   			<h2 class="text-info font-weight-bold mb-0"><?php echo $rowsub["subcategory"] ?>: <?php echo $row['title']; ?></h2>
	   			<h5 class="text-secondary"><?php echo $row["summary"]; ?></h5>
	   			<div class="d-flex justify-content-between">
	   				<h4 class="text-dark mb-0">
	   					Tác giả: <a href="profile.php?username=<?php echo $rowse['username']; ?>" class="text-info"><?php echo $rowse["username"]; ?></a>
	   				</h4>
	   				<h4 class="text-warning mb-0">
	   					<?php echo $rate; ?>/5<i class="fas fa-star"></i>| <?php echo $rowrate["CNT"]; ?> đáng giá
	   				</h4>
	   			</div>
   				<div class="d-flex justify-content-between">
   					<h5 class="text-muted"><?php echo $row["time"]; ?></h5>
   					<h5 class="text-muted"><?php echo $row["view"]; ?> lượt xem</h5>
   				</div>
	   			<img width="100%" src="<?php echo $row['image']; ?>">
	   			<hr style="border: 1.5px dashed; width: 80%;">
					<p ><?php echo $row['content']; ?></p>
		      </div>
	   	</div>
	   	<div class="col">
	   	    
<?php if (isset($_SESSION["username"]) && $_SESSION["user_id"] == $user_id) { ?>
	   		<a href="<?php echo 'editnews.php?editnews='.$news_id; ?>" class="btn btn-info w-100 mb-1"><h2 class="mb-0"><i class="fas fa-edit"></i> SỬA BÀI VIẾT</h2></a>
	   		<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info w-100 mb-1"><h2 class="mb-0"><i class="fas fa-trash-alt"></i> XÓA BÀI VIẾT</h2></button>
<?php } else if (isset($_SESSION["role"]) && $_SESSION["role"] > 0) {?>
				<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info w-100 mb-1"><h2 class="mb-0"><i class="fas fa-trash-alt"></i> XÓA BÀI VIẾT</h2></button>
<?php }
    if (isset($_SESSION["username"])) echo '<a href="addnews.php" class="btn btn-outline-info w-100 mb-4"><h2 class="mb-0">ĐĂNG BÀI <i class="fas fa-feather-alt"></i></h2></a>';
?>

				<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
<?php 
	if (isset($_SESSION["username"])) {
		$sqlcmt = "SELECT * FROM comment WHERE news_id=$news_id AND user_id=".$_SESSION["user_id"];
		$rescmt = $conn -> query($sqlcmt);
		if ($rowcmt = $rescmt -> fetch_assoc()) { 
?>
		      	<div class="card mb-3 w-100" >
					  	<div class="card-header bg-transparent py-2 pl-2"><h3 class="mb-0">ĐÁNH GIÁ</h3></div>	
				    	<form class="w-100" action="comment.php" method="POST">
				    		<textarea name="comment" class="card-body w-100" style="border: none; outline: none;"><?php echo $rowcmt["content"]; ?></textarea>
				    		<input type="text" name="news_id" value="<?php echo $news_id; ?>" hidden>
				    		<div class="card-footer bg-transparent d-flex p-1">
				    			<div style="width: 200px;" class="ml-auto mr-auto"> 
				        			<div id="fillrangevalue" class="bg-warning">
				        				<input type="range" name="rate" id="range" value="<?php echo $rowcmt['rate']; ?>" min="1" max="5" step="1" style="width: 200px;">
			       				</div>
			   				</div>
			   				<input type="text" name="act" id="act" hidden>
			   				<input type="submit" name="act" class="btn btn-info ml-auto mr-1" value="Sửa">
			   				<input type="submit" name="act" class="btn btn-info mr-auto" value="Xóa">
				    		</div>
		      		</form>	
					</div>
<?php } else { ?>
					<div class="card mb-3 w-100" >
					  	<div class="card-header bg-transparent py-2 pl-2"><h3 class="mb-0">ĐÁNH GIÁ</h3></div>	
				    	<form class="w-100" action="comment.php" method="POST">
				    		<textarea name="comment" class="card-body w-100" style="border: none; outline: none;" placeholder="Hãy viết cảm nhận của bạn"></textarea>
				    		<input type="text" name="news_id" value="<?php echo $news_id; ?>" hidden>
				    		<div class="card-footer bg-transparent d-flex p-1">
				    			<div style="width: 200px;" class="ml-auto mr-auto"> 
				        			<div id="fillrangevalue" class="bg-warning">
				        				<input type="range" name="rate" id="range" value="5" min="1" max="5" step="1" style="width: 200px;">
			       				</div>
			   				</div>
			   				<input type="submit" name="act" class="btn btn-info ml-auto" value="Gửi">
				    		</div>
		      		</form>	
					</div>
<?php }} ?>
					<div class="w-100">
						<h3>BÌNH LUẬN</h3>
<?php  
	$sqlcmt = "SELECT * FROM comment, users WHERE user_id=users.id AND news_id=$news_id";
	$rescmt = $conn -> query($sqlcmt);
	while ($rowcmt = $rescmt -> fetch_assoc()) { 
?>
						<div class="card mb-3" style="border: none;">
						  	<div class="row no-gutters">
					    		<div class="col-3 my-auto">
						      	<img src="<?php echo $rowcmt['image'];?>" width="80px" height="80px" class="border border-info" >
						    	</div>
						    	<div class="col">
							      <div class="card-body pl-2 py-0 pr-0">
							      	<div class="d-flex justify-content-between">
							      		<h4 class="mb-0"><?php echo $rowcmt["username"]; ?></h4>
							      		<div>
<?php 		
	for ($i = 1; $i <= $rowcmt['rate']; ++$i) echo '<img src="folder/icon.png" width="30px" height="30px" class="bg-warning">';
?>											</div>
										</div>
							      	<p class="card-text mt-1" style="text-align: justify;"><?php echo $rowcmt["content"]; ?></p>
							      </div>
						    	</div>
						  	</div>
						</div>
<?php } ?>
					</div>
		      </div>
	   	</div>
   	</div>
 	</div>
<?php } else { ?>
	<div class="container-fluid" style="margin-top: 110px;">
   	<div class="row ml-5 mr-5 mt-5">
	   	<div class="colm mr-4">
<?php  
	$size = 8; $start = 0;
	if (isset($_GET['page'])) $start = ($_GET['page']-1)*$size;
	if (isset($_GET["search"])) {
		$search = $_GET["search"];
		$sqlnew = "SELECT news.id,title, summary, news.time, image, subcategory, user_id FROM news, subcategory WHERE (news.title LIKE '%$search%' OR news.summary LIKE '%$search%') AND (news.subcat_id = subcategory.id) ORDER BY id DESC LIMIT $start, $size";
		$sqlpage = "SELECT news.id,title, summary, news.time, image, subcategory FROM news, subcategory WHERE (news.title LIKE '%$search%' OR news.summary LIKE '%$search%') AND (news.subcat_id = subcategory.id) AND (news.subcat_id = subcategory.id)";
	} else if (isset($_GET["subcat"])) {
		$subcat = $_GET["subcat"];
		$sqlnew = "SELECT news.id, title, summary, news.time, image, subcategory, user_id FROM news, subcategory WHERE news.subcat_id = subcategory.id AND news.subcat_id=$subcat ORDER BY id DESC LIMIT $start, $size";
		$sqlpage = "SELECT news.id,title, summary, news.time, image, subcategory FROM news, subcategory WHERE news.subcat_id = subcategory.id AND news.subcat_id=$subcat";
	} else if (isset($_GET["cat"])) {
		$cat = $_GET["cat"];
		$sqlnew = "SELECT news.id,title, summary, news.time, image, subcategory, user_id FROM news, subcategory WHERE news.subcat_id = subcategory.id AND category_id=$cat ORDER BY id DESC LIMIT $start, $size";
		$sqlpage = "SELECT news.id,title, summary, news.time, image, subcategory FROM news, subcategory WHERE news.subcat_id = subcategory.id AND category_id=$cat";
	} else {
		$sqlnew = "SELECT news.id,title, summary, news.time, image, subcategory, user_id FROM news, subcategory WHERE news.subcat_id = subcategory.id ORDER BY id DESC LIMIT $start, $size";
		$sqlpage = "SELECT news.id,title, summary, news.time, image, subcategory FROM news, subcategory WHERE news.subcat_id = subcategory.id";
	}

	$resnew = $conn -> query($sqlnew);
	$cnt = 0;
	while ($rownew = $resnew -> fetch_assoc()) { 
		$user_id = $rownew['user_id'];
		$news_id = $rownew['id'];
		++$cnt; 
?>
	   		<div class="row">
		   		<div class="col shadow-sm bg-white mb-4 mr-4" style="border-radius: 10px;">
		   			<a href="news.php?news_id=<?php echo $rownew['id']; ?>" class="card-link text-dark">
			   			<img src="<?php echo $rownew['image']; ?>" width="100%" height="200px"> 
					      <h4 class="mt-1 ellipsis" style="padding-bottom: 2px;">
					      	<?php echo $rownew['subcategory'].": ".$rownew['title']; ?>
					      </h4>
					      <h6><?php echo $rownew["time"]; ?></h6>
					      <p class="block-ellipsis" style="text-align: justify;"><?php echo $rownew["summary"]; ?></p>
					   </a>
<?php  if (isset($_SESSION["username"]) && $_SESSION["user_id"] == $user_id) { ?>
	   		<a href="<?php echo 'editnews.php?editnews='.$news_id; ?>" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-pen"></i></h6></a>
	   		<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-trash-alt"></i></h6></button>
<?php } else if (isset($_SESSION["role"]) && $_SESSION["role"] > 0) {?>
				<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-trash-alt"></i></h6></button>
<?php } ?>
			      </div>
<?php if ($rownew = $resnew -> fetch_assoc()) { 
        $user_id = $rownew['user_id'];
        $news_id = $rownew['id'];
?>
			      <div class="col shadow-sm bg-white mb-4 mr-4" style="border-radius: 10px;">
		   			<a href="news.php?news_id=<?php echo $rownew['id']; ?>" class="card-link text-dark">
			   			<img src="<?php echo $rownew['image']; ?>" width="100%" height="200px"> 
					      <h4 class="mt-1 ellipsis" style="padding-bottom: 2px;">
					      	<?php echo $rownew['subcategory'].": ".$rownew['title']; ?>
					      </h4>
					      <h6><?php echo $rownew["time"]; ?></h6>
					      <p class="block-ellipsis" style="text-align: justify;"><?php echo $rownew["summary"]; ?></p>
					   </a>
<?php if (isset($_SESSION["username"]) && $_SESSION["user_id"] == $user_id) { ?>
	   		<a href="<?php echo 'editnews.php?editnews='.$news_id; ?>" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-pen"></i></h6></a>
	   		<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-trash-alt"></i></h6></button>
<?php } else if (isset($_SESSION["role"]) && $_SESSION["role"] > 0) {?>
				<button onclick="deletenews(<?php echo $news_id; ?>)" class="btn btn-info mb-1"><h6 class="mb-0"><i class="fas fa-trash-alt"></i></h6></button>
<?php } ?>
			      </div>
<?php } else echo '<div class="col bg-white mb-4 mr-4 border" style="visibility: hidden;"></div>' ?>
			   </div>
<?php } if ($cnt == 0) {echo "<h2 class='text-center'>Chưa có bài viết nào trong mục này!</h2>";} ?>
	   	</div>
	   	<div class="col p-0">
<?php 
    if (isset($_SESSION["username"])) echo '<a href="addnews.php" class="btn btn-outline-info w-100 mb-1"><h2 class="mb-0">ĐĂNG BÀI <i class="fas fa-feather-alt"></i></h2></a>';
    $sqlgt = "SELECT * FROM news WHERE id=1";
    $resgt = $conn -> query($sqlgt);
    $rowgt = $resgt -> fetch_assoc();
?>
	   		<div class="row no-gutters card text-info bg-white shadow rounded-lg mb-4">
				  	<div class="card-header bg-white d-flex align-items-center justify-content-between ">
				  		<h1 class="mb-0"><?php echo $rowgt["title"]; ?></h1>
				  		<a href="news.php?news_id=1" class="btn btn-outline-info">Đọc thêm</a>
					</div>
				  	<div class="card-body py-2">
				    	<p class="card-text" style="text-align: justify;"><?php echo $rowgt["summary"]; ?></p>
				  	</div>
				</div>
				<div class="row bg-white no-gutters rounded-lg mb-4 shadow p-4">
		      	<h1 class="w-100">TRANG</h1>
 		      	<ul style="padding: 0px; word-spacing: -5px;">
<?php
	$respage = $conn -> query($sqlpage);
	$rowpage = $respage -> num_rows;
	$page = $rowpage/$size; $cnt = 0; $pn = 1;
	if (isset($_GET['page'])) $pn = $_GET['page'];
	while ($page > 0) {
	    ++$cnt; --$page;
		if (isset($_SERVER['QUERY_STRING'])) $link = $_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."&page=".$cnt;
		else $link = $_SERVER["PHP_SELF"]."&page=".$cnt;
		if ($cnt == $pn) echo '<li class="page-item"><a class="btn btn-lg btn-info rounded-0 active" href="'.$link.'">'.$cnt.'</a></li>'; 
		else echo '<li class="page-item"><a class="btn btn-lg btn-info rounded-0" href="'.$link.'">'.$cnt.'</a></li>';
	}
?>					</ul> 
		      	<h2 class="w-100">DANH MỤC</h2>
<?php  
	$sqlse = "SELECT * FROM category";
	$resse = $conn -> query($sqlse);
	while ($rowse = $resse -> fetch_assoc()) {
		$catid = $rowse['id'];
		$category = $rowse['category'];
		if (isset($_GET['cat']) && $_GET['cat'] == $catid) {
			echo '<a style="margin: 1px;" href="news.php" class="btn btn-lg btn-info rounded-0 active">'.$category;
			echo ' <span style="font-weight: bold; font-size: 22px;">&times;</span></a>';
		} else echo '<a style="margin: 1px;" href="news.php?cat='.$catid.'" class="btn btn-lg btn-info rounded-0">'.$category.'</a>';
	}

	if (isset($_GET["cat"])) {
		echo '<h2 class="w-100 mt-3">CHUYÊN MỤC</h2>';
		$sqlse = "SELECT * FROM subcategory WHERE category_id=".$_GET["cat"];
		$resse = $conn -> query($sqlse);
		while ($rowse = $resse -> fetch_assoc()) {
			$subcatid = $rowse['id'];
			$subcategory = $rowse['subcategory'];
			if (isset($_GET['subcat']) && $_GET['subcat'] == $subcatid) {
				echo '<a style="margin: 1px;" href="news.php?cat='.$_GET["cat"].'" class="btn btn-lg btn-info rounded-0 active">'.$subcategory;
				echo ' <span style="font-weight: bold; font-size: 22px;">&times;</span></a>';
			} else echo '<a style="margin: 1px;" href="news.php?cat='.$_GET["cat"].'&subcat='.$subcatid.'" class="btn btn-lg btn-info rounded-0">'.$subcategory.'</a>';
		}
	}
?>
		      </div>
	   	</div>
   	</div>
 	</div>
<?php } ?>
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
               		<img src="folder/user.png" id="showimg" alt="yourimage" width="150" height="150" class="border border-info rounded-circle"> <br>
               		<input type="file" id="imgInp" style="display: none;">
	            		<input type="text" name="image" id="image" value="folder/user.png" hidden>
	            		<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#upload"><i class="fas fa-upload"></i> Chọn ảnh</button>
            		</div>
                	Tên đăng nhập:<input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" maxlength="30" required>
                	Email:<input type="email" class="form-control" name="email" placeholder="Email" maxlength="30" required autofocus>
                	Giới thiệu:<input type="text" class="form-control" name="intro" placeholder="Viết một cái gì đó về bản thân" maxlength="50">
               	Mật khẩu:<input type="password" id="password" class="form-control" name="password" maxlength="30" placeholder="Mật khẩu" required>
                	Nhập lại mật khẩu:<input type="password" id="repassword" class="form-control" placeholder="Nhập lại mật khẩu" required>
            	</div>
            	<div class="modal-footer">
            		<h5 style="color: red;" id="err"></h5>
            		<input type="submit" id="myBtn" value="Đăng kí" class="btn btn-info">
            		<label id="text" class="btn text-light btn-danger rounded font-weight-bold active" hidden>Nhập mật khẩu chưa khớp</label>
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
 	</script>

  	<script>
  		var target = document.getElementById('range');
  		document.getElementById('fillrangevalue').style.width = + (target.value*100)/5 +'%';
    	var eventList = ["mousemove", "touchmove", "click"];
    	for(event of eventList) {
        	target.addEventListener(event, function() {
            document.getElementById('fillrangevalue').style.width = + (this.value*100)/5 +'%';
        	});
    	}

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