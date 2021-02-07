
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php Confirm_Login(); ?>

<?php 

$SearchQueryParameter = $_GET['id'];
if(isset($_POST['Submit'])) {
		$PostTitle = $_POST["PostTitle"];
		$Category = $_POST["Category"];
		$Image = $_FILES["Image"]["name"];
		$Target = "Uploads/".basename($_FILES["Image"]["name"]);
		$PostText = $_POST["PostDescription"];
		$Admin = "John";
		date_default_timezone_set("Asia/Karachi");
		$CurrentTime = time();
		$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

		if (empty($PostTitle)) {
			$_SESSION["ErrorMessage"] = 'Title Can\'t be empty!';
			Redirect_to("Posts.php");
		} elseif (strlen($Category) < 5) {
			$_SESSION["ErrorMessage"] = 'Post Title should be greater than 5 characters';
			Redirect_to("Posts.php");
		} elseif (strlen($PostText) > 9999) {
			$_SESSION["ErrorMessage"] = 'Post Description should be less than 10000 characters';
			Redirect_to("Posts.php");
		} else {
			// Query to UPDATE Post in DB when everything is fine
			global $ConnectingDB;
			if (!empty($_FILES["Image"]["name"])) {

			$sql = "UPDATE posts SET 
				title='$PostTitle',
				category='$Category',
				image='$Image',
				post='$PostText'
				WHERE id ='$SearchQueryParameter'";

			} else {
			$sql = "UPDATE posts SET 
				title='$PostTitle',
				category='$Category',
				post='$PostText'
				WHERE id='$SearchQueryParameter'";
			}

			$Execute = $ConnectingDB->query($sql);

			move_uploaded_file($_FILES['Image']["tmp_name"], $Target);

			if ($Execute) {
				$_SESSION["SuccessMessage"]="Post Updated Successfully";
				Redirect_to("Posts.php");
			} else {
				$_SESSION["ErrorMessage"] = 'Something went wrong. Try Again !';
				Redirect_to("Posts.php");
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
		<title>Edit Post</title>
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
					<h1><i class="fas fa-edit" style="color: #097879"></i> Edit Post </h1>
					</div>
				</div>
			</div>
		</header>


	<!-- HEADER  END-->

	<!-- Main Area -->

<section class="container py-2 mb-4">
	<div class="row">
		<div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
			<?php echo ErrorMessage(); ?>
			<?php echo SuccessMessage(); ?>

			<?php 
			// Fetching Existing Content according to our 
			global $ConnectingDB;
			$sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
			$stmt = $ConnectingDB->query($sql);
			while ($DataRows 		 = $stmt->fetch()) {

				$TitleToBeUpdated 	 = $DataRows['title'];
				$CategoryToBeUpdated = $DataRows['category'];
				$ImageToBeUpdated 	 = $DataRows['image'];
				$PostToBeUpdated  	 = $DataRows['post'];
			}

			 ?>

			<form action="EditPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
				<div class="card bg-secondary text-light mb-3">
					
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"><span class="FieldInfo">Post Title: </span></label>
							<input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here..." value="<?= $TitleToBeUpdated; ?>">
						</div>

						<div class="form-group">
							<span class="FieldInfo">Prefered Category was: </span>
							<?= $CategoryToBeUpdated; ?>
							<br>
							<label for="CategoryTitle"><span class="FieldInfo">Choose Category: </span></label>
							<select name="Category" id="CategoryTitle" class="form-control">
								<!-- Fetching all the categories from category table -->
								<?php global $ConnectingDB;
								$sql = "SELECT id,title FROM category";
								$stmt = $ConnectingDB->query($sql);
								while ($DataRows = $stmt->fetch()) {
									
									$Id = $DataRows["id"];
									$CategoryName = $DataRows["title"]; 
						
								 ?>
								 <option><?php echo $CategoryName; ?></option>
						 	<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<span class="FieldInfo">Prefered Image was: </span>
							<img src="Uploads/<?= $ImageToBeUpdated; ?>" width=150px; height='50px' alt="" value="">
							<br>
							<label for="imageSelect"><span class="FieldInfo"> Select Image: </span></label>
							<div class="custom-file">
								<input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
								<label for="imageSelect" class="custom-file-label">Select Image</label>
							</div>
						</div>

						<div class="form-group">
							<label for="Post"><span class="FieldInfo"> Post: </span></label>
							<textarea class="form-control" name="PostDescription" rows="8" cols="80" id="Post" cols="30" rows="10">
								<?= $PostToBeUpdated; ?>
							</textarea>
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