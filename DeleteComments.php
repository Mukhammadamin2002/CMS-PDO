<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php 

if (isset($_GET["id"])) {
	
	$SearchQueryParameter = $_GET["id"];
	global $ConnectingDB;

	$sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
	$Execute = $ConnectingDB->query($sql);

	// var_dump($Execute);

	if ($Execute) {
		$_SESSION["SuccessMessage"] = "Comment Deleted Successfully ! ";
		Redirect_to("Comments.php");

	} else {
		$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again ! ";
		Redirect_to("Comments.php");

	}
} 

 ?>