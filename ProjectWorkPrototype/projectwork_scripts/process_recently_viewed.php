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
// retrieve existing recently viewed items as array if possible
if(!empty($json["recently_viewed"])){
  $jsonExisting = $json["recently_viewed"];
  // merge arrays for storing if not empty
  $jsonPost = array_merge($jsonPost, $jsonExisting);
}

// check for amount of current products and correct if necessary
if(count($jsonPost)>10){
  for($i = 0; $i<count($jsonPost)-10; $i++){
    // last items in array will be deleted
    array_pop($jsonPost);
  }
}
// store in array for writing to file
$json["recently_viewed"] = $jsonPost;


// include timestamps and storing
include "jsonfile_handling.php";


 ?>
