
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>

<?php Confirm_Login(); ?>

<?php 

// Fetching the existing Admin Data Start
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
	$ExistingName = $DataRows["aname"];
	$ExistingHeadline = $DataRows["aheadline"];
	$ExistingBio = $DataRows["abio"];
	$ExistingImage = $DataRows["aimage"];
	$ExistingUsername = $DataRows["username"];
}
// Fetching the existing Admin Data End

if(isset($_POST['Submit'])) {
		$AName = $_POST["Name"];
		$AHeadline = $_POST["Headline"];
		$ABio = $_POST["Bio"];
		$Image = $_FILES["Image"]["name"];
		$Target = "Images/".basename($_FILES["Image"]["name"]);
		

		if (strlen($AHeadline) > 30) {
			$_SESSION["ErrorMessage"] = 'Headline should be less than 30 characters';
			Redirect_to("MyProfile.php");
		} elseif (strlen($ABio) > 500) {
			$_SESSION["ErrorMessage"] = 'Post Description should be less than 10000 characters';
			Redirect_to("MyProfile.php");
		} else {
			// Query to UPDATE Admin Data in DB when everything is fine
			global $ConnectingDB;
			if (!empty($_FILES["Image"]["name"])) {

			$sql = "UPDATE admins SET 
				aname='$AName',
				aheadline='$AHeadline',
				abio='$ABio',
				aimage='$Image'
				WHERE id = '$AdminId'";

			} else {
			$sql = "UPDATE admins SET 
				aname='$AName',
				aheadline='$AHeadline',
				abio='$ABio'
				WHERE id ='$AdminId'";
			}

			$Execute = $ConnectingDB->query($sql);

			move_uploaded_file($_FILES['Image']["tmp_name"], $Target);
			// var_dump($Execute);

			if ($Execute) {
				$_SESSION["SuccessMessage"]="Detailes Updated Successfully";
				Redirect_to("MyProfile.php");
			} else {
				$_SESSION["ErrorMessage"] = 'Something went wrong. Try Again !';
				Redirect_to("MyProfile.php");
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
		<link rel="stylesheet" href="Css/bootstrap.min.css">
		<link rel="stylesheet" href="Css/Styles.css">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<title>My Profile</title>
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
						<a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-primary"></i>My Profile</a>
					</li>
					<li class="nav-item">
						<a href="Dashboard.php" class="nav-link">Dashboard</a>
					</li>
					<li class="nav-item">
						<a href="Posts.php" class="nav-link">Posts</a>
					</li>
					<li class="nav-item">
						<a href="Categories.php" class="nav-link">Categories</a>
					</li>
					<li class="nav-item">
						<a href="Admins.php" class="nav-link">Manage Admins</a>
					</li>
					<li class="nav-item">
						<a href="Comments.php" class="nav-link">Comments</a>
					</li>
					<li class="nav-item">
						<a href="Blog.php?page=1" class="nav-link">Live Blog</a>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto" >
					<li class="nav-item">
					<a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times text-danger"></i>Logout</a>
					</li>
				</ul>

			</div>
		</div>
	</nav>
	<div style="height:10px; background: #090979;"></div>
	<!-- NAVBAR END -->

	<!-- HEADER -->
		<header class="bg-dark text-white py-3">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					<h1><i class="fas fa-user mr-2 text-primary"></i>@<?php echo $ExistingUsername; ?></h1>
					<small><?php echo $ExistingHeadline ?></small>
					</div>
				</div>
			</div>
		</header>


	<!-- HEADER  END-->

	<!-- Main Area -->

<section class="container py-2 mb-4">
	<div class="row">
		<!-- Left Area -->
		<div class="col-md-3">
			<div class="card">
				<div class="card-header bg-dark text-light">
					<h3 class="">
						<?php echo $ExistingName; ?>
					</h3>
				</div>
				<div class="card-body">
					<img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
					<div>
						
	<?php echo $ExistingBio; ?>
	
					</div>
				</div>
			</div>
		</div>
		<!-- Right Area -->
		<div class="col-md-9" style="min-height: 400px;">

			<?php echo ErrorMessage(); ?>
			<?php echo SuccessMessage(); ?>

			<form action="MyProfile.php" method="post" enctype="multipart/form-data">
				<div class="card bg-dark text-light">

					<div class="card-header bg-secondary text-light">
						<h4>Edit Profile</h4>
					</div>
					
					<div class="card-body">
						<div class="form-group">
							<input class="form-control" type="text" name="Name" id="title" placeholder="Your Name" value="">
						
						</div>

						<div class="form-group mt-2">
							<input class="form-control" type="text" name="Headline" id="title" placeholder="Headline" value="">
							<small class="text-muted"> Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
							<span class="text-danger"> Not more than 30 characters</span>
						</div>

						<div class="form-group">
							<textarea class="form-control" placeholder="Bio" name="Bio" rows="8" cols="80" id="Post" cols="30" rows="10"></textarea>
						</div>
					

						<div class="form-group">
							<div class="custom-file">
								<input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
								<label for="imageSelect" class="custom-file-label">Select Image</label>
							</div>
						</div>


						<div class="row text-center">
							<div class="col-lg-6 mt-2">
								<a href="Dashboard.php" class="btn btn-warning  btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
							</div>

							<div class="col-lg-6 mt-2">
								<button type="submit" name="Submit" class="btn btn-success  btn-block">
									<i class="fas fa-check"></i> Publish
								</button>
							</div>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>



	<!-- End Main Area -->


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
	<div style="height:10px; background: #090979;"></div>
	</footer>	
	<!-- FOOTER END -->
		<!-- jQuery and Bootstrap Bundle (includes Popper) -->
		<script src="js/jquery-3.5.1.slim.min.js"></script>
		<script src="js/bootstrap.bundle.min.js" ></script>
		<script>
			$('#year').text(new Date().getFullYear());
		</script>
</body>
</html>