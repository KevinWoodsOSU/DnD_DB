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
if(!($stmt = $mysqli->prepare("SELECT f.name, f.description, f.prerequisite FROM dnd_feat f
 	INNER JOIN dnd_character_feat cf ON f.id = cf.feat_id 
 	INNER JOIN dnd_character c ON cf.character_id = c.id WHERE c.id = ?"))) {
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

if(!($stmt->bind_result($nameRow, $descriptionRow, $prerequisiteRow))) {
		"bind_result failed: " . $stmt->errno . " " . $stmt->error;
}

//Store all data in one object, and echo as json. Set to null if character has no skills
$myObj = new StdClass;

//store the data from each row as an array using the column identifier
if($numRows > 0) {
	while ($stmt->fetch()) {
		$name[] = $nameRow;
		$description[] = $descriptionRow;
		$prerequisite[] = $prerequisiteRow;
	}

	$myObj->name = $name;
	$myObj->description = $description;
	$myObj->prerequisite = $prerequisite;

	$myJSON = json_encode($myObj);

	echo $myJSON;

} else {
	
	$myJSON = json_encode (new stdClass);
	
	echo $myJSON;
}

?>