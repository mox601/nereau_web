<?php 
session_start();

include("../config/functions.php");
//recupero i dati

//start point per la navigazione tra le pagine di risultati
(isset($_GET['start']) AND $_GET['start']>0)?$start=assicura($_GET['start']):$start=0;
//la query originale e quella espansa.. utile per salvare informazioni dopo il click su un risultato
$expandedquery = assicura($_GET['expandedquery']);
$expandedqueryescaped = str_replace(" ", "%20", $expandedquery);
$originalquery = assicura($_GET['originalquery']);
//il numero di riferimento del div contenente i risultati, utile per aprire la pagina successiva o precedente sempre nello stesso div
//riceve il tipo di espansione dalla get del click sulla tab laterale - ajax
$expansion_type = assicura($_GET['expansion_type']);


isset($_GET['numerodiv'])?$numerodiv=assicura($_GET['numerodiv']):$numerodiv="";
//aprire i link in una nuova pagina oppure no? dipende dal cookie!
if (isset($_COOKIE['tab']) && $_COOKIE['tab'] == 'on') { $tab = true;} else {$tab=false;}

//recupero i tags
$tags = $_GET['tag'];
//query a google
$size='large';
$googlequery = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&hl=" . $_SESSION['language'] . "&start=" . $start . "&rsz=" . $size . "&hl=it&lstkp=45&q=" . $expandedqueryescaped;

//NEW lettura json, si era rotto perche la risposta era su piú linee... 
$handle = fopen($googlequery, "rb");
$string = stream_get_contents($handle);
fclose($handle);


// OLD ricevo il risultato della query a google
//$string = fgets(fopen($googlequery, "r")); 
//salva il risultato json in un array associativo
//utf8 codifica
$obj = json_decode($string, true);

?>

<table height=45 width=100% border=0>
<tr>
  <td align=left valign=top>
  <?php echo "<b>" . number_format($obj["responseData"]["cursor"]["estimatedResultCount"]) . "</b> results found. <a href=# onclick=\"$('query" . $numerodiv . "').toggle();\"> View / hide query</a><br><span style=\"display:none; font-size:80%;\" id=query" . $numerodiv . ">Query: <b>" . $expandedquery . "</b></span> ";
  
  
  /* //debug per JSON
	echo "<p>richiesta a google: " . var_dump($googlequery) . "</p>";
	echo "<p>stringa json di google per la query: " . var_dump($string) . "</p>";
	echo "<p>oggetto json di google di json_decode: " . var_dump($obj) . "</p>";
  */
	

//	echo "<p>risultati: " . $obj["responseData"];


