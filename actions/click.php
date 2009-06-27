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
$expansion_type = $_POST['expansion_type'];


$tags_query = json_tags_query_replaced;
$tags_string = $_POST['tags'];

/* from string to JSON */
// echo "stringa contenente i tags : ".$tags_string."<br>";

 
$str_token=strtok($tags_string,"|");
$i = 0;
while($str_token){
 // echo $str_token."<br>";
 $tags_strings[$i] = $str_token;
 $str_token = strtok("|");
 $i++;
}


echo "array di stringhe: <br>";
$j = 0;
$tags = array();

foreach ($tags_strings as $tag_string) {
	// echo "stringa del tag: ".$tag_string."<br>";
	$strtag_token = strtok($tag_string,":");
	// echo "valore: ".$strtag_token."<br>";
	$strtag_value = strtok(":");
	// echo "tag: ".$strtag_value."<br>";
	
	$tags[$j]['tag'] = $strtag_value;
	$tags[$j]['rank'] = $strtag_token;
	$j++;
}



$args = array();

$args['query']=$query;
$args['url']=$url;
//NON converto l'array in JSON
$args['tags'] = $tags;
$args['expansion_type'] = $expansion_type;

if($expandedquery!=$query) {
  $args['expandedquery']=$expandedquery;
  } else {
  $args['expandedquery'] = '';
  }
  
// print_r($args);
//OK!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// print_r($tags);


$result = exec_cmd ('savevisitedurl', $args)


/*
[
{\"tag\":\"encyclopedia\",\"value\":\"4.212\"},
{\"tag\":\"wiki\",\"value\":\"5.346\"},
{\"tag\":\"reference\",\"value\":\"4.05\"}
]

*/

?>
