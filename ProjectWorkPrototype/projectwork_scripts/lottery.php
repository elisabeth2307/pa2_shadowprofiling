<?php
  //path for scripts
  $scriptpath = "/projectworkprototype/projectwork_scripts/";

  // include JS for lottery
  echo "<script src='" . $scriptpath . "js/lottery.js'></script>";

  // create lottery form in div
  echo "<div id='lottery' class='lottery'>";
  // headline
  echo "<hr><h3>Win a -10% voucher!</h3>";
  // description
  echo "<p>Enter your e-mail-address and you will automatically take part in our lottery.<p>";
  // form start
  echo "<form><input type='email' name='email' id='email'>";
  echo "<input id='id_cookie' type='hidden' value='" . $cookieValue . "'>";
  echo "<input type='button' value ='Take part' onClick='takePart()'></form>";
  // form end
  echo "<hr>";
  echo "</div>";

?>
