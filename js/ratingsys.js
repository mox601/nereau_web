/*
Author: Addam M. Driver
Date: 10/31/2006

Customized for Nereau by: Marco Gagliardi
*/

var sMax;	// Isthe maximum number of stars
var holder; // Is the holding pattern for clicked state
var preSet = []; // Is the PreSet value onces a selection has been made
var rated = [];

// Rollover for image Stars //
function rating(num, group){
	sMax = 0;	// Isthe maximum number of stars
	for(n=0; n<num.parentNode.childNodes.length; n++){
		if(num.parentNode.childNodes[n].nodeName == "A"){
			sMax++;	
		}
	}
	
	if(!rated[group]){
		s = num.id.replace(group+"_", ''); // Get the selected star
		a = 0;
		for(i=1; i<=sMax; i++){		
			if(i<=s){
				document.getElementById(group+"_"+i).className = "on";
				document.getElementById(group+"_"+"rateStatus").innerHTML = num.title;	
				holder = a+1;
				a++;
			}else{
				document.getElementById(group+"_"+i).className = "";
			}
		}
	} 
}

// For when you roll out of the the whole thing //
function off(me, group){
	if(!rated[group]){
		if(!preSet[group]){
			for(i=1; i<=sMax; i++){		
				document.getElementById(group+"_"+i).className = "";
				document.getElementById(group+"_"+"rateStatus").innerHTML = me.parentNode.title;
			}
		}else{
			rating(preSet[group], group);
			document.getElementById(group+"_"+"rateStatus").innerHTML = document.getElementById(group+"_"+"ratingSaved").innerHTML;
		}
	}
}



// When you actually rate something //
function rateIt(me, group, to_send_boolean, val, query, expandedquery, tags){
	if(!rated[group]){
		document.getElementById(group+"_"+"rateStatus").innerHTML = document.getElementById(group+"_"+"ratingSaved").innerHTML + ": "+me.title;
		preSet[group] = me;
		rated[group]=1;
    //se la votazione è gia stata espressa in qualche modo nelle pagine precedenti la variabile to_send_boolean è false
    //setta il sistema come votato ma non ripetere l'azione ajax
		if(to_send_boolean) {
        document.getElementById('actions').innerHTML = 'Rating...<br><img src=images/loading.gif>';
        //esegui il salvataggio dei dati passati come parametro dal sistema
        sendRate(me, val, query, expandedquery, tags);
      }
		rating(me, group);
	}
}


// When you actually rate something with EXPANSION TYPE //
function rateItExpansion(me, group, to_send_boolean, val, query, expandedquery, tags, expansion_type){
	if(!rated[group]){
		document.getElementById(group+"_"+"rateStatus").innerHTML = document.getElementById(group+"_"+"ratingSaved").innerHTML + ": "+me.title;
		preSet[group] = me;
		rated[group]=1;
    //se la votazione è gia stata espressa in qualche modo nelle pagine precedenti la variabile to_send_boolean è false
    //setta il sistema come votato ma non ripetere l'azione ajax
		if(to_send_boolean) {
        document.getElementById('actions').innerHTML = 'Rating...<br><img src=images/loading.gif>';
        //esegui il salvataggio dei dati passati come parametro dal sistema
        sendRateExpansion(me, val, query, expandedquery, tags, expansion_type);
      }
		rating(me, group);
	}
}




// Send the rating information somewhere using Ajax or something like that.
function sendRate(sel,val, query, expandedquery, tags){

	//apri il file responsabile di salvare le informazioni nel database
	new Ajax.Updater('actions', 'actions/rate.php', {
              method: 'post',
              parameters: {
              query:query,
              expandedquery:expandedquery,
              tags:tags,
              vote:val
              },
              onSuccess: function(transport) {
                displayerror("Your rating was: "+sel.title+ " (" + val +"). Thank you!");
              }, evalScripts:true});
              
	
}


// Send the rating information WITH EXPANSION TYPE
function sendRateExpansion(sel,val, query, expandedquery, tags, expansion_type){

	//apri il file responsabile di salvare le informazioni nel database
	new Ajax.Updater('actions', 'actions/rate.php', {
              method: 'post',
              parameters: {
              query:query,
              expandedquery:expandedquery,
              tags:tags,
              vote:val, 
							expansion_type:expansion_type
              },

              onSuccess: function(transport) {
            	displayerror("Your rating was: "+sel.title+ " (" + val +", for expansion type: "+
							expansion_type + "). Thank you!");
              }, evalScripts:true});
              
	
}






