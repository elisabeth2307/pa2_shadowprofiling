<?php

//path for profiles
$pathProfiles = "../profiles/";

// get json from POST as array
$json = json_decode(file_get_contents('php://input'), true);
$id = $json["id"];

// make sure file exists
$filename = $pathProfiles . $id . ".json";
$file = fopen($filename, "a");
fclose($file);

// get existing json structure from file as array
$jsonFile = json_decode(file_get_contents($filename), true);

// merge arrays for storing
if(!empty($jsonFile)){
  $json = array_merge($json, $jsonFile);
}

// include timestamps and storing
include "jsonfile_handling.php";


?>
