<?php
  session_start();
  include('../config/vars.php');
  global $domainalias;
  
  //disabilito temporaneamente l'autologin
  setcookie ("autologin", "false", time()+60*60*24*30, "/", "." . $domainalias);
  

  include('../config/functions.php');

?>Logging out.. 
<br><img src=images/loading.gif>
<?php
  logout($_SESSION['userid']);
?>
