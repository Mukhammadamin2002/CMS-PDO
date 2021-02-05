<?php require_once("Includes/DB.php"); ?>

<?php 	

function Redirect_to($New_Location) {
	header("Location:" . $New_Location);
	exit;
}

function CheckUserNameExistOrNot($UserName) {
	global $ConnectingDB;
	$sql = "SELECT username FROM admins WHERE username=:userName";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':userName',$UserName);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result == 1) {
		return true;
	} else {
		return false;
	}
}