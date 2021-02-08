 <!-- Side Area Start -->
			<div class="col-sm-4">
				<div class="card mt-4">
					<div class="car-body">
						<img src="images/adds.jpg" class="d-block img-fluid mb-3" alt="">
						<div class="mx-2 text-center">
							Create and manage your Social Media strategy, including stories, videos and images. 96% Customer Satisfaction. 365 days dedicated support - in-app chat, email, and phone. Unified Platform. Unlimited Reports. Brand Governance. Content Pool.
						</div>
							<a href="https://www.googleadservices.com/pagead/aclk?sa=L&ai=DChcSEwjn6LK_r9nuAhWGtO0KHT08BykYABAAGgJkZw&ae=2&ohost=www.google.com&cid=CAESQOD2_fO20DtpBlHWTkDnDIRVfc63S_1jTPipw1392aBGDkl480lcG7Bax3Cbxi8PdoYL3sQ43wHhbA_oDit1BlE&sig=AOD64_3sCZb017zQ80TGI4DcoW6V70MxIQ&q&adurl&ved=2ahUKEwiJtKq_r9nuAhXKs4sKHaYSBN0Q0Qx6BAgSEAE" class="btn btn-primary my-2 form-control">Visit Us</a>
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header bg-dark text-light">
						<h2 class="lead">Sign Up !</h2>
					</div>
					<div class="card-body">
						<button type="button" class="btn btn-success btn-block text-center text-white" name="button">
							Join the Forum
						</button>
						<button type="button" class="btn btn-danger btn-block text-center text-white" name="button">
							Login
						</button>
						<div class="input-group mt-3">
							<input type="email" class="form-control" placeholder="Enter your Email">
							<div class="input-group-append">
								<button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header bg-primary text-light">
						<h2 class="lead">Categories</h2>
					</div>
						<div class="card-body">
							<?php

                            global $ConnectingDB;
                            $sql = "SELECT * FROM category ORDER BY id desc";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                            	$CategoryId = $DataRows["id"];
                            	$CategoryName = $DataRows["title"];

							 ?>

							 <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo htmlentities($CategoryName); ?></span></a><br>
							<?php } ?>
					</div>
				</div>

				<br>

				<div class="card">
					<div class="card-header bg-info text-white">
						<h2 class="lead">
							Recent Posts
						</h2>
					</div>
						<div class="card-body">
							<?php 

                            global $ConnectingDB;
                            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                            	$Id 		= $DataRows["id"];
                            	$Title 		= $DataRows["title"];
                            	$DateTime 	= $DataRows["datetime"];
                            	$Image 		= $DataRows["image"];
							 ?>
							<div class="media">
								<img height="50" src="Uploads/<?= htmlentities($Image) ?>" class="d-block img-fluid align-self-start" width="90" alt="">
								<div class="media-body ml-2">
									<a href="FullPost.php?id=<?=$Id; ?>" target="_blank">
										<h6 class="lead">
										<?= htmlentities($Title) ?>
										</h6>
									</a>
									<p class="small"><?php echo htmlentities($DateTime) ?></p>
								</div>
							</div>
							<hr>
						<?php } ?>
						</div>
					</div>
				

			</div>
            <!-- Side Area End -->

		</div>
	</div>

	<!-- HEADER  END-->
<br>

		<!-- FOOTER -->
	<footer class="bg-dark text-white">
		<div class="container">
			<div class="row">
				<div class="col">
				<p class="lead text-center">Made By | Mukhammadamin Abdullaev | <span id="year"></span> &copy; ``All right Reserved.`` </p>
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