<?php
  $files = scandir("../profiles");
  $checkedFiles = [];
  include "../prototype_variables.php";


  // filter shadow profiles -> remove other files
  foreach($files as $key => $value){
    // if file is no shadow profile -> unset
    if(substr($value, 0, 1) == '.') {
      unset($files[$key]);
    }
  }

  // $files holds only shadow profiles now
  foreach($files as $value){
    //get existing json structure from file as array
    $filename = '../profiles/' . $value;
    $fileContent = json_decode(file_get_contents($filename), true);

    echo "<h2>Check file " . $value . " for similarities</h2>";

    // iterate through all files and check for similarities
    foreach($files as $valueInner){

      // if it is not the same file and file has not been checked before
      if($value != $valueInner && empty($checkedFiles[$value]) && empty($checkedFiles[$valueInner])) {

        echo "<p>Current file to compare: " . $valueInner;

        $filenameTemp = '../profiles/' . $valueInner;
        $fileContentTemp = json_decode(file_get_contents($filenameTemp), true);

        // if email address is equal
        if (!empty($fileContent['email']) && !empty($fileContentTemp['email']) &&
            $fileContent['email'] == $fileContentTemp['email']){
              $probability = '100';
              $fileContent = setSimilarities($fileContent, $valueInner, $probability);
              $fileContentTemp = setSimilarities($fileContentTemp, $value, $probability);
              echo "<li> Email address equal </li>";

        }

        // if name is equal
        if(!empty($fileContent['firstname']) && !empty($fileContentTemp['firstname']) &&
            !empty($fileContent['lastname']) && !empty($fileContentTemp['lastname']) &&
            $fileContent['firstname'] == $fileContentTemp['firstname'] &&
            $fileContent['lastname'] == $fileContentTemp['lastname']){

              $fileContent = setSimilarities($fileContent, $valueInner, $probabilityNameEqual);
              $fileContentTemp = setSimilarities($fileContentTemp, $value, $probabilityNameEqual);
              echo "<li> Name equal </li>";
        }

        // check for similar products
        if(!empty($fileContent['recently_viewed']) && !empty($fileContentTemp['recently_viewed'])){
          // calculate amount of products of both profiles
          $productCount = count($fileContent['recently_viewed']) + count($fileContentTemp['recently_viewed']);
          // merge arrays to remove duplicates
          $noDuplicates = array_merge($fileContent['recently_viewed'], $fileContentTemp['recently_viewed']);

          // duplicates found which means that same products were viewed
          if($productCount > count($noDuplicates)){
            // calculate the probability that it is the same user
            $productsSimilar = $productCount - count($noDuplicates);
            $probabilityCalculated = round(100 * $productsSimilar / $productCount);

            echo "<li> Similar products </li>";
          }

        }

        // save temp file
        file_put_contents($filenameTemp, json_encode($fileContentTemp));
      }

    }
    // save file
    file_put_contents($filename, json_encode($fileContent));
    $checkedFiles[$value] = $value;
  }

  echo "<h1> --- All files done! --- </h1>";


function setSimilarities($file, $value, $probability){
  // add found profile into temp one
  // if no similarities are stored at all
  if(empty($file['similarities'])){
    $file['similarities'][$value]['probability'] = $probability;
  }
  // if value is already saved -> change probability
  else if (!empty($file['similarities'][$value]['probability'])) {
    $file['similarities'][$value]['probability'] = $file['similarities'][$value]['probability'] + $probability;
  }
  // if value itself is not saved but other values are stored
  else {
    $file['similarities'] = array_merge($file['similarities'], array($value => array('probability' => $probability)));
  }

  // if probability is 100 e.g. email address is same -> set flag that it is confirmed
  if($probability == 100){
    $file['similarities'][$value]['confirmed'] = 1;
  }

  return $file;
}


 ?>
