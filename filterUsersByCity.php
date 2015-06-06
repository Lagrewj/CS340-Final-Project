<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
include 'password.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $myUsername, $myPassword, $myUsername);
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <style>
  table, th, td {
    border: 1px solid black; <!-- table cell borders -->
    border-collapse: collapse;
	padding: 10px; <!-- table padding -->
}
  </style>
</head>
<body>
<div>
	<table>
		<tr>
			<td>Users From Same City</td>
		</tr>
		<tr>
			<td>First Name</td>
			<td>Last Name</td>
			<td>City</td>
			<td>State</td>
			<td>Country</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT fname, lname, city, state, country FROM users WHERE city = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("s",$_POST['filterUsersByCity']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($fname, $lname, $city, $state, $country)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $city . "\n</td>\n<td>\n" . $state . "\n</td>\n<td>\n" . $country . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>

</body>
</html>