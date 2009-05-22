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
//$espansione_coocc = exec_cmd ('expand_tfidf', $args);


//numero di query espanse ottenute
$num_query = sizeof($espansione['results']);
//numero di new query tfidf espanse ottenute
$num_query_tfidf = sizeof($espansione_tfidf['results']);
//$num_query_coocc = sizeof($espansione_coocc['results']);

// stampa il numero delle espansioni, vecchie e nuove
echo "(" . $num_query . " OLD expansions available)</p>"; 
echo "(" . $num_query_tfidf . " TFIDF expansions available)</p>"; 
//echo "(" . $num_query_coocc . " CO-OCC expansions available)</p>"; 
?>

<!-- risultati vecchi %%%%%% -->

<!-- START costruzione degli array che contengono i risultati -->
<!-- creo due array diversi. -->

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
	//posso levare il result iniziale? non ha molto senso per me... 
	//lo lascio
    //popolamento dell'array array_risultati utile per mostrare/nascondere i div dei risultati durante il rollover da menu

      for($i=0; $i<$num_query_tfidf; $i++) {
	//cambio gli id perché questi risultati abbiano gli id successivi rispetto a quelli vecchi
//      for($i=$num_query; $i< $num_query + $num_query_tfidf; $i++) {	
        echo ", \"result" . $i + $num_query . "\"";
      }
      
    ?>
    );
  </script>
<!-- END risultati TFIDF %%% -->



<!-- START risultati COOCC %%% -->
<!-- END risultati COOCC %%% -->

<!-- END costruzione degli array che contengono i risultati -->






<!-- barra laterale di sinistra, con le etichette
mostra i tag che hanno partecipato ad ogni espansione -->
<center>
<table width=100% cellspacing=0 style="margin:0px;">
  <tr>
   <td width=200 valign=top>
 
<!-- primo blocco, risultati standard Uncustomized, diretti da google -->
        <div id=active onclick="
        document.getElementById('active').id='inactive';
        this.id='active'; 
        nascondi_elementi_array(array_risultati);
        //nascondo anche gli altri risultati
        nascondi_elementi_array(array_risultati_tfidf);
        $('result').show();
        //sintassi di prototype.js getElementById(...)
        ">
        <center>
        	<a class=tags href=#> 
        		<span style="font-size:10px">Uncustomized</span>
        	</a>
        </center>
        </div>
<!-- fine primo blocco dei risultati standard Uncustomized -->
        
        
        
        
        
