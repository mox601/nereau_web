<a href=index.php>
<img src=images/nereaupiccolo.jpg border=0>  <img src=images/nereaugears.jpg height=39 width=42 border=0>
</a>
<?php
if(isset($_GET['key'])) $key = assicura($_GET['key']);
?>
<div style="margin-left:5px;">
  <?php
  include("modules/search_form.php");
 ?>
</div>



<?php 

$dbconn = db_connect();



$result = pg_query($dbconn, "select count (*) AS tot from users;");
$row = pg_fetch_all($result);
$utenti =  $row['0']['tot'];

$ora = (time() - (60*60*24));

$result = pg_query($dbconn, "select count(*) as tot from visitedurls where date > " . $ora . ";");
$row = pg_fetch_all($result);
$numquery =  $row['0']['tot'];


$result = pg_query($dbconn, "select count(*) as tot from visitedurls where date > " . $ora . " AND (expandedquery is not null AND expandedquery <> '');");
$row = pg_fetch_all($result);
$clickexp =  $row['0']['tot'];


$result = pg_query($dbconn, "select count(*) as tot from visitedurls where date > " . $ora . " AND (expandedquery = null OR expandedquery = '');");
$row = pg_fetch_all($result);
$clicknotexp =  $row['0']['tot'];




?>
<br>
<table align=center style="border:1px solid black;">
<tr><td align=right>Utenti registrati</td><td align=left><?php echo $utenti; ?></td></tr>
<tr><td align=right>Query eseguite nelle ultime 24h</td><td align=left><?php echo $numquery?></td></tr>
<tr><td align=right>Percentuale di click su risultati provenienti da query espanse</td><td align=left><?php echo $clickexp?></td></tr>
<tr><td align=right>Percentuale di click su risultati provenienti da query non espanse</td><td align=left><?php echo $clicknotexp?></td></tr>
<tr><td align=right>Indice di gradimento medio</td><td align=left></td></tr>
<tr><td align=right></td><td align=left></td></tr>
</table>
<br>

