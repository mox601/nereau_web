<?php 

//codice per aggiornare le informazioni nel momento del click



//variabili
$url=assicura($_GET['url']);
$query= assicura($_GET['query']);
$url = assicura($_GET['url']);
$expandedquery = assicura($_GET['expandedquery']);
$tags = json_decode($_GET['tags'], true);

var_dump($tags);



$args = array();

$args['query']=$query;
$args['url']=$url;
$args['language']= $_SESSION['language'];

if($expandedquery!=$query) {
  $args['expandedquery']=$expandedquery;
  } else {
  $args['expandedquery'] = '';
  }
  
  $args['tags']=$tags;


//salva il risultato solo se l'utente è autenticato
if ($_SESSION['userid'] != '0') {
$result = exec_cmd ('savevisitedurl', $args);
}


?>

<SCRIPT language="JavaScript">
<!--
window.location="<?php echo $url; ?>";
//-->
</SCRIPT>



