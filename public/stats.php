<?php
session_start();
	include "../libchart-1.2.1/libchart/classes/libchart.php";

//inclusione configurazioni
include('../config/vars.php');
include('../config/functions.php');

$dbconn = db_connect();

$width=500;

$result = pg_query($dbconn, "select count (*) AS tot from users;");
$row = pg_fetch_all($result);
$utenti =  $row['0']['tot'];


$result = pg_query($dbconn, "select count(*) as tot from visitedurls where  (expandedquery is not null AND expandedquery <> '');");
$row = pg_fetch_all($result);
$clickexp =  $row['0']['tot'];

$result = pg_query($dbconn, "select count(*) as tot from visitedurls where  (expandedquery = null OR expandedquery = '');");
$row = pg_fetch_all($result);
$clicknotexp =  $row['0']['tot'];

//ultimi 365 giorni
$ora = 1000*(time() - (60*60*24*365));	
$result = pg_query($dbconn, "select count(distinct iduser) as tot from visitedurls where date > " . $ora . ";");
$row = pg_fetch_all($result);
$activeusers =  $row['0']['tot'];



	$chart = new PieChart($width);
	
	$dataSet = new XYDataSet();
  $dataSet->addPoint(new Point("Hits on unexpanded queries results (" . $clicknotexp . ")", $clicknotexp));
	$dataSet->addPoint(new Point("Hits on expanded queries results (" . $clickexp . ")", $clickexp));
	$chart->setDataSet($dataSet);
	$chart->setTitle("Expansion system success");
	$chart->render("../images/generated/demo3.png");
	
	
	
for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));	
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . " AND (expandedquery is not null AND expandedquery <> '');";

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $exp[$i] =  $row['0']['tot'];	
}

for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));	
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . "  AND (expandedquery = null OR expandedquery = '');";

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $notexp[$i] =  $row['0']['tot'];	
}

for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . ";";	

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $totalhits[$i] =  $row['0']['tot'];	
}



		$chart = new LineChart($width);
		
	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("6 day(s) ago", $totalhits[6]));
	$serie1->addPoint(new Point("5 day(s) ago", $totalhits[5]));
	$serie1->addPoint(new Point("4 day(s) ago", $totalhits[4]));
	$serie1->addPoint(new Point("3 day(s) ago", $totalhits[3]));
	$serie1->addPoint(new Point("2 day(s) ago", $totalhits[2]));
	$serie1->addPoint(new Point("1 day(s) ago", $totalhits[1]));	
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("6 day(s) ago", $notexp[6]));
	$serie2->addPoint(new Point("5 day(s) ago", $notexp[5]));
	$serie2->addPoint(new Point("4 day(s) ago", $notexp[4]));
	$serie2->addPoint(new Point("3 day(s) ago", $notexp[3]));
	$serie2->addPoint(new Point("2 day(s) ago", $notexp[2]));
	$serie2->addPoint(new Point("1 day(s) ago", $notexp[1]));	
  
  
  $serie3 = new XYDataSet();
	$serie3->addPoint(new Point("6 day(s) ago", $exp[6]));
	$serie3->addPoint(new Point("5 day(s) ago", $exp[5]));
	$serie3->addPoint(new Point("4 day(s) ago", $exp[4]));
	$serie3->addPoint(new Point("3 day(s) ago", $exp[3]));
	$serie3->addPoint(new Point("2 day(s) ago", $exp[2]));
	$serie3->addPoint(new Point("1 day(s) ago", $exp[1]));
	




	
	$dataSet = new XYSeriesDataSet();
  $dataSet->addSerie("Total hits", $serie1);
	$dataSet->addSerie("Hits on unexpanded queries", $serie2);
	$dataSet->addSerie("Hits on expanded queries", $serie3);

	
	
	$chart->setDataSet($dataSet);

	$chart->setTitle("Success rate in the time");
	$chart->getPlot()->setGraphCaptionRatio(0.62);
	$chart->render("../images/generated/demo6.png");





	$chart = new PieChart($width);

	$dataSet = new XYDataSet();
  $dataSet->addPoint(new Point("Active users (" . $activeusers . ")", $activeusers));
	$dataSet->addPoint(new Point("Inactive users (" . ($utenti - $activeusers) . ")", ($utenti - $activeusers)));
	$chart->setDataSet($dataSet);
	$chart->setTitle("Users activity (latest 365 days)");
	$chart->render("../images/generated/demo4.png");
	
	
	
	
	
	//statistiche sulle votazioni!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	
	//ultimi 365 giorni
  $ora = 1000*(time() - (60*60*24*365));	
  $result = pg_query($dbconn, "select * from votes where date > $ora;");
  $votes = array();
  while ($arr = pg_fetch_array($result)) {
    array_push($votes, $arr['vote']);
  }
  
  $val1 = count(array_keys($votes, "1"));
  $val2 = count(array_keys($votes, "2"));
  $val3 = count(array_keys($votes, "3"));
  $val4 = count(array_keys($votes, "4"));
  $val5 = count(array_keys($votes, "5"));
  
	$chart = new PieChart($width);

	$dataSet = new XYDataSet();
  $dataSet->addPoint(new Point("1 - Inconsistent (" . $val1 . ")", $val1));
	$dataSet->addPoint(new Point("2 - Superfluous (" . $val2 . ")", $val2));
	$dataSet->addPoint(new Point("3 - Lean (" . $val3 . ")", $val3));
	$dataSet->addPoint(new Point("4 - Usefull (" . $val4 . ")", $val4));
	$dataSet->addPoint(new Point("5 - Very usefull (" . $val5 . ")", $val5));
	
	$chart->setDataSet($dataSet);
	$chart->setTitle("Users Ratings (latest 365 days)");
	$chart->render("../images/generated/demo7.png");

  

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Nereau</title> 
<SCRIPT LANGUAGE="JavaScript" SRC="../js/prototype.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="../js/ratingsys.js"></script> 
<link rel="STYLESHEET" type="text/css" href="../css/style.css"> 


