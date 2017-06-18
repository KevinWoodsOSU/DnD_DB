<?php
//Turn on error reporting
ini_set('display_errors', 'On'); 

//Connects to database
$mysqli = new mysqli("classmysql.engr.oregonstate.edu", "cs340_woodske", "9129", "cs340_woodske");

//Reports error if failed to connect to database
if($mysqli->connect_errno) {
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

//Select all character stats, weapons, skills, and feats
if(!($stmt = $mysqli->prepare("SELECT w.name, w.damage, w.damage_type, w.weapon_type FROM dnd_weapon w
 	INNER JOIN dnd_character_weapon cw ON w.id = cw.weapon_id 
 	INNER JOIN dnd_character c ON cw.character_id = c.id WHERE c.id = ?"))) {
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

//Binds the query condition from the get request
if(!($stmt->bind_param("i", $_GET['id']))) {
	echo "bind_param failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->store_result())) {
	echo "store_result failed: " . $stmt->errno . " " . $stmt->error;
}

$numRows = $stmt->num_rows;

if(!($stmt->bind_result($nameRow, $damageRow, $damage_typeRow, $weapon_typeRow))) {
		"bind_result failed: " . $stmt->errno . " " . $stmt->error;
}

//Store all data in one object, and echo as json. Set to null if character has no skills
$myObj = new StdClass;

//store the data from each row as an array using the column identifier
if($numRows > 0) {
	while ($stmt->fetch()) {
		$name[] = $nameRow;
		$damage[] = $damageRow;
		$damage_type[] = $damage_typeRow;
		$weapon_type[] = $weapon_typeRow;
	}

	$myObj->name = $name;
	$myObj->damage = $damage;
	$myObj->damage_type = $damage_type;
	$myObj->weapon_type = $weapon_type;

	$myJSON = json_encode($myObj);

	echo $myJSON;

} else {
	
	$myJSON = json_encode (new stdClass);
	
	echo $myJSON;
}

?>