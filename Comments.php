<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>
<?php Confirm_Login(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Comments</title>
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
	<!-- Navbar End -->


	<!-- HEADER -->
		<header class="bg-dark text-white py-3">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					<h1><i class="fas fa-comments" style="color: #097879"></i> Manage Comments</h1>
					</div>
				</div>
			</div>
		</header>


	<!-- HEADER  END-->

	<!-- Main Area Start -->
	<section class="container py-2 mb-4">
		<div class="row" style="min-height: 30px">
			<div class="col-lg-12" style="min-height: 360px">
				<?php 

				echo ErrorMessage();
				echo SuccessMessage();

				 ?>
				<h2>Un-Approved Comments</h2>
				<table class="table table-striped table-bordered table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No. </th>
							<th>Date&Time</th>
							<th>Name</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
					</thead>

				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY id desc";
				$Execute = $ConnectingDB->query($sql);
				$SrNo = 0;
				while ($DataRows = $Execute->fetch()) {
					$CommentId = $DataRows["id"];
					$DateTimeOfComment = $DataRows["datetime"];
					$CommenterName = $DataRows["name"];
					$CommentContent = $DataRows["comment"];
					$CommentPostId = $DataRows["post_id"];
					$SrNo++;
					if (strlen($CommenterName) > 10) {
						$CommenterName = substr($CommenterName, 0,10) . '...';
					}

					// if (strlen($DateTimeOfComment) > 9) {
					// 	$DateTimeOfComment = substr($DateTimeOfComment, 0,11) . '...';
					// }

				 ?>

				 <tbody>
				 	<tr>
				 		<td><?= $SrNo; ?></td>
				 		<td><?= $DateTimeOfComment; ?></td>
				 		<td><?= $CommenterName; ?></td>
				 		<td><?= $CommentContent; ?></td>
				 		<td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>

				 		<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>

				 		<td style="min-width: 140px"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
				 	</tr>
				 </tbody>
				<?php } ?>
			</table>


				<h2>Approved Comments</h2>
				<table class="table table-striped table-bordered table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No. </th>
							<th>Date&Time</th>
							<th>Name</th>
							<th>Comment</th>
							<th>Revert</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
					</thead>

				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM comments WHERE status = 'ON' ORDER BY id desc";
				$Execute = $ConnectingDB->query($sql);
				$SrNo = 0;
				while ($DataRows = $Execute->fetch()) {
					$CommentId = $DataRows["id"];
					$DateTimeOfComment = $DataRows["datetime"];
					$CommenterName = $DataRows["name"];
					$CommentContent = $DataRows["comment"];
					$CommentPostId = $DataRows["post_id"];
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
				 		<td><?= htmlentities($SrNo); ?></td>
				 		<td><?= htmlentities($DateTimeOfComment); ?></td>
				 		<td><?= htmlentities($CommenterName); ?></td>
				 		<td><?= htmlentities($CommentContent); ?></td>
				 		<td style="min-width: 140px"><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>

				 		<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>

				 		<td style="min-width: 140px"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
				 	</tr>
				 </tbody>
				<?php } ?>
			</table>

			</div>
		</div>
	</section>
	<!-- Main Area End -->


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