<?php
  $app = JFactory::getApplication();
  $cookieValue = null;

  // check if cookie is not set
   if(!isset($_COOKIE['Prototype'])) {
     // get value of joomla cookie and set an own one
     $cookieValueJoomla = $app->input->cookie->get('5954872f5836ba36117eac10a7c8bd93');
     setcookie(
       "Prototype",
       $cookieValueJoomla,
       time() + (10 * 365 * 24 * 60 * 60)
     );
   }

  // set variable for further use
  $cookieValue = $app->input->cookie->get('Prototype');

 ?>