</head>
<body>


<a href=../index.php>
<img src=../images/nereaupiccolo.jpg border=0></a> <a href=../index.php><img src=../images/nereaugears.jpg height=39 width=42 border=0>
</a>
<?php
if(isset($_GET['key'])) $key = assicura($_GET['key']);
?>
<form id=search_form method=get action=../?>
  <input class=custominput size=34 type=text name=key <?php if(isset($key)) echo "value=\"" . $key . "\""; ?>> 
  <input type=submit class=custombutton value="go!">

  <br>
  <p style="margin:2px;"><input type=radio name=lang value=en <?php if($_SESSION['language']=='en') echo "checked=checked" ?> > English
  <input type=radio name=lang value=it <?php if($_SESSION['language']=='it') echo "checked=checked" ?> > Italiano</p>
</form>
<div style="margin-left:5px; border-bottom:1px solid #f1c480;text-align:right;">
Statistics for Nereau
</div>
<div style="margin-left:5px; text-align:right;">
<a href=../index.php><< go back</a>
</div>

<br>

<center>
<b>Global usage stats:</b><br>
<br>
<img alt="chart"  src="../images/generated/demo3.png" style="border: 1px solid #f1c480;"/> 
<img alt="chart"  src="../images/generated/demo6.png" style="border: 1px solid #f1c480;"/><br><br>
<img alt="chart"  src="../images/generated/demo4.png" style="border: 1px solid #f1c480;"/> 
<img alt="chart"  src="../images/generated/demo7.png" style="border: 1px solid #f1c480;"/> 













<?php 
if ($_SESSION['userid']!='0') {
?><hr>
<br><br> <b>User stats:</b> <br><br>


<?php
$result = pg_query($dbconn, "select count(*) as tot from visitedurls where  (expandedquery is not null AND expandedquery <> '') AND iduser=" . $_SESSION['userid'] .  ";");
$row = pg_fetch_all($result);
$clickexp =  $row['0']['tot'];

$result = pg_query($dbconn, "select count(*) as tot from visitedurls where  (expandedquery = null OR expandedquery = '') AND iduser=" . $_SESSION['userid'] .  ";");
$row = pg_fetch_all($result);
$clicknotexp =  $row['0']['tot'];

	$chart = new PieChart($width);
	$dataSet = new XYDataSet();
  $dataSet->addPoint(new Point("Hits on unexpanded queries results (" . $clicknotexp . ")", $clicknotexp));
	$dataSet->addPoint(new Point("Hits on expanded queries results (" . $clickexp . ")", $clickexp));
	$chart->setDataSet($dataSet);
	$chart->setTitle("Expansion system success");
	$chart->render("../images/generated/user_" . $_SESSION['userid'] .  "_1.png");

for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));	
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . " AND (expandedquery is not null AND expandedquery <> '') AND iduser=" . $_SESSION['userid'] .  ";";

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $exp[$i] =  $row['0']['tot'];	
}

for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));	
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . "  AND (expandedquery = null OR expandedquery = '') AND iduser=" . $_SESSION['userid'] .  ";";

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $notexp[$i] =  $row['0']['tot'];	
}

for ($i=1;$i<7;$i++) {	
    $ora1 = 1000*(time() - (60*60*24*$i));
    $ora2 = 1000*(time() - (60*60*24*($i-1)));
    $string = "select count(*) as tot from visitedurls where date > " . $ora1 . " AND date < " . $ora2 . " AND iduser=" . $_SESSION['userid'] .  ";";	

    $result = pg_query($dbconn, $string);
    $row = pg_fetch_all($result);
    $totalhits[$i] =  $row['0']['tot'];	
}



		$chart = new LineChart($width);
		
	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("6 day(s) ago", $totalhits[6]));
	$serie1->addPoint(new Point("5 day(s) ago", $totalhits[5]));
	$serie1->addPoint(new Point("4 day(s) ago", $totalhits[4]));
	$serie1->addPoint(new Point("3 day(s) ago", $totalhits[3]));
	$serie1->addPoint(new Point("2 day(s) ago", $totalhits[2]));
	$serie1->addPoint(new Point("1 day(s) ago", $totalhits[1]));	
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("6 day(s) ago", $notexp[6]));
	$serie2->addPoint(new Point("5 day(s) ago", $notexp[5]));
	$serie2->addPoint(new Point("4 day(s) ago", $notexp[4]));
	$serie2->addPoint(new Point("3 day(s) ago", $notexp[3]));
	$serie2->addPoint(new Point("2 day(s) ago", $notexp[2]));
	$serie2->addPoint(new Point("1 day(s) ago", $notexp[1]));	
  
  
  $serie3 = new XYDataSet();
	$serie3->addPoint(new Point("6 day(s) ago", $exp[6]));
	$serie3->addPoint(new Point("5 day(s) ago", $exp[5]));
	$serie3->addPoint(new Point("4 day(s) ago", $exp[4]));
	$serie3->addPoint(new Point("3 day(s) ago", $exp[3]));
	$serie3->addPoint(new Point("2 day(s) ago", $exp[2]));
	$serie3->addPoint(new Point("1 day(s) ago", $exp[1]));
	




	
	$dataSet = new XYSeriesDataSet();
  $dataSet->addSerie("Total hits", $serie1);
	$dataSet->addSerie("Hits on unexpanded queries", $serie2);
	$dataSet->addSerie("Hits on expanded queries", $serie3);

	
	
	$chart->setDataSet($dataSet);

	$chart->setTitle("Success rate in the time");
	$chart->getPlot()->setGraphCaptionRatio(0.62);
	$chart->render("../images/generated/user_" . $_SESSION['userid'] .  "_2.png");
	
	
	//statistiche sulle votazioni!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	
	//ultimi 365 giorni
  $ora = 1000*(time() - (60*60*24*365));	
  $result = pg_query($dbconn, "select * from votes where date > $ora AND iduser = " . $_SESSION['userid']  . ";");
  $votes = array();
  while ($arr = pg_fetch_array($result)) {
    array_push($votes, $arr['vote']);
  }
  
  $val1 = count(array_keys($votes, "1"));
  $val2 = count(array_keys($votes, "2"));
  $val3 = count(array_keys($votes, "3"));
  $val4 = count(array_keys($votes, "4"));
  $val5 = count(array_keys($votes, "5"));
  
	$chart = new PieChart($width);

	$dataSet = new XYDataSet();
  $dataSet->addPoint(new Point("1 - Inconsistent (" . $val1 . ")", $val1));
	$dataSet->addPoint(new Point("2 - Superfluous (" . $val2 . ")", $val2));
	$dataSet->addPoint(new Point("3 - Lean (" . $val3 . ")", $val3));
	$dataSet->addPoint(new Point("4 - Usefull (" . $val4 . ")", $val4));
	$dataSet->addPoint(new Point("5 - Very usefull (" . $val5 . ")", $val5));
	
	$chart->setDataSet($dataSet);
	$chart->setTitle("User Ratings (latest 365 days)");
	$chart->render("../images/generated/ratings_user" . $_SESSION['userid'] . ".png");	
	
	
	
	
?>


<img alt="chart"  src="../images/generated/user_<?php echo $_SESSION['userid']; ?>_1.png" style="border: 1px solid #f1c480;"/> 
<img alt="chart"  src="../images/generated/user_<?php echo $_SESSION['userid']; ?>_2.png" style="border: 1px solid #f1c480;"/><br><br>
<img alt="chart"  src="../images/generated/ratings_user<?php echo $_SESSION['userid']; ?>.png" style="border: 1px solid #f1c480;"/><br><br>






<?php } ?>
















</center>

</body>
</html>
