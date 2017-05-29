<?php
//Turn on error reporting
ini_set('display_errors', 'On'); 

//Connects to database
$mysqli = new mysqli("classmysql.engr.oregonstate.edu", "cs340_woodske", "9129", "cs340_woodske");

//Reports error if failed to connect to database
if($mysqli->connect_errno) {
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(!($stmt = $mysqli->prepare("SELECT strength, dexterity, constitution, intelligence, wisdom, charisma, hp, ac FROM dnd_character WHERE id = ?"))) {
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("i", $_GET['id']))) {
	echo "bind_param failed: " . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}

//Takes results of query and sticks them in variables
if(!($stmt->bind_result($str, $dex, $con, $int, $wis, $cha, $hp, $ac))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

$myObj = new StdClass;

while($stmt->fetch()){

$myObj->str = $str;
$myObj->dex = $dex;
$myObj->con = $con;
$myObj->int = $int;
$myObj->wis = $wis;
$myObj->cha = $cha;
$myObj->hp = $hp;
$myObj->curr = $ac;

$myJSON = json_encode($myObj);

echo $myJSON;

}



?>

