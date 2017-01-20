<?php
//path for profiles
$pathProfiles = "../profiles/";

// get json from POST as array
$jsonPost = json_decode(file_get_contents('php://input'), true);
$id = $jsonPost["id"];
// delete entry because it is not needed anymore
unset($jsonPost["id"]);

// make sure file exists
$filename = $pathProfiles . $id . ".json";
$file = fopen($filename, "a");
fclose($file);

// get existing json structure from file as array
$json = json_decode(file_get_contents($filename), true);
// store recently viewed items as array in array-position
$json["recently_viewed"] = $jsonPost;


// include timestamps and storing
include "jsonfile_handling.php";


 ?>
