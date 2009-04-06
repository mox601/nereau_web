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

<? 
echo "<p style=\"margin:5px;\">You wrote: <b>" . $key;

echo "</b> ";

//esecuzione comando di espansione in funzione della variabile key
$args = array();
$args['query']=$key;
$args['language']=$_SESSION['language'];

$espansione = exec_cmd ('expand', $args);
$espansione_tfidf = exec_cmd ('expand_tfidf', $args);
//espansione con co-occorrenze tag tag
$espansione_coocc = exec_cmd ('expand_tfidf', $args);


//numero di query espanse ottenute
$num_query = sizeof($espansione['results']);
//numero di new query espanse ottenute
$num_query_tfidf = sizeof($espansione_tfidf['results']);
$num_query_coocc = sizeof($espansione_coocc['results']);

// stampa il numero delle espansioni, vecchie e nuove
echo "(" . $num_query . " OLD expansions available)</p>"; 
echo "(" . $num_query_tfidf . " TFIDF expansions available)</p>"; 
echo "(" . $num_query_coocc . " CO-OCC expansions available)</p>"; 
?>

<!-- risultati vecchi %%%%%% -->
  <script language=javascript>
    array_risultati = new Array("result"
    
    <?php
    
    //popolamento dell'array array_risultati utile per mostrare/nascondere i div dei risultati durante il rollover da menu
      for($i=0; $i<$num_query; $i++) {
        echo ", \"result" . $i . "\"";
      }
      
    ?>
    );
  </script>
<!-- END risultati vecchi %%%%%% -->



<!-- START risultati TFIDF %%% -->
  <script language=javascript>

    array_risultati_tfidf = new Array("result"
    
    <?php
    //popolamento dell'array array_risultati utile per mostrare/nascondere i div dei risultati durante il rollover da menu
      for($i=0; $i<$num_query_tfidf; $i++) {
        echo ", \"result" . $i . "\"";
      }
      
    ?>
    );
  </script>
<!-- END risultati TFIDF %%% -->



<!-- START risultati COOCC %%% -->
<!-- END risultati COOCC %%% -->



<!-- barra laterale di sinistra, con le etichette
mostra i tag che hanno partecipato ad ogni espansione -->
<center>
<table width=100% cellspacing=0 style="margin:0px;">
  <tr>
   <td width=200 valign=top>
 
<!-- primo blocco, risultati standard Uncustomized -->
        <div id=active onclick="
        document.getElementById('active').id='inactive';
        this.id='active'; 
        nascondi_elementi_array(array_risultati);
        $('result').show();
        ">
        <center>
        	<a class=tags href=#> 
        		<span style="font-size:10px">Uncustomized</span>
        	</a>
        </center>
        </div>
<!-- fine primo blocco dei risultati standard Uncustomized -->
        
        
        
        
        
<!-- START blocchi successivi, con le espansioni STANDARD %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
        
        <?php
        //costruzione dei pulsanti di menu
          for($i=0; $i<$num_query; $i++) {
          ?>
          <div id=inactive onclick="
        document.getElementById('active').id='inactive';
        this.id='active'; 
        nascondi_elementi_array(array_risultati);
        $('result<?php echo $i; ?>').show();
        ">
        <center>
        	<a class=tags href=#>
                
                <?php   
      //calcolo preliminare del massimo valore di rank tra i tags successivamente utile per la grandezza del testo
                $max=0;
                for ($p=0; $p<(sizeof($espansione['results'][$i]['tags'])); $p++) {
                  $actual = $espansione['results'][$i]['tags'][$p]['rank'];
                  if ($actual > $max) $max = $actual;
                } ?>
                
                <?php 
                //creo l'array dei tag da passare tramite ajax
                $tags[$i] = "";
                //visualizzazione dei tag associati alla query espansa corrente 
                for ($j=0; $j<(sizeof($espansione['results'][$i]['tags'])); $j++) {
                  $tags[$i] = $tags[$i] . $espansione['results'][$i]['tags'][$j]['rank'] . ":" . $espansione['results'][$i]['tags'][$j]['tag'] . "|";
                  echo "<span style=\"font-size:" . (5+9*($espansione['results'][$i]['tags'][$j]['rank'] / $max)) . "pt\">" . $espansione['results'][$i]['tags'][$j]['tag'] . "</span> ";
                } ?>              
          		</a>
          	</center>
          	</div> <!-- END div id inactive -->
          <? } ?>
   
<!-- END blocchi successivi, con le espansioni  STANDARD %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% END -->



<!-- START blocchi successivi, con le espansioni TAGTFIDF - CLUSTERING %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->


<!-- END blocchi successivi, con le espansioni TAGTFIDF - CLUSTERING %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->






<!-- START blocchi successivi, con le espansioni TAG-TAG CO-OCCURRENCES %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- END blocchi successivi, con le espansioni TAG-TAG CO-OCCURRENCES %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->

   
   
</td> <!-- END blocco di sinistra, con le etichette dei tag espansi -->

   
   
   
   
<!-- resultbox contiene i risultati veri e propri, quelli di google  %%%%%%%%%%%%%%%%%%%%%%%%%%% -->
    <td valign=top>
        <!-- Primo div riservato alla query non espansa -->
        <div id="result" class="resultbox"><center>Loading..<br><img src=images/loading.gif><br><br><br><br></center></div>
            <script language="JavaScript">
            new Ajax.Updater('result', 'actions/result_parse.php', { method: 'get',parameters: {numerodiv:'', expandedquery: '<?php echo $key; ?>', originalquery:'<?php echo $key; ?>'}});
            </script>
            
        <!-- START div dell'espansione originale di nereau per i resultbox ed esecuzione delle query a google   %%% -->
        <?php
          for($i=0; $i<$num_query; $i++) {
          //sostituzione degli spazi dalla query corrente
          $query = $espansione['results'][$i]['query'];
          ?>
          <div id="result<?php echo $i; ?>" class="resultbox" style="display:none"><center>Loading..<br><img src=images/loading.gif><br><br><br><br></center></div>
            <script language="JavaScript">
            
            new Ajax.Updater('result<?php echo $i; ?>', 'actions/result_parse.php', { method: 'get',parameters: {tag:'<?php echo $tags[$i]; ?>', numerodiv:'<?php echo $i; ?>', expandedquery: '<?php echo $query; ?>', originalquery:'<?php echo $key; ?>'},evalScripts:true});
            </script>
          <? } ?>
        <!-- END  div per i resultbox ed esecuzione delle query a google   %%%%%%% -->

    </td>

  </tr>
</table>

</center>
</div>
