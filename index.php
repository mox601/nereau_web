<?php
//inizializzazione  sessione
session_start();

if(!isset($_SESSION['userid'])) {
  $_SESSION['userid'] = '0';
} 
if(!isset($_SESSION['username'])) {
  $_SESSION['username'] = '';
} 
if(!isset($_SESSION['firstname'])) {
  $_SESSION['firstname'] = '';
} 

if(!isset($_SESSION['lastname'])) {
  $_SESSION['lastname'] = '';
} 

if(!isset($_SESSION['email'])) {
  $_SESSION['email'] = '';
} 

if(!isset($_SESSION['role'])) {
  $_SESSION['role'] = '0';
} 


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="http://nereau.eunetwork.net/images/nereaugears.jpg" >
<title>Nereau</title> 
<SCRIPT LANGUAGE="JavaScript" SRC="js/prototype.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="js/ratingsys.js"></script>
<script type="text/javascript" language="javascript" src="js/functions.js"></script>  
<link rel="STYLESHEET" type="text/css" href="css/style.css"> 


</head>
<body>
<?php
//inclusione configurazioni
include('config/vars.php');
include('config/functions.php');

//Se impostato il parametro lang (ad esempio in una query) cambia la lingua
if (isset($_GET['lang'])) {
  $lang = assicura($_GET['lang']);
  if($lang=='it') $_SESSION['language'] = 'it';
  if ($lang=='en') $_SESSION['language'] = 'en';

}
//lingua di default: inglese
if(!isset($_SESSION['language'])) {
  $_SESSION['language'] = 'en';
} 

//se l'utente non è identificato...
if($_SESSION['userid'] == '0') {   

  //...e se è impostato, effettua l'autologin
  if (isset($_COOKIE['autologin']) && isset($_COOKIE['cookieusername']) && isset($_COOKIE['cookiepassword']) && $_COOKIE['autologin']=='true' )
  {
    auth($_COOKIE['cookieusername'],$_COOKIE['cookiepassword']);
  }
}

?>

<div align=center id=messageboard>
  <div id=error style="display:none;"></div>
  <div id="actions"></div>
</div>



<div id=controlpanel>
        <?php 
        
        
        echo "<div id=debugger>";   
        
            if($_SESSION['userid'] == '0') {
                    include('modules/login_form.php');
                
            } else {
                echo "Hello " . $_SESSION['username'] . "! Language: " . $_SESSION['language'] . "<br>";
                include('modules/menu.php');
                echo "<br>";
                include('modules/logout_form.php');
                
            }
        
        echo "</div>";
        ?>
        
</div>

<?php

//inclusione pagina
if(isset($_GET['key']) AND $_GET['key']!='') {
$content= "result";
} else {
    if(!isset($_GET['content'])) {
      $content= "home";
    } else {
      $content = $_GET['content'];
    }
}
include("contents/" . $content . ".php");
?>

<p align=center id="footer"><a href=http://www.uniroma3.it target=_blank>Roma Tre University</a> | <a href=?content=nereau>About Nereau</a> | powered by <img align=top src="http://www.google.com/uds/css/small-logo.png"></p>

<!-- carico preventivamente immagini utili -->
<img src=images/loading.gif height=0 width=0>
<img src=images/star_on.gif height=0 width=0>
<img src=images/star_off.gif height=0 width=0>
</body>
</html>