<!-- START blocchi successivi, con le espansioni STANDARD old nereau %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
        
        <?php
        //costruzione dei pulsanti di menu
          for($i=0; $i<$num_query; $i++) {
          	//ogni $i é l'id dell'etichetta dei tags
          	
          ?>
          <div id=inactive onclick="
        document.getElementById('active').id='inactive';
        this.id='active'; 
        nascondi_elementi_array(array_risultati);
        //nascondi anche gli altri risultati tfidf
		nascondi_elementi_array(array_risultati_tfidf);
        //mostra i risultati riferiti dall'identificatore result[$i]
		//TODO: devo cambiare gli id ai risultati nuovi!
        $('result<?php echo $i; ?>').show();
        ">
        <center>
        	<a class=tags href=#>
                
                <?php   
      //calcolo preliminare del massimo valore di rank tra i tags: successivamente utile per la grandezza del testo
                $max=0;
                for ($p=0; $p<(sizeof($espansione['results'][$i]['tags'])); $p++) {
                  $actual = $espansione['results'][$i]['tags'][$p]['rank'];
                  if ($actual > $max) $max = $actual;
                } ?>
                
                <?php 
                //creo l'array dei tag da passare tramite ajax, quello che viene registrato durante il ranking con le stelline
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
  
        <?php
        //costruzione dei pulsanti di menu
        //con gli id modificati per avere id successivi rispetto ai risultati precedenti/
        //meglio avere un array distinto? si
          for($i=0; $i<$num_query_tfidf; $i++) {
   	      //for($i=$num_query; $i< $num_query + $num_query_tfidf; $i++) {
			$result_id = $i + $num_query

          ?>
          <div id=inactive onclick="
        document.getElementById('active').id='inactive';
        this.id='active'; 
        nascondi_elementi_array(array_risultati);
        nascondi_elementi_array(array_risultati_tfidf);
        $('result_tagtfidf<?php echo $result_id; ?>').show();
        ">
		<!-- ho cambiato il valore dell'id associato all'etichetta da mostrare con show -->
        <center>
        	<a class=tags href=#>
                
                <?php   
      //calcolo preliminare del massimo valore di rank tra i tags successivamente utile per la grandezza del testo
                $max=0;
                for ($p=0; $p<(sizeof($espansione_tfidf['results'][$i]['tags'])); $p++) {
                  $actual = $espansione_tfidf['results'][$i]['tags'][$p]['rank'];
                  if ($actual > $max) $max = $actual;
                } ?>
                
                <?php 
                //creo l'array dei tag da passare tramite ajax, cambiato il nome
                $tags_tfidf[$i] = "";
                //visualizzazione dei tag associati alla query espansa corrente 
                for ($j=0; $j<(sizeof($espansione_tfidf['results'][$i]['tags'])); $j++) {
                  $tags_tfidf[$i] = $tags_tfidf[$i] . $espansione_tfidf['results'][$i]['tags'][$j]['rank'] . ":" . $espansione_tfidf['results'][$i]['tags'][$j]['tag'] . "|";
                  echo "<span style=\"font-size:" . (5+9*($espansione_tfidf['results'][$i]['tags'][$j]['rank'] / $max)) . "pt\">" . $espansione_tfidf['results'][$i]['tags'][$j]['tag'] . "</span> ";
                } ?>              
          		</a>
          	</center>
          	</div> <!-- END div id inactive -->
          <? } ?>

<!-- END blocchi successivi, con le espansioni TAGTFIDF - CLUSTERING %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->






<!-- START blocchi successivi, con le espansioni TAG-TAG CO-OCCURRENCES %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- END blocchi successivi, con le espansioni TAG-TAG CO-OCCURRENCES %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->

   
   
</td> <!-- END blocco di sinistra, con le etichette dei tag espansi -->

   
   


<!-- result boxes di DX, dove ci sono i risultati di google -->
   
   
<!-- resultbox contiene i risultati veri e propri, quelli di google  %%%%%%%%%%%%%%%%%%%%%%%%%%% -->
    <td valign=top>
        <!-- START Primo div riservato alla query NON espansa 
	OCCHIO AI DIV=ID!!  -->
        <div id="result" class="resultbox">
        	<center>Loading..<br>
        		<img src=images/loading.gif><br><br><br><br>
        	</center>
        </div>
            <script language="JavaScript">
            new Ajax.Updater('result', 'actions/result_parse.php', { method: 'get',parameters: {numerodiv:'', expandedquery: '<?php echo $key; ?>', originalquery:'<?php echo $key; ?>'}});
            </script>
        <!-- END Primo div riservato alla query non espansa -->
    
            
            




        <!-- START div dell'espansione originale di nereau per i resultbox ed esecuzione delle query a google   %%% -->
        <?php
          for($i=0; $i<$num_query; $i++) {
          //sostituzione degli spazi dalla query corrente
          $query = $espansione['results'][$i]['query'];
          ?>
<!-- ecco qui che setta l'id del div! -->
          <div id="result<?php echo $i; ?>" class="resultbox" style="display:none">
	          <center>Loading..<br>
          		<img src=images/loading.gif><br><br><br><br>
          	</center>
          </div>
          
<!-- e qui setta l'updater ajax che prende come parametri l'id (il result $i) e diversi altri parametri caratteristici dell'espansione -->
          <script language="JavaScript">
            new Ajax.Updater('result<?php echo $i; ?>', 'actions/result_parse.php', { method: 'get',parameters: {tag:'<?php echo $tags[$i]; ?>', numerodiv:'<?php echo $i; ?>', expandedquery: '<?php echo $query; ?>', originalquery:'<?php echo $key; ?>'},evalScripts:true});
            </script>
          <? } ?>
        <!-- END  div per i resultbox ed esecuzione delle query a google   %%%%%%% -->











<!-- START TAG TFIDF-->

        <!-- START div dell'espansione TAG TFIDF ed esecuzione delle query a google   %%% -->

        <?php
          for($i=0; $i<$num_query_tfidf; $i++) {
          //sostituzione degli spazi dalla query corrente
          $query_tfidf = $espansione_tfidf['results'][$i]['query'];
		  //gli id dei result sono tutti successivi agli id delle espansioni precedenti
		  $result_id = $i + $num_query;
          ?>
          
          <!-- cambio l'id perché cosi i risultati hanno id  diversi 
          result_tfidf$i? NO, lascio tutto con id result + $i + $num_query per tenere conto degli id assegnati in precedenza ai div dei risultati. 
          -->
          <!-- potrei aggiungere una classe o l'id dei risultati per cambiare lo stile css -->
          <div id="result<?php echo $result_id; ?>" class="resultbox" style="display:none">
	          <center>Loading..<br>
          		<img src=images/loading.gif><br><br><br><br>
          	</center>
          </div>

          <script language="JavaScript">
            new Ajax.Updater('result<?php echo $result_id; ?>', 'actions/result_parse.php', { method: 'get',parameters: {tag:'<?php echo $tags_tfidf[$i]; ?>', numerodiv:'<?php echo $result_id; ?>', expandedquery: '<?php echo $query_tfidf; ?>', originalquery:'<?php echo $key; ?>'},evalScripts:true});
            </script>
          <? } ?>
        <!-- END  div per i resultbox TAG TFIDF ed esecuzione delle query a google   %%%%%%% -->
        
<!-- END TAG TFIDF-->











    </td>

  </tr>
</table>

</center>
</div>
