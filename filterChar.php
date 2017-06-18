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
	<link rel = "stylesheet" type = "text/css" href = "style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script.js?v=6"></script>
</head>

<body class = "container">
	<h1>Dungeons and Dragons Database</h1>
	<h2 id="charHeader">Characters</h2>
	<button id="headerBtn1" class="btn btn-primary" name="reset_database">Reset Database</button>
		<div class="row">
			<div class ="col-lg-12">
				<table class="table table-striped">
					<tr>
						<th>Name</th>
						<th>Race</th>
						<th>Class</th>
						<th>Level</th>
						<th>View Character</th>
						<th>Remove Character</th>
					</tr>

					<?php 

					if(!($stmt = $mysqli->prepare("SELECT c.id, c.name, r.name, cl.name, c.level FROM dnd_character c INNER JOIN dnd_race r ON c.race = r.id INNER JOIN dnd_class cl ON c.class = cl.id WHERE c.level = ?"))) {
							echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param('i',$_POST['limit']))) {
							echo "bind_param failed: " . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->execute())) {
					 	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
					}

					//Takes results of query and sticks them in variables
					if(!($stmt->bind_result($id, $name, $race, $class, $level))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					//while there are still results being bound to variables
					//Dynamically populate table with name, race, class, and button to display stats
					while($stmt->fetch()){
					 echo "<tr>\n<td>\n" . $name . 
					 	"\n</td>\n<td>\n" . $race . 
					 	"\n</td>\n<td>\n" . $class . 
					 	"\n</td>\n<td>\n" . $level . 
					 	"\n</td>\n<td>\n<button method='get' class='btn btn-success' name='display_stats' type='submit' value='Display' id='display_stats" . $id . 
					 	"'/button>" . "\n</td>\n<td>\n<button method='get' class='btn btn-danger' name='delete_char' type='submit' value='Display' id='delete_char" . $id . 
					 	"'/button>" . "\n</td>\n</tr>";
					}

					$stmt->close();
					?> 

				</table>
			</div>
		</div><br>

	<h2>Character Information</h2>
	
	<h3>Stats</h3>
		<div class="row">
			<div class ="col-lg-9" id="statsDiv">
				<table class="table table-striped table-bordered table-condensed" >
					<tbody id="stats-table">
						<!-- Stat display goes here -->
					</tbody>
				</table>
			</div>
		</div>
	
	<h3>Skills</h3>
		<div class="row">
			<div class ="col-lg-9" id="statsDiv">
				<table class="table table-striped table-bordered table-condensed" >
					<tbody id="skills-table">
						<!-- Skills display goes here -->
					</tbody>
				</table>
			</div>
		</div>

	<h3>Feats</h3>
		<div class="row">
			<div class ="col-lg-9" id="statsDiv">
				<table class="table table-striped table-bordered table-condensed" >
					<tbody id="feats-table">
						<!-- Feats display goes here -->
					</tbody>
				</table>
			</div>
		</div>

	<h3>Weapons</h3>
		<div class="row">
			<div class ="col-lg-9" id="statsDiv">
				<table class="table table-striped table-bordered table-condensed" >
					<tbody id="weapons-table">
						<!-- Weapons display goes here -->
					</tbody>
				</table>
			</div>
		</div><br>

	<h2>Filter Characters</h2>
		
		<div class="row">
			<div class="col-lg-12">
				<h3>Filter by Level</h3>
				<form method="post" action="filterChar.php" id="char_filter">
					<fieldset>
						Level is =
						<!-- <select name="expression">
							<option value="<"><</option>
							<option value="=">=</option>
							<option value=">">></option>
						</select> -->
						<input type="number" name="limit">
						
						<input type="submit" name="char_filter">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Filter by Class</h3>
				<form method="post" action="filterCharClass.php" id="char_filter_class">
					<fieldset>
						Class: 
						<select name="class">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_class"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>
						
						<input type="submit" name="char_filter_class">
					</fieldset>
				</form><br>
				<button name="return" class="btn btn-warning">No Filter</button>
			</div>
		</div><br>

	
	<h2>Create Character</h2>
		
		<div class="row">
			<div class="col-lg-12">
				<h3>Create a Character</h3>
				<form method="post" action="addChar.php" id="char_submit">
					<fieldset>
						Character name: <input type="text" name="name" required>
						Race: 
						<select name="race">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_race"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Class: 
						<select name="class">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_class"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						<div class="row">
							<div class="col-lg-12">
								Level: <input type="number" name="level" required>
								Str: <input type="number" name="strength" required>
								Dex: <input type="number" name="dexterity" required>
								Con: <input type="number" name="constitution" required>
								Int: <input type="number" name="intelligence" required>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								Wis: <input type="number" name="wisdom" required>
								Cha: <input type="number" name="charisma" required>
								HP: <input type="number" name="HP" required>
								AC: <input type="number" name="AC" required>
							</div>
						</div>
						<input type="submit" name="char_submit">
					</fieldset>
				</form>
			</div>
		</div><br>

	<h2>Update Stats</h2>

		<div class="row">
			<div class="col-lg-12">
				<h3>Update a Character</h3>
				<form method="post" action="updateChar.php" id="update_char">
					<fieldset>
						Character: 
						<select name="id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Level: <input type="number" name="level" required>
						Str: <input type="number" name="strength" required>
						Dex: <input type="number" name="dexterity" required>
						Con: <input type="number" name="constitution" required>

						<div class="row">
							<div class="col-lg-12">
								Int: <input type="number" name="intelligence" required>
								Wis: <input type="number" name="wisdom" required>
								Cha: <input type="number" name="charisma" required>
								HP: <input type="number" name="HP" required>
								AC: <input type="number" name="AC" required>
							</div>
						</div>
						<input type="submit" name="update_char">
					</fieldset>
				</form>
			</div>
		</div><br>


	<h2>Add Content</h2>

		<div class="row">
			<div class="col-lg-12">
				<h3>Add a Race</h3>
				<form method="post" action="addRace.php" id="race_submit">
					<fieldset>
						Race name: <input type="text" name="name" required>
						<input type="submit" name="race_submit">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Add a Class</h3>
				<form method="post" action="addClass.php" id="class_submit">
					<fieldset>
						Class name: <input type="text" name="name" required>
						<input type="submit" name="class_submit">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Add a Skill</h3>
				<form method="post" action="addSkill.php" id="skill_submit">
					<fieldset>
						Skill name: <input type="text" name="name" required>
						Ability Modifier: <input type="text" name="ability" required>
						<input type="submit" name="skill_submit">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Add a Feat</h3>
				<form method="post" action="addFeat.php" id="feat_submit">
					<fieldset>
						Feat name: <input type="text" name="name" required>
						Description: <input type="text" name="description" required>
						Prerequisite: <input type="text" name="prerequisite">
						<input type="submit" name="feat_submit">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Add a Weapon</h3>
				<form method="post" action="addWeapon.php" id="weapon_submit">
					<fieldset>
						Weapon name: <input type="text" name="name" required>
						Damage: <input type="text" name="damage" required>
						Damage type: <input type="text" name="damage_type" required>
						Weapon type: <input type="text" name="weapon_type" required>
						<input type="submit" name="weaopn_submit">
					</fieldset>
				</form>
			</div>
		</div><br>


		<!-- Give characters a skill, feat, or weapon !-->
		<h2>Equip Character</h2>

		<div class="row">
			<div class="col-lg-12">
				<h3>Give a Skill</h3>
				<form method="post" action="giveSkill.php" id="give_skill">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Skill:
						<select name="skill_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_skill"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="give_skill">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Give a Feat</h3>
				<form method="post" action="giveFeat.php" id="give_feat">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Feat:
						<select name="feat_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_feat"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="give_feat">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Give a Weapon</h3>
				<form method="post" action="giveWeapon.php" id="give_weapon">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Weapon:
						<select name="weapon_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_weapon"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="give_weapon">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Remove a Skill</h3>
				<form method="post" action="removeSkill.php" id="remove_skill">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Skill:
						<select name="skill_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_skill"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="remove_skill">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Remove a Feat</h3>
				<form method="post" action="removeFeat.php" id="remove_feat">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Feat:
						<select name="feat_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_feat"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="remove_feat">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h3>Remove a Weapon</h3>
				<form method="post" action="removeWeapon.php" id="remove_weapon">
					<fieldset>
						Character: 
						<select name="character_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_character"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>

						Weapon:
						<select name="weapon_id">
	
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM dnd_weapon"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $cname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $id . '"> ' . $cname . '</option>\n';
							}
							$stmt->close();
							?>	

						</select>	
						
						<input type="submit" name="remove_weapon">
					</fieldset>
				</form>
			</div>
		</div>

	</body>
</html>