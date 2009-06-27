<?php 

//codice per aggiornare le informazioni nel momento del click con il redirect

//variabili prese dalla riga del redirect
$url = assicura($_GET['url']);
$query = assicura($_GET['query']);
$url = assicura($_GET['url']);
$expandedquery = assicura($_GET['expandedquery']);
$tags = json_decode($_GET['tags'], true);

$expansion_type = assicura($_GET['expansion_type']);

// non arrivano i tags al nereau server.... perché???
var_dump($tags);

$args = array();

$args['query']=$query;
$args['url']=$url;
$args['language']= $_SESSION['language'];
//
$args['expansion_type'] = $expansion_type;

if($expandedquery!=$query) {
  $args['expandedquery']=$expandedquery;
  } else {
  $args['expandedquery'] = '';
  }
  
$args['tags']=$tags;
//$args['tags']=json_encode($tags);

//salva il risultato solo se l'utente è autenticato
if ($_SESSION['userid'] != '0') {
// $result = exec_cmd ('savevisitedurl', $args);
//ho aggiornato il metodo: accetta anche il TIPO DI QUERY usata per l'espansione
}


?>

<SCRIPT language="JavaScript">
<!--
window.location="<?php echo $url; ?>";
//-->
</SCRIPT>



