<?php

//path for profiles
$pathProfiles = "../profiles/";

// get ID and email from POST data (sent from lottery.js)
$id = $_POST["id"];
$email = $_POST["email"];

// create filename for shadow profile
$filename = $pathProfiles . $id . ".json";

// create file for case it doesn't exists
$file = fopen($filename, "a");
fclose($file);

// get file content as JSON (true -> return as array; doesn't matter if it is empty)
$json = json_decode(file_get_contents($filename), true);

// store id and email in json structure
$json["id"] = $id;
$json["email"] = $email;

// check for possibility to extract NAME out of email address
// extract everything before @-sign
$name = substr($email, 0, strpos($email, '@'));
// remove numbers and special chars (only letters, hyphen and dots will remain)
$name = preg_replace('/[^A-Za-z\.\-]/', '', $name);

// split string
$pattern = '/[.-]/';
$parts = preg_split($pattern, $name);

// possibility that first part is firstname and last part is lastname is higher (inbetween could be a second firstname)
if(count($parts)>1){
  $json["firstname"] = $parts[0];
  $json["lastname"] = $parts[count($parts)-1];
}

include "jsonfile_handling.php";
