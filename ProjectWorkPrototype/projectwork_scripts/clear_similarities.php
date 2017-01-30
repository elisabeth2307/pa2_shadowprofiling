<?php
  $files = scandir("../profiles");

  // filter shadow profiles -> remove other files
  foreach($files as $key => $value){
    // if file is no shadow profile -> unset
    if(substr($value, 0, 1) == '.') {
      unset($files[$key]);
    } else {
      $filename = '../profiles/' . $value;
      $fileContent = json_decode(file_get_contents($filename), true);
      unset($fileContent['similarities']);
      // store JSON structure in file
      file_put_contents($filename, json_encode($fileContent));
    }
  }

  echo "<h1>All similarities deleted from shadow profiles! </h1>";
?>
