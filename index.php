<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
 include 'password.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $myUsername, $myPassword, $myUsername);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Wine Database</title>
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
<h1>Current Wine List</h1> <!-- Printing wine list from database -->
	<table>
		<tr>
			<td>Winery Name </td>
			<td>Type </td>
			<td>Year </td>
			<td>Alcohol % </td>
			<td>Description </td>
		</tr>
<?php
//Connects to the database
if(!($stmt = $mysqli->prepare("SELECT winery.name, wine.type, wine.year, wine.alcohol, wine.description FROM wine INNER JOIN winery ON wine.wid = winery.id ORDER BY winery.name ASC"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
//error message thrown if execute doesn't run
if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
//binding variables to prepared statement
if(!$stmt->bind_result($name, $type, $year, $alcohol, $description)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
//while loop runs until there isn't any values to fetch
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $type . "\n</td>\n<td>\n" . $year . "\n</td>\n<td>\n" . $alcohol . "\n</td>\n<td>\n" . $description . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>
<!-- INSERT Section -->
  <h1>Database Insert Section:</h1>
  <form method="post" action="addUser.php">
		<fieldset>
			<legend>Add a User:</legend>
			<label>First Name: </label><br>
			<input type="text" name="firstNameInsert"><br>
			<label>Last Name: </label><br>
			<input type="text" name="lastNameInsert"><br>
			<label>City: </label><br>
			<input type="text" name="cityInsert"><br>
			<label>State: </label><br>
			<input type="text" name="stateInsert"><br>
			<label>Country: </label><br>
			<input type="text" name="countryInsert"><br>
			<input type="submit" value="Add User">
		</fieldset>
	</form>
  <form method="post" action="addWine.php">
    <fieldset>
      <legend>Add a wine:</legend>
      <label>Wine type: </label><br>
      <input type="text" name="wineType"><br>
      <label>Year: </label><br>
      <input type="number" name="wineYear"><br>
      <label>Alcohol %: </label><br>
      <input type="number" name="wineAlcohol"><br>
	  <label>Description: </label><br>
      <input type="text" name="wineDescription"><br>
	  <legend>Category:</legend>
	  <select name="wineCategory"> <!-- Allows user to select from list of categories  -->
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM category"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
		</select>
		<legend>Winery:</legend>
		<select name="wineWinery">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM winery"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
		</select><br>
		<input type="submit" value="Add Wine">
    </fieldset>
  </form>
  <form method="post" action="addWinery.php">
    <fieldset>
		<legend>Add a winery:</legend>
		<label>Winery name: </label><br>
		<input type="text" name="wineryName"><br>
		<label>City: </label><br>
		<input type="text" name="wineryCity"><br>
		<label>State: </label><br>
		<input type="text" name="wineryState"><br>
		<label>Country: </label><br>
		<input type="text" name="wineryCountry"><br>
		<input type="submit" value="Add Winery">
    </fieldset>
  </form>
  <form method="post" action="addCategory.php">
    <fieldset>
      <legend>Add a Category:</legend>
      <label>Category name: </label><br>
      <input type="text" name="categoryName"><br>
      <label>Notes: </label><br>
      <input type="text" name="categoryNotes"><br>
      <input type="submit" value="Add Category">
    </fieldset>
  </form>
  <form method="post" action="addFavorites.php">
    <fieldset>
      <legend>Add favorite wine for user:</legend>      
      <label>Wine name: </label><br>
      <select name="favoritesWine"><br>
<?php
if(!($stmt = $mysqli->prepare("SELECT wine.id, winery.name, wine.year, wine.type FROM wine INNER JOIN winery ON wine.wid = winery.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $wname, $wineyear, $winename)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $wname  . " " . $wineyear . " " . $winename . '</option>\n';
}
$stmt->close();
?>
	  </select><br>
      <label>User: </label><br>
      <select name="favoritesUser"><br>
<?php
if(!($stmt = $mysqli->prepare("SELECT users.id, users.fname, users.lname FROM users"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
		</select><br>
      <input type="submit" value="Add Favorite">
    </fieldset>
  </form>
  
  <h1>View Table Data Section: </h1> <!-- want to view user's favorites, so select user and submit to return that user's favorites -->
  
  <div>
	<h2>Favorites List</h2>
	<table>
		<tr>
			<td>First</td>
			<td>Last</td>
			<td>Winery</td>
			<td>Year</td>
			<td>Type</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT users.fname, users.lname, winery.name, wine.year, wine.type FROM favorites INNER JOIN users ON favorites.uid = users.id INNER JOIN wine ON favorites.wid = wine.id INNER JOIN winery ON wine.wid = winery.id ORDER BY users.lname, users.fname ASC"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($fname, $lname, $wname, $year, $type)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $wname . "\n</td>\n<td>\n" . $year . "\n</td>\n<td>\n" . $type . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>
<div>
<h2>Filter User by City</h2> <!-- Allows user to select a city to view users from that city -->
	<form method="post" action="filterUsersByCity.php">
		<fieldset>
			<legend>Select a city to view all users from that city:</legend>
				<select name="filterUsersByCity">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT city FROM users"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($city)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo '<option>' . $city . '</option>\n';
					}
					$stmt->close();
					?>
				</select>
		<input type="submit" value="View Users from Selected City" />
		</fieldset>
	</form>
</div>
<h2>Filter Wine by Type</h2>
	<form method="post" action="filterWineByType.php">
		<fieldset>
			<legend>Select a type you want to view:</legend>
				<select name="filterWineByType">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT DISTINCT type FROM wine"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($type)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo '<option>' . $type . '</option>\n';
					}
					$stmt->close();
					?>
				</select>
		<input type="submit" value="View Wines of that Type" />
		</fieldset>
	</form>
</div>
<h2>Filter all wines from a winery</h2>
	<form method="post" action="filterWineryByWine.php">
		<fieldset>
			<legend>Select a type you want to view:</legend>
				<select name="filterWineryByWine">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM winery"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($name)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo '<option>' . $name . '</option>\n';
					}
					$stmt->close();
					?>
				</select>
		<input type="submit" value="View Wines from the Winery" />
		</fieldset>
	</form>
<h2>Filter wines of a certain category</h2>
	<form method="post" action="filterWineByCategory.php">
		<fieldset>
			<legend>Select a category you want to view:</legend>
				<select name="filterWineByCategory">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT name FROM category"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($name)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo '<option>' . $name . '</option>\n';
					}
					$stmt->close();
					?>
				</select>
		<input type="submit" value="View Wines from this Category" />
		</fieldset>
	</form>
<!-- Delete Section -->
 <h1>Delete from Databases Section</h1>
  <div>
    <h2>User Deletion Section:</h2>
    <form method="post" action="deleteUser.php">
      <fieldset>
        <legend>Please select a user to delete: </legend>
        <select name="deleteUser">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM users"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <input type="submit" value="Delete User">
      </fieldset>
    </form>
  </div>
  <div>
	<h2>Wine Deletion Section:</h2>
    <form method="post" action="deleteWine.php">
      <fieldset>
        <legend>Please select a wine to delete: </legend>
        <select name="deleteWine">
<?php
if(!($stmt = $mysqli->prepare("SELECT wine.id, winery.name, wine.year, wine.type FROM wine INNER JOIN winery ON wine.wid = winery.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $wname, $wineyear, $winename)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $wname  . " " . $wineyear . " " . $winename . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <input type="submit" value="Delete Wine">
      </fieldset>
    </form>
  </div>
  <div>
	<h2>Winery Deletion Section:</h2>
    <form method="post" action="deleteWinery.php">
      <fieldset>
        <legend>Please select a winery to delete: </legend>
        <select name="deleteWinery">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name, city, state, country FROM winery"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name, $city, $state, $country)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $name . " " . $city .  " " . $state .  " " . $country . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <input type="submit" value="Delete Winery">
      </fieldset>
    </form>
  </div>
    <div>
	<h2>Category Deletion Section:</h2>
    <form method="post" action="deleteCategory.php">
      <fieldset>
        <legend>Please select a category to delete: </legend>
        <select name="deleteCategory">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM category"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <input type="submit" value="Delete Category">
      </fieldset>
    </form>
  </div>
      <div>
	<h2>Favorite Deletion Section:</h2>
    <form method="post" action="deleteFavorite.php">
      <fieldset>
        <legend>Please select a wine from favorites to delete: </legend>
        <select name="deleteFavoriteWine">
<?php
if(!($stmt = $mysqli->prepare("SELECT favorites.wid, winery.name, wine.year, wine.type FROM favorites INNER JOIN wine ON favorites.wid = wine.id INNER JOIN winery ON wine.wid = winery.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($wid, $wname, $year, $type)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $wid . ' "> ' . $wname . " " . $year . " " . $type . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <legend>Please select a user from favorites to delete: </legend>
        <select name="deleteFavoriteUser">
<?php
if(!($stmt = $mysqli->prepare("SELECT favorites.uid, users.fname, users.lname FROM favorites INNER JOIN users ON favorites.uid = users.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($uid, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $uid . ' "> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <input type="submit" value="Delete Favorite">
      </fieldset>
    </form>
</div>
<!-- Update Section -->
 <h1>Update Databases Section</h1>
 <h2>User Update Section: </h2>
    <form method="post" action="updateUsers.php">
      <fieldset>
		<legend>Please select a user to update:</legend>
        <select name="updateUsers">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM users"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $fname . " " . $lname . '</option>\n';
}
$stmt->close();
?>
        </select><br>
        <label>Updated User First Name: </label><br>
        <input type="text" name="updateUsersFname"><br>
		<label>Updated User Last Name: </label><br>
        <input type="text" name="updateUsersLname"><br> 
		<label>Updated User City: </label><br>
        <input type="text" name="updateUsersCity"><br> 
		<label>Updated User State: </label><br>
        <input type="text" name="updateUsersState"><br> 
		<label>Updated User Country: </label><br>
        <input type="text" name="updateUsersCountry"><br> 
        <input type="submit" value="Update User">
      </fieldset>
    </form>
 <h2>Wine Update Section: </h2>
	<form method="post" action="updateWine.php">
		<fieldset>
		<legend>Please select a wine to update:</legend>
		<select name="updatedWineId"><br>
<?php
if(!($stmt = $mysqli->prepare("SELECT wine.id, winery.name, wine.year, wine.type FROM wine INNER JOIN winery ON wine.wid = winery.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $wname, $wineyear, $winename)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $wname  . " " . $wineyear . " " . $winename . '</option>\n';
}
$stmt->close();
?>
		</select>
		<br>
		<label>Updated Wine type: </label><br>
		<input type="text" name="updatedWineType"><br>
		<label>Updated Year: </label><br>
		<input type="number" name="updatedWineYear"><br>
		<label>Updated Alcohol %: </label><br>
		<input type="number" name="updatedWineAlcohol"><br>
		<label>Updated Description: </label><br>
		<input type="text" name="updatedWineDescription"><br>
		<label>Category:</label><br>
		<select name="updatedWineCategory">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM category"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
			</select><br>
			<label>Winery:</label><br>
			<select name="updatedWineWinery">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM winery"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
			</select><br>
      <input type="submit" value="Update Wine">
    </fieldset>
  </form>
 <h2>Winery Update Section: </h2>
  <form method="post" action="updateWinery.php">
    <fieldset>
      <legend>Please select a winery to update:</legend>
			<select name="updatedWineryId">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM winery"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
		</select>
		<br>
		<label>Updated Winery name: </label><br>
		<input type="text" name="updatedWineryName"><br>
		<label>Updated City: </label><br>
		<input type="text" name="updatedWineryCity"><br>
		<label>Updated State: </label><br>
		<input type="text" name="updatedWineryState"><br>
		<label>Updated Country: </label><br>
		<input type="text" name="updatedWineryCountry"><br>
      <input type="submit" value="Update Winery">
    </fieldset>
  </form>
  <h2>Category Update Section: </h2>
    <form method="post" action="updateCategory.php">
    <fieldset>
		<legend>Please select a category to update:</legend>
			<select name="updatedCategoryId">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM category"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>
			</select>
			<br>
			<label>Updated category name: </label><br>
			<input type="text" name="updatedCategoryName"><br>
			<label>Update category notes: </label><br>
			<input type="text" name="updatedCategoryNotes"><br>
			<input type="submit" value="Update Category">
    </fieldset>
  </form>
 <!-- Allow user to go to the top of the page -->
<hr>
<form action="https://web.engr.oregonstate.edu/~lagrewj/CS340/FP/index.php#top">
<input type="submit" value="Go to top of Page">
</form>
</body>
</html>