//debug per il tipo di espansione
//	echo "expansion used: ". $expansion_type;
  
  ?>
  </td>
  
  <?php
  //se la query  è stata espansa (numerodiv diverso da '')..
  if ($numerodiv != '') {
  //includi il sistema di rating

	/* qui posso includere il tipo di espansione usata: 
	mi salvo nella sessione l'indice dell'array dei risultati dove è presente 
	il PRIMO risultato del clustering: quando il numerodiv è >= di quell'indice, 
	allora il tipo di espansione è 3, 4, 5, etc etc... 
	NO. 
	più semplice: 
	ho il tipo di espansione nel parametro expansion_type. 
	è visibile? 
	*/

  ?>
  <td valign=top align=right width=350>
<script type="text/javascript" language="javascript" src="js/ratingsys.js"></script>
  
      <span id="<?php echo $numerodiv?>_rateStatus">Rate this expansion!</span>
      <span id="<?php echo $numerodiv?>_ratingSaved" class="ratingSaved">This expansion has been rated</span> 
      
      <div id="rateMe" title="Rate this expansion!">
          <!--  tramite la funzione rateIt, definita in ratingsys.js salvo le informazioni sulla votazione  -->

	
	<!-- OLD RATING SYSTEM, WITHOUT EXPANSION TYPE -->
	<!--
          <a onclick="rateIt(this, <?php echo $numerodiv?>, true, 1, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>')" id="<?php echo $numerodiv?>_1" title="Inconsistent" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>
          <a onclick="rateIt(this, <?php echo $numerodiv?>, true, 2, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>')" id="<?php echo $numerodiv?>_2" title="Superfluous" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>
          <a onclick="rateIt(this, <?php echo $numerodiv?>, true, 3, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>')" id="<?php echo $numerodiv?>_3" title="Lean" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>
          <a onclick="rateIt(this, <?php echo $numerodiv?>, true, 4, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>')" id="<?php echo $numerodiv?>_4" title="Useful" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>
          <a onclick="rateIt(this, <?php echo $numerodiv?>, true, 5, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>')" id="<?php echo $numerodiv?>_5" title="Very useful" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

-->

<!-- cambio la funzione, ora chiama 
	rateItExpansion(me, group, to_send_boolean, val, query, expandedquery, tags, expansiontype) -->


	<!-- NEW RATING SYSTEM, WITH EXPANSION TYPE -->

<a onclick="rateItExpansion(this, <?php echo $numerodiv?>, true, 1, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>', '<?php echo $expansion_type; ?>')" id="<?php echo $numerodiv?>_1" title="Inconsistent" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

<a onclick="rateItExpansion(this, <?php echo $numerodiv?>, true, 2, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>', '<?php echo $expansion_type; ?>')" id="<?php echo $numerodiv?>_2" title="Superfluous" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

<a onclick="rateItExpansion(this, <?php echo $numerodiv?>, true, 3, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>', '<?php echo $expansion_type; ?>')" id="<?php echo $numerodiv?>_3" title="Lean" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

<a onclick="rateItExpansion(this, <?php echo $numerodiv?>, true, 4, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>', '<?php echo $expansion_type; ?>')" id="<?php echo $numerodiv?>_4" title="Useful" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

<a onclick="rateItExpansion(this, <?php echo $numerodiv?>, true, 5, '<?php echo $originalquery; ?>', '<?php echo $expandedquery; ?>', '<?php echo $tags; ?>', '<?php echo $expansion_type; ?>')" id="<?php echo $numerodiv?>_5" title="Very useful" onmouseover="rating(this, <?php echo $numerodiv?>)" onmouseout="off(this, <?php echo $numerodiv?>)"></a>

<!-- END RATING SYSTEM -->

        
      </div>    
    
    
    
      <SCRIPT LANGUAGE="JavaScript">
      //se è gia stata espressa una preferenza...
      if(preSet[<?php echo $numerodiv?>]) {
      
        id = preSet[<?php echo $numerodiv?>].id;
        
        preSet[<?php echo $numerodiv?>] = null;
        rated[<?php echo $numerodiv?>] = false;
        
        //setta di nuovo il sistema di rating sul valore impostato ma senza reinviare i dati
        target = document.getElementById(id);
        rating(target, <?php echo $numerodiv?>);
        rateIt(target, <?php echo $numerodiv?>, false);        
      }
      </SCRIPT>  

      
      
  <?php } else {
  echo "
  <td valign=top align=right>
  <img src=images/warning.jpg width=21 height=20 align=top> Simple result set provided by Google
  </td>";
  } ?>
</tr>
</table>


<br>
<?php

$risultati = $obj["responseData"]["results"];

for($i=0; $i<sizeof($risultati);$i++) {
  ?>

<!--
	non trova i jsontags??
	http://localhost:8888/nereau/index.php?content=redirect&url=http://www.msu.edu/user/schurerj/sounds.htm&query=jimmy&expandedquery=jimmy%20AND%20wav&tags=            &expansion_type=co-occurrences
	
	-->
	
	<?php
	
	$jsontags = $tags;
	
	echo "tags associati all'insieme di risultati e al link".$tags;
	echo "ripetuti".$jsontags;
	
	?>

<!-- nel link includo anche il tipo di espansione usata -->
  <a <?php if($tab) echo " target=_blank " ?> href="?content=redirect&url=<?php echo $risultati[$i]["url"];?>&query=<?php echo $originalquery;?>&expandedquery=<?php echo $expandedquery?>&tags=<?php echo($jsontags);?>&expansion_type=<?php echo $expansion_type;?>">
	 <!-- ho levato json da tags, ma devo comunque tenerlo encoded-->
  
  <!--  Decommentare per non usare il redirect e inserire l'handler nel tag <a> precedente al posto dei parametri get
  onclick="
  new Ajax.Updater('actions', 'actions/click.php', {
              onSuccess: function(transport) {
              setTimeout(window.location.href='<?php echo $risultati[$i]["url"];?>', 500);
              },
              parameters: {
                query:'<?php echo $originalquery;?>',
                url:'<?php echo $risultati[$i]["url"];?>',
                expandedquery:'<?php echo $expandedquery?>',
                tags:'<?php echo $tags;?>'
                
                } , method:'post'});
              

  "
  -->
  <?php
  echo "" . $risultati[$i]["title"] . "</a><br>";
  echo "<div style=\"margin-left:8px;\">" . $risultati[$i]["content"] . "</div>";
  echo "<div style=\"margin-left:8px; font-size:80%;\"><i>" . $risultati[$i]["unescapedUrl"] . "</i></div><br>";

}
?>
<table align= center>
<tr>
  <td><a class=pagenumber href=# onclick="
            document.getElementById('result<?php echo $numerodiv; ?>').innerHTML = '<center>Loading..<br><img src=images/loading.gif><br><br><br><br></center>';
            new Ajax.Updater('result<?php echo $numerodiv; ?>', 
            'actions/result_parse.php', { method: 'get',parameters: {start:'<?php echo ($start - 8); ?>', numerodiv:'<?php echo $numerodiv; ?>', expandedquery: '<?php echo $expandedquery; ?>', originalquery:'<?php echo $$originalquery; ?>'},
            evalScripts:true});
        "> << Previous </a></td>
  <td>

  <?php 
  $page=$start/8 + 1;

  for($n=8;$n>=0;$n--) {
    //mostra 8 numeri pagine a partire da pagina corrente - 4, se maggiore di zero, fino ad arrivare massimo a pagina 8 (limite imposto da google)
    if($page-$n+4>0 && $page-$n+4<=8) {
      
    ?>
    <a class=pagenumber href=# onclick="
            document.getElementById('result<?php echo $numerodiv; ?>').innerHTML = '<center>Loading..<br><img src=images/loading.gif><br><br><br><br></center>';
            new Ajax.Updater('result<?php echo $numerodiv; ?>', 
            'actions/result_parse.php', { method: 'get',parameters: {start:'<?php echo (($page-$n+3)*8); ?>', numerodiv:'<?php echo $numerodiv; ?>', expandedquery: '<?php echo $expandedquery; ?>', originalquery:'<?php echo $$originalquery; ?>'},
            evalScripts:true});
        "><?php 
        if (($page-$n+4)==$page) {
          echo "<b>" . ($page-$n+4) . "</b>";
        }
         else 
         { echo ($page-$n+4);
         }?></a>&nbsp;
         
         
    <?php 
    }
  }
    
    
   ?>
  
  </td>
  <td> <a class=pagenumber href=# onclick="
            document.getElementById('result<?php echo $numerodiv; ?>').innerHTML = '<center>Loading..<br><img src=images/loading.gif><br><br><br><br></center>';
            new Ajax.Updater('result<?php echo $numerodiv; ?>', 
            'actions/result_parse.php', { method: 'get',parameters: {start:'<?php echo ($start + 8); ?>', numerodiv:'<?php echo $numerodiv; ?>', expandedquery: '<?php echo $expandedquery; ?>', originalquery:'<?php echo $$originalquery; ?>'},
            evalScripts:true});
        ">Next >> </a></td>
</tr>
</table>


