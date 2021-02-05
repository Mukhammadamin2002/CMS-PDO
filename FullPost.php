<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>

<?php 

if(isset($_POST['Submit'])) {

		$Name = $_POST["CommenterName"];
		$Email = $_POST["CommenterEmail"];
		$Comment = $_POST["CommenterThoughts"];
		date_default_timezone_set("Asia/Karachi");
		$CurrentTime = time();
		$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

		if (empty($Name) || empty($Email) || empty($Comment)) {
			$_SESSION["ErrorMessage"] = 'All fields must be filled out!';
			Redirect_to("FullPost.php?id={$SearchQueryParameter}");
		} elseif (strlen($Comment) > 500) {
			$_SESSION["ErrorMessage"] = 'Comment length should be less than 500 characters';
			Redirect_to("FullPost.php?id={$SearchQueryParameter}");
		} else {
			// Query to insert comment in DB when everything is fine
			global $ConnectingDB;
			$sql = "INSERT INTO comments(datetime,name,email, comment,approvedby,status,post_id)";
			$sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':dateTime', $DateTime);
			$stmt->bindValue(':name', $Name);
			$stmt->bindValue(':email', $Email);
			$stmt->bindValue(':comment', $Comment);
			$stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
			$Execute = $stmt->execute();
			// var_dump($Execute);

			if ($Execute) {
				$_SESSION["SuccessMessage"]="Comment Submitted Successfully";
			Redirect_to("FullPost.php?id={$SearchQueryParameter}");
			} else {
				$_SESSION["ErrorMessage"] = 'Something went wrong. Try Again !';
			Redirect_to("FullPost.php?id={$SearchQueryParameter}");
			}
		}
} // Ending of Submit Button If-Condition 

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Blog Page</title>
		<link rel="stylesheet" href="Css/bootstrap.min.css">
		<link rel="stylesheet" href="Css/Styles.css">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
				}
				// The default SQL query
				else{
					$PostIdFromURL = $_GET["id"];
					if (!isset($PostIdFromURL)) {
						$_SESSION["ErrorMessage"]="Undefined Request";
						Redirect_to("Blog.php");
					}
					$sql = "SELECT * FROM posts WHERE id = '$PostIdFromURL'";
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
				 			<small class="text-muted">Written by: <?php echo $Admin ?> On <?php echo htmlentities($DateTime) ?></small>
				 			<span style="float: right;" class="badge badge-dark text-light">Comments 20</span>
				 			<hr>
				 			<p class="card-text">
				 				<?php 
								echo htmlentities($PostDescription); 
			 					?>
				 				</p>
				 	</div>
				 </div>
	<br>
				<?php } ?>
				<!-- Comment Part Start -->
				<div class="">
					<form action="FullPost.php?id=<?= $SearchQueryParameter  ?>" class="" method="post">
						<div class="card mb-3">
							<div class="card-header">
								<h5 class="FieldInfo">Share your thought about this posts</h5>
							</div>
			<div class="card-body">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user text-dark"></i></span>
						</div>
						<input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
						</div>
						<input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
					</div>
				</div>
				<div class="form-group">
					<textarea name="CommenterThoughts" id="" cols="60" class="form-control" rows="6"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
						</div>
						
					</form>
				</div>
			</div>
			<!-- Main Area End -->



            <!-- Side Area Start -->
			<div class="col-sm-4" style="min-height: 40px; background: #00d4ff;">
				
			</div>
            <!-- Side Area End -->

		</div>
	</div>

	<!-- HEADER  END-->

<!-- <div style="min-height: 360px;"></div> -->

		<!-- FOOTER -->
	<footer class="bg-dark text-white">
		<div class="container">
			<div class="row">
				<div class="col">
				<p class="lead text-center">Made By | Mukhammadamin Abdullaev | <span id="year"></span> &copy; ----All right Reserved. </p>
				<p class="text-center small"><a href="#" style="color: white; text-decoration: none;cursor: pointer;" target="_blank">This site is only &trade; used for study porpose</a></p>
				</div>
			</div>
		</div>
	</footer>	
	<div style="height:10px; background: #090979;"></div>


<!-- JavaScript Bundle with Popper -->


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/bootstrap.bundle.min.js" ></script>
	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>