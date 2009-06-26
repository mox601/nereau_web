<? 
session_start();
include('../config/vars.php');
include('../config/functions.php');

$dbconn = db_connect();

$userid = $_SESSION['userid'];
$query = assicura($_POST['query']);
$expandedquery = assicura($_POST['expandedquery']);
$tags = $_POST['tags'];
$vote = assicura($_POST['vote']);
$expansion_type = assicura($_POST['expansion_type']);

//old
//insertRate($userid, $query, $expandedquery, $tags, $vote )
//ho bisogno di un altro parametro nella POST: 
//il tipo di espansione generata
insertRateExpansion($userid, $query, $expandedquery, $tags, $vote, $expansion_type )

?>
