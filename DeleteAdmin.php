<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php 

if (isset($_GET["id"])) {
	
	$SearchQueryParameter = $_GET["id"];
	global $ConnectingDB;

	$sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
	$Execute = $ConnectingDB->query($sql);

	// var_dump($Execute);

	if ($Execute) {
		$_SESSION["SuccessMessage"] = "Admin Deleted Successfully ! ";
		Redirect_to("Admins.php");

	} else {
		$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again ! ";
		Redirect_to("Admins.php");

	}
} 

 ?>