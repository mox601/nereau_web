function displayerror(text) {
  $('error').style.display='block';
  $('error').innerHTML="<div id=errorheader><img src=http://www.libernovus.it/grammatica/template/default/images/close.gif onclick=\"$('error').hide();\"></div><div style=\"padding:3px;\">" + text +"<br></div>";

}


function nascondi_elementi_array (array) {
  for(var i=0; i < array.length; i++ ){
    $(array[i]).hide();    
  }
}
