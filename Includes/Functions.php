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