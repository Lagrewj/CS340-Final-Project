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
<h2>All Wines from specified Winery</h2>
	<table>
		<tr>
			<td>Winery</td>
			<td>Year</td>
			<td>Type</td>
			<td>Category</td>
			<td>Notes></td>
		</tr>
<?php
//prepared statement
if(!($stmt = $mysqli->prepare("SELECT winery.name, wine.year, wine.type, category.name, category.notes FROM wine INNER JOIN winery ON wine.wid = winery.id INNER JOIN category ON wine.cid = category.id WHERE category.name = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
//error if binding failed
if(!($stmt->bind_param("s",$_POST['filterWineByCategory']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
//error if execute failed
if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
//binding result
if(!$stmt->bind_result($name, $year, $type, $cname, $notes)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
//while loop to print out data while there is data to fetch
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $year . "\n</td>\n<td>\n" . $type . "\n</td>\n<td>\n" . $cname . "\n</td>\n<td>\n" . $notes . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>
<hr>
<a href="http://web.engr.oregonstate.edu/~lagrewj/CS340/FP/index.php">Back to Main Page</a> 
</body>
</html>