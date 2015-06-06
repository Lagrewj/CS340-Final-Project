<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
include 'password.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $myUsername, $myPassword, $myUsername);
//if cannot connect then error number and error message thrown
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
//if prepare statement fails then error number and error message thrown	
if(!($stmt = $mysqli->prepare("INSERT INTO category(name, notes) VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
//if binding parameters fails then error number and error message thrown	
if(!($stmt->bind_param("ss",$_POST['categoryName'],$_POST['categoryNotes']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
//if execute fails then throw error or if successful then tell user added row into category
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows into category.";
}
?>