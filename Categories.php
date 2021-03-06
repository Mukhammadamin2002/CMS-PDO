
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>

<?php Confirm_Login(); ?>

<?php 

if(isset($_POST['Submit'])) {
		$Category = $_POST["CategoryTitle"];
		$Admin = $_SESSION["UserName"];
		date_default_timezone_set("Asia/Karachi");
		$CurrentTime = time();
		$DateTime = strftime("%B-%d-%Y %H-%M-%S", $CurrentTime);

		if (empty($Category)) {
			$_SESSION["ErrorMessage"] = 'All fields must be filled out!';
			Redirect_to("Categories.php");
		} elseif (strlen($Category) < 3) {
			$_SESSION["ErrorMessage"] = 'Category title should be greater than 2 characters';
			Redirect_to("Categories.php");
		} elseif (strlen($Category) > 49) {
			$_SESSION["ErrorMessage"] = 'Category title should be less than 50 characters';
			Redirect_to("Categories.php");
		} else {
			// Query to insert category in DB when everything is fine
			global $ConnectingDB;
			$sql = "INSERT INTO category(title, author, datetime)";
			$sql .= "VALUES(:categoryName,:adminName,:dateTime)";
			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':categoryName',$Category);
			$stmt->bindValue(':adminName', $Admin);
			$stmt->bindValue(':dateTime', $DateTime);
			$Execute = $stmt->execute();

			if ($Execute) {
				$_SESSION["SuccessMessage"]="Category with id : " .$ConnectingDB->lastInsertId()." Added Successfully";
				Redirect_to("Categories.php");
			} else {
				$_SESSION["ErrorMessage"] = 'Something went wrong. Try Again !';
			Redirect_to("Categories.php");
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
		<title>Categories</title>
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
					<h1><i class="fas fa-edit" style="color: #097879"></i> Manage Categories</h1>
					</div>
				</div>
			</div>
		</header>


	<!-- HEADER  END-->

	<!-- Main Area -->

<section class="container py-2 mb-4">
	<div class="row">
		<div class="offset-lg-1 col-lg-10" style="min-height: 350px;">
			<?php echo ErrorMessage(); ?>
			<?php echo SuccessMessage(); ?>
			<form action="Categories.php" method="post">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-header">
						<h1>Add New Category</h1>
					</div>
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"><span class="FieldInfo">Category Title: </span></label>
							<input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here..." value="">
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

			<h2>Existing Categories</h2>
				<table class="table table-striped table-bordered table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No. </th>
							<th>Date&Time</th>
							<th>Category Name</th>
							<th>Creator Name</th>
							<th>Action</th>
						</tr>
					</thead>

				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM category ORDER BY id desc";
				$Execute = $ConnectingDB->query($sql);
				$SrNo = 0;
				while ($DataRows = $Execute->fetch()) {
					$CategoryId = $DataRows["id"];
					$CategoryDate = $DataRows["datetime"];
					$CategoryName = $DataRows["title"];
					$CreatorName = $DataRows["author"];
					$SrNo++;
					// if (strlen($CommenterName) > 10) {
					// 	$CommenterName = substr($CommenterName, 0,10) . '...';
					// }

					// if (strlen($DateTimeOfComment) > 9) {
					// 	$DateTimeOfComment = substr($DateTimeOfComment, 0,11) . '...';
					// }

				 ?>

				 <tbody>
				 	<tr>
				 		<td><?= $SrNo; ?></td>
				 		<td><?= $CategoryDate; ?></td>
				 		<td><?= $CategoryName; ?></td>
				 		<td><?= $CreatorName; ?></td>
				 		<td><a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>

				 	</tr>
				 </tbody>
				<?php } ?>
			</table>

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


<!-- JavaScript Bundle with Popper -->


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/bootstrap.bundle.min.js" ></script>
	<script>
		$('#year').text(new Date().getFullYear());
	</script>
	</body>
</html>