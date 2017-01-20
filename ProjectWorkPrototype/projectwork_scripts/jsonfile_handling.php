<?php
// add timestamps for first access and last access
if (empty($json["first_access"])) {
  $json["first_access"] = time();
}
$json["last_access"] = time();

// store JSON structure in file
file_put_contents($filename, json_encode($json));


 ?>
