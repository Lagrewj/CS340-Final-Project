<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
include 'password.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $myUsername, $myPassword, $myUsername);
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("UPDATE users SET fname = ?, lname = ?, city = ?, state = ?, country = ? WHERE id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sssssi",$_POST['updateUsersFname'],$_POST['updateUsersLname'],$_POST['updateUsersCity'],$_POST['updateUsersState'],$_POST['updateUsersCountry'],$_POST['updateUsers']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Updated " . $stmt->affected_rows . " rows from users.";
}
?>