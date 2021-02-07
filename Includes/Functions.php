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

function Login_Attempt($UserName, $Password){
	global $ConnectingDB;
	$sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':userName',$UserName);
	$stmt->bindValue(':passWord',$Password);
	$stmt->execute();

	$Result = $stmt->rowcount();
	if ($Result == 1) {
		return $Found_Account=$stmt->fetch();
	} else {
		return null;
	}
}

function Confirm_Login() {
	if (isset($_SESSION["UserId"])) {
		return true;
	} else {
		$_SESSION["ErrorMessage"] = "Login Required !";
		Redirect_to("Login.php");
	}
}

function TotalPosts() {
	global $ConnectingDB;
	$sql = "SELECT COUNT(*) FROM posts";
	$smt = $ConnectingDB->query($sql);
	$TotalRrows = $smt->fetch();
	$TotalPosts = array_shift($TotalRrows);
	echo $TotalPosts;
}

function TotalCategories() {
	global $ConnectingDB;
	$sql = "SELECT COUNT(*) FROM category";
	$smt = $ConnectingDB->query($sql);
	$TotalRrows = $smt->fetch();
	$TotalCategories = array_shift($TotalRrows);
	echo $TotalCategories;
}

function TotalAdmins() {
	global $ConnectingDB;
	$sql = "SELECT COUNT(*) FROM admins";
	$smt = $ConnectingDB->query($sql);
	$TotalRrows = $smt->fetch();
	$TotalAdmins = array_shift($TotalRrows);
	echo $TotalAdmins;
}

function TotalComments() {
	global $ConnectingDB;
	$sql = "SELECT COUNT(*) FROM comments";
	$smt = $ConnectingDB->query($sql);
	$TotalRrows = $smt->fetch();
	$TotalComments = array_shift($TotalRrows);
	echo $TotalComments;
}

function ApproveCommentsAccordingToPost($PostId) {

	global $ConnectingDB;
	$sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
	$stmtApprove = $ConnectingDB->query($sqlApprove);
	$RowsTotal = $stmtApprove->fetch();
	$Total = array_shift($RowsTotal);
	return $Total;
}

function DisApproveCommentsAccordingToPost($PostId) {
		global $ConnectingDB;
	$sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
	$stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
	$RowsTotal = $stmtDisApprove->fetch();
	$Total = array_shift($RowsTotal);
	return $Total;
}