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
			<td>All Wines from specified Winery</td>
		</tr>
		<tr>
			<td>Winery</td>
			<td>Year</td>
			<td>Type</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT winery.name, wine.year, wine.type FROM wine INNER JOIN winery ON wine.wid = winery.id WHERE winery.name = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("s",$_POST['filterWineryByWine']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $year, $type)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $year . "\n</td>\n<td>\n" . $type . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>
<hr>
<a href="http://web.engr.oregonstate.edu/~lagrewj/CS340/FP/index.php">Back to Main Page</a> 
</body>
</html>