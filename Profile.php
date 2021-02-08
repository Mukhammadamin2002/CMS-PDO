<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!-- Fetching Existing Date -->
<?php 

$SearchQueryParameter = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT aname,aheading,abio,aimage FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if ($Result == 1) {
	while ($DataRows 		= $stmt->fetch()) {
		$ExistingName 		= $DataRows["aname"];
		$ExistingBio 		= $DataRows["abio"];
		$ExistingImage	    = $DataRows["aimage"];
		$ExistingHeadline   = $DataRows["aheadline"];
	}
} else {
	$_SESSION["ErrorMessage"] = "Undefined Request !";
	Redirect_to("Blog.php");
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Profile</title>
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
		<header class="bg-dark text-white py-3">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
					<h1><i class="fas fa-user text-success mr-2" style="color: #097879"></i> <?php echo $ExistingName; ?></h1>
					<h3>
						<?php echo $ExistingHeadline; ?>
						</h3>
					</div>
				</div>
			</div>
		</header>
	<!-- HEADER  END-->

	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-md-3">
				<img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
			</div>
			<div class="col-md-9" style="min-height: 300px;">
				<div class="card">
					<div class="card-body">
						<p class="lead">
							<?php echo $ExistingBio; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

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