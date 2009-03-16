<?php
session_start();
include('../config/vars.php');

global $domainalias;

if (isset($_POST['autologincheck']) && $_POST['autologincheck']=='true') {
  setcookie ("autologin", "true", time()+60*60*24*30, "/", "." . $domainalias);
  setcookie ("cookieusername", $_POST['username'], time()+60*60*24*30, "/", "." . $domainalias);
  setcookie ("cookiepassword", $_POST['password'], time()+60*60*24*30, "/", "." . $domainalias);
} else {
  setcookie ("autologin", "false", time()+60*60*24*30, "/", ".eunetwork.net");
}
include('../config/functions.php');

?>
Logging in..
<br><img src=images/loading.gif>
<?php

$username = assicura($_POST['username']);
$password = assicura($_POST['password']);;

auth($username, $password);



?>
