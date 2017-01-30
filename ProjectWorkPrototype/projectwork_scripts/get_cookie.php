<?php
  $app = JFactory::getApplication();
  $cookieValue = null;

  include './prototype_variables.php';

  // check if cookie is not set
   if(!isset($_COOKIE['Prototype'])) {
     // get value of joomla cookie and set an own one
     $cookieValueJoomla = $app->input->cookie->get($joomlaCookie);
     setcookie(
       "Prototype",
       $cookieValueJoomla,
       time() + (10 * 365 * 24 * 60 * 60)
     );
   }

  // set variable for further use
  $cookieValue = $app->input->cookie->get('Prototype');

 ?>
