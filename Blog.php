<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<link rel="stylesheet" href="Css/bootstrap.min.css">
		<link rel="stylesheet" href="Css/Styles.css">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<title>Blog Page</title>
		<style type="text/css" media="screen">
			.heading {
			font-family: Bitter,Georgia,"Times New Roman",Times,serif;
			font-weight: bold;
			color: #005E90;
			}

			.heading:hover {
			color: #0090DB;
			}
		</style>
	</head>
<body>
	<!-- Navbar -->
	<div style="height:10px; background: #090979;"></div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a href="#" class="navbar-brand">Mukhammadamin</a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS" >
					<span class="navbar-toggler-icon"></span>
				</button>
			<div class="collapse navbar-collapse" id="navbarcollapseCMS">
				<ul class="navbar-nav mr-auto"> 

					<li class="nav-item">
						<a href="Blog.php" class="nav-link"><i class="fas fa-layer-group text-info"></i>Home</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link"><i class="fas fa-user text-warning"></i>About Us</a>
					</li>
					<li class="nav-item">
						<a href="Blog.php" class="nav-link"><i class="fas fa-blog text-primary"></i>Blog</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link"><i class="fas fa-phone text-success"></i>Contact Us</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link"><i class="fas fa-lightbulb-on text-warning"></i>Features</a>
					</li>

				</ul>

				<ul class="navbar-nav ml-auto" >
					<form class="form-inline d-none d-sm-block" action="Blog.php">
						<div class="form-group">
							<input class="form-control mr-2" type="text" name="Search" placeholder="Search here">
							<button class="btn btn-primary" name="SearchButton">Go</button>

						</div>
					</form>
				</ul>

			</div>
		</div>
	</nav>
	<div style="height:10px; background: #090979;"></div>
	<!-- Navbar End -->


	<!-- HEADER -->

	<div class="container">
		<div class="row mt-4">

			<!-- Main Area Start -->
			<div class="col-sm-8">
				<h1>The Complete Responsiv CMS Blog</h1>
				<h1 class="lead">The Complete blog by using PHP (PDO) by Mukhammadamin Abdullaev</h1>
				<?php 

				echo ErrorMessage();
				echo SuccessMessage();

				 ?>
				<?php 

				global $ConnectingDB;
				// Sql query active when search button active
				if (isset($_GET["SearchButton"])) {
					$Search = $_GET["Search"];
					$sql = "SELECT * FROM posts 
					WHERE datetime LIKE :search 
					OR title LIKE :search
					OR category LIKE :search
					OR post LIKE :search";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue(':search', '%'.$Search.'%');
					$stmt->execute();
				} // Query when pagination is Active i.e Blog.php?Page=1
				elseif (isset($_GET["page"])) {
					$Page = $_GET["page"];
					if ($Page == 0 || $Page < 1) {
						$ShowPostFrom = 0;
					} else { $ShowPostFrom = ($Page * 5) - 5;
						}
					$sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
					$stmt = $ConnectingDB->query($sql);
				} 
					// Query When Category is active in URL tab
				 elseif (isset($_GET["category"])) {
					$Category = $_GET["category"];
					$sql = "SELECT * FROM posts WHERE category=:categoryName ORDER BY id desc";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue(':categoryName',$Category);
					$stmt->Execute();
				}

				// The default SQL query
				else{
					$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0, 3";
					$stmt = $ConnectingDB->query($sql);
				}
				while ($DataRows = $stmt->fetch()) {

					$PostId   			=   $DataRows["id"];
					$DateTime 			=	$DataRows["datetime"];
					$PostTitle  		=	$DataRows["title"];
					$Category   		=	$DataRows["category"];
					$Admin 				=	$DataRows["author"];
					$Image 				=	$DataRows["image"];
					$PostDescription    =	$DataRows["post"];

				 ?>
				 <div class="card">
				 	<img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height: 450px" class="img-fluid card-img-top" alt="Failed To Upload Image" />
				 	<div class="card-body">
				 		<h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
				 			<small class="text-muted">Category: <span class="text-dark"><a href="Blog.php?category=<?= htmlentities($Category); ?>"><?= htmlentities($Category); ?></a></span> | Written by: <span class="text-dark"><a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo $Admin ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime) ?></span></small>
				 			<span style="float: right;" class="badge badge-dark text-light">Comments
				 				<?= ApproveCommentsAccordingToPost($PostId); ?>
				 			</span>
				 			<hr>
				 			<p class="card-text">
				 				<?php 
if (strlen($PostDescription) > 150) {
$PostDescription = substr($PostDescription, 0, 150) . "...";
}
echo htmlentities($PostDescription); 
			 					?>
				 				</p>
				 			<a href="FullPost.php?id=<?php echo $PostId; ?>" style="float: right;"><span class="btn btn-info">Read More >></span></a>
				 	</div>
				 </div>
				 <br>
				<?php } ?>
				<!-- Pagination -->
				<nav>
					<ul class="pagination pagination-lg">
						<!-- Creating Backward Button -->
                      <?php if (isset($Page)) {
                      	if ($Page > 1) { ?>
	                  	<li class="page-item">
							<a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
						</li>
					<?php } }?>
						<?php
 
                        global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        // echo $TotalPosts . "<br>";
                        $PostPagination = $TotalPosts / 5;
                        $PostPagination = ceil($PostPagination);
                        // echo $PostPagination;
                        for ($i=1; $i <= $PostPagination ; $i++) {
                        	if (isset($Page)) {
                        		if ($i == $Page) { ?>
                        			
						<li class="page-item active">
							<a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
						</li>
						<?php } else { ?>

						<li class="page-item">
							<a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
						</li>

                      <?php } } }?>

                      <!-- Creating Forward Button -->
                      <?php if (isset($Page) && !empty($Page)) {
                      	if ($Page + 1 <= $PostPagination) { ?>
	                  	<li class="page-item">
								<a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
						</li>
					<?php } }?>
					</ul>
				</nav>
			</div>
			<!-- Main Area End -->


           <?php require_once "Footer.php" ?>