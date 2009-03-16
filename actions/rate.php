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
insertRate($userid, $query, $expandedquery, $tags, $vote )

?>
