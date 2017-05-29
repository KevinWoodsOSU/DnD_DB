<?php
//Turn on error reporting
ini_set('display_errors', 'On'); 

//Connects to database
$mysqli = new mysqli("classmysql.engr.oregonstate.edu", "cs340_woodske", "9129", "cs340_woodske");

//Reports error if failed to connect to database
if($mysqli->connect_errno) {
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Final Project: Main Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
</head>
	<body>
	<h1>Dungeons and Dragons Database</h1>
	<h2>Characters</h2>
		<div class="container">
			<div class="row">
				<div class ="col-lg-6">
					<table class="table table-striped">
						<tr>
							<td>Characters</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>Race</td>
							<td>Class</td>
							<td>See Stats</td>
						</tr>
						<?php 
						//Select the id, name, race, and class of all rows from dnd_character
						if(!($stmt = $mysqli->prepare("SELECT c.id, c.name, r.name, cl.name FROM dnd_character c INNER JOIN dnd_race r ON c.race = r.id INNER JOIN dnd_class cl ON c.class = cl.id"))) {
							echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
						}

						if(!($stmt->execute())) {
							echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
						}
						//Takes results of query and sticks them in variables
						if(!($stmt->bind_result($id, $name, $race, $class))){
							echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
						}
						//while there are still results being bound to variables
						//Dynamically populate table with name, race, class, and button to display stats
						while($stmt->fetch()){
						 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $race . "\n</td>\n<td>\n" . $class . "\n</td>\n<td>\n<button method='get' class='btn btn-success' name='display' type='submit' value='Display' id='displayID_" . $id . "'/button>\n</td>\n</tr>";
						}

						$stmt->close();
						?> 
					</table>
				</div>
				<div class ="col-lg-6" id="statsDiv">
					<table class="table table-striped" id="stats-table">
						<tr>
							<td>Stats</td>
						</tr>
						<tr>
							<td>Strength</td>
							<td>Dexterity</td>
							<td>Constitution</td>
							<td>Intelligence</td>
							<td>Wisdom</td>
							<td>Charisma</td>
							<td>HP</td>
							<td>AC</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="container">
			<div>
				<form method="post" action="addChar.php">
					<fieldset>
							<legend>Name</legend>
							<p>Name: <input type="text" name="FirstName"></p>
							<span>Strength: <input type="text" name="LastName"></span>
							<span>Dexterity: <input type="text" name="LastName"></span>
							<span>Constitution: <input type="text" name="LastName"></span>
							<span>Intelligence: <input type="text" name="LastName"></span>
							<span>Wisdom: <input type="text" name="LastName"></span>
							<span>Charisma: <input type="text" name="LastName"></span>
							<span>Health Points: <input type="text" name="LastName"></span>
							<span>Armor Class: <input type="text" name="LastName"></span>
					</fieldset>

					<fieldset>
						<legend>Age</legend>
						<p>Age: <input type="text" name="Age"></p>
					</fieldset>

					<fieldset>
						<legend>Race</legend>
						<select name="Homeworld">
				
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_race"))){
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
					</fieldset>
					<p><input type="submit" name="submit"></p>
				</form>
			</div>
		</div>
	</body>
</html>