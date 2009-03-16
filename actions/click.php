<?php
session_start();
include('../config/vars.php');
include('../config/functions.php');
?>

Aggiornamento informazioni

<?php
//variabili

$query= $_POST['query'];
$url = $_POST['url'];
$expandedquery = $_POST['expandedquery'];
$tags = '';




$args = array();

$args['query']=$query;
$args['url']=$url;
if($expandedquery!=$query) {
  $args['expandedquery']=$expandedquery;
  } else {
  $args['expandedquery'] = '';
  }
  
  $args['tags']=$tags;



$result = exec_cmd ('savevisitedurl', $args)




?>
