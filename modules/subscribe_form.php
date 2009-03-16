<form id=subscribe_form method=post action=?content=saveuser>
<fieldset> <legend>User info</legend>
Please fullfill the following fields:<br><br>
<table cellspacing=5>
<tr><td align=right>Username:</td><td><input class=custominput type=text name=save_username size=30></td>
    <td align=right>Email:</td><td><input class=custominput type=text name=save_email size=30></td>
</tr>
<tr>
    <td align=right>Nome:</td><td><input class=custominput type=text name=save_firstname size=30></td>
    <td align=right>Cognome:</td><td><input class=custominput type=text name=save_lastname size=30></td>
</tr>
<tr>
  <td align=right>Password:</td><td><input class=custominput type=password name=save_password1 size=30></td> 
  <td align=right>Re-type password:</td><td> <input type=password class=custominput name=save_password2 size=30></td>  
</tr>
<tr><td></td><td><span class=note>Warning: All fields are mandatory!</span></td><td align=right></td><td></td></tr>
</table>
</fieldset>
<center><br>
<input value=Subscribe type=submit class=custombutton name=subscribe_button onclick="
//decommentare per usare l'action ajax al posto della pagina statica richiamata dall'action del form
/*
new Ajax.Updater('actions', 'actions/saveuser.php', {
              method: 'post',
              parameters: {
              username:document.all.save_username.value,
              email:document.all.save_email.value, 
              nome:document.all.save_nome.value,
              cognome:document.all.save_cognome.value,
              password1:document.all.save_password1.value, 
              password2:document.all.save_password2.value},
              onSuccess: function(transport) {setTimeout('window.parent.location.reload()', 500); }, evalScripts:true});
*/

">

</center>

 </form>

