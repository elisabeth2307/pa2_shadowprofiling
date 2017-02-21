<?php

//path for profiles
$pathProfiles = "../profiles/";

// get json from POST as array
$json = json_decode(file_get_contents('php://input'), true);
$id = $json["id"];
$json['time_address'] = time();

// retrieve address information
$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $json['latitude'] . "," . $json['longitude'] ."&sensor=false";

// Make the HTTP request to retrieve address information
$data = @file_get_contents($url);
// Parse the json response
$googledata = json_decode($data,true);
// retrieve address information
$json['street'] = $googledata['results']['0']['address_components']['1']['long_name'] . ' ' . $googledata['results']['0']['address_components']['0']['long_name'];
$json['post'] = $googledata['results']['0']['address_components']['6']['long_name'];
$json['city'] = $googledata['results']['0']['address_components']['2']['long_name'];
$json['country'] = $googledata['results']['0']['address_components']['5']['long_name'];
$json['state'] = $googledata['results']['0']['address_components']['4']['long_name'];


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
