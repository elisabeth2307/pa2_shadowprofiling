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

              $returnvalue = addSimilarities($fileContent, $fileContentTemp, $value, $valueInner, '100');
              $fileContent = $returnvalue['fileContent'];
              $fileContentTemp = $returnvalue['fileContentTemp'];
              echo "<li> Email address equal </li>";

        }

        // if name is equal
        if(!empty($fileContent['firstname']) && !empty($fileContentTemp['firstname']) &&
            !empty($fileContent['lastname']) && !empty($fileContentTemp['lastname']) &&
            $fileContent['firstname'] == $fileContentTemp['firstname'] &&
            $fileContent['lastname'] == $fileContentTemp['lastname']){

              $returnvalue = addSimilarities($fileContent, $fileContentTemp, $value, $valueInner, '20');
              $fileContent = $returnvalue['fileContent'];
              $fileContentTemp = $returnvalue['fileContentTemp'];
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

            $returnvalue = addSimilarities($fileContent, $fileContentTemp, $value, $valueInner, $probabilityCalculated);
            $fileContent = $returnvalue['fileContent'];
            $fileContentTemp = $returnvalue['fileContentTemp'];
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


function addSimilarities($fileContent, $fileContentTemp, $value, $valueInner, $probability){

  // add found profile into current one
  // if no similarities are stored at all
  if(empty($fileContent['similarities'])){
    $fileContent['similarities'][$valueInner]['probability'] = $probability;
  }
  // if value is already saved -> change probability
  else if (!empty($fileContent['similarities'][$valueInner]['probability'])) {
    $fileContent['similarities'][$valueInner]['probability'] = $fileContent['similarities'][$valueInner]['probability'] + $probability;
  }
  // if value itself is not saved but other values are stored
  else {
    $fileContent['similarities'] = array_merge($fileContent['similarities'], array($valueInner => array('probability' => $probability)));
  }

  // if no similarities are stored at all
  // add found profile into temp one
  if(empty($fileContentTemp['similarities'])){
    $fileContentTemp['similarities'][$value]['probability'] = $probability;
  }
  // if value is already saved -> change probability
  else if (!empty($fileContentTemp['similarities'][$value]['probability'])) {
    $fileContentTemp['similarities'][$value]['probability'] = $fileContentTemp['similarities'][$value]['probability'] + $probability;
  }
  // if value itself is not saved but other values are stored
  else {
    $fileContentTemp['similarities'] = array_merge($fileContentTemp['similarities'], array($value => array('probability' => $probability)));
  }

  // if probability is 100 e.g. email address is same -> set flag that it is confirmed
  if($probability == 100){
    $fileContent['similarities'][$valueInner]['confirmed'] = 1;
    $fileContentTemp['similarities'][$value]['confirmed'] = 1;
  }

  // prepare array for returning values
  $returnValue['fileContent'] = $fileContent;
  $returnValue['fileContentTemp'] = $fileContentTemp;

  return $returnValue;
}


 ?>
