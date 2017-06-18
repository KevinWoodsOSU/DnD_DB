<?php
//Turn on error reporting
ini_set('display_errors', 'On'); 

//Connects to database
$mysqli = new mysqli("classmysql.engr.oregonstate.edu", "cs340_woodske", "9129", "cs340_woodske");
if($mysqli->connect_errno) {
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(!($stmt = $mysqli->prepare("DELETE FROM dnd_character_feat WHERE character_id = ? AND feat_id = ?"))) {
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
//Must match prepare order
if(!($stmt->bind_param("ii", $_POST['character_id'],$_POST['feat_id']))) {
	echo "bind_param failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
} else {
	echo "Removed " . $stmt->affected_rows . " rows to dnd_character_feat.";
}
?>