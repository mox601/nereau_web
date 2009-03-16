<?php
  session_start();
  include('../config/vars.php');
  include('../config/functions.php');
  
  $password1 = assicura($_POST['save_password1']);
  $password2 = assicura($_POST['save_password2']);
  

  if ($password1 != $password2) {
    echo "Error: Confirm password doesn't match";
  } else {
    $args = array();
    $args['username'] = assicura($_POST['save_username']);
    $args['email'] = assicura($_POST['save_email']);
    $args['nome'] = assicura($_POST['save_firstname']);
    $args['cognome'] = assicura($_POST['save_lastname']);
    $args['password'] = $password1;  
    $result = exec_cmd('saveuser', $args);
  }
  


?>

Saving user...
<br><img src=images/loading.gif>
