<?php
//Turn on error reporting
ini_set('display_errors', 'On'); 

//Connects to database
$mysqli = new mysqli("classmysql.engr.oregonstate.edu", "cs340_woodske", "9129", "cs340_woodske");

if($mysqli->connect_errno) {
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(!($stmt = $mysqli->prepare("UPDATE dnd_character SET level = ?, strength = ?, dexterity = ?, constitution = ?, intelligence = ?, wisdom = ?, charisma = ?, HP = ?, AC = ? WHERE id = ?"))) {
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param('iiiiiiiiii', $_POST['level'],$_POST['strength'],$_POST['dexterity'],$_POST['constitution'],$_POST['intelligence'],$_POST['wisdom'],$_POST['charisma'],$_POST['HP'],$_POST['AC'],$_POST['id']))) {
		echo "bind_param failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->execute())) {
 	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
} else {
	echo "Updated " . $stmt->affected_rows . " rows in dnd_character.";
}
?>