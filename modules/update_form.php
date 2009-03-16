<form id=subscribe_form method=post action=?content=update>
<fieldset> <legend>User info</legend>
<table cellspacing=5>
<tr><td align=right>Username: </td><td><?php echo $_SESSION['username']?><br></td>
     <td  valign=top align=right>Email:</td><td valign=top ><input class=custominput type=text name=save_email size=30 value=<?php echo $_SESSION['email']?>></td>
</tr>

<tr><td  valign=top align=right>FirstName:</td><td valign=top ><input class=custominput type=text name=save_firstname size=30 value=<?php echo $_SESSION['firstname']?>></td>
    <td valign=top  align=right>LastName:</td><td valign=top ><input class=custominput type=text name=save_lastname size=30 value=<?php echo $_SESSION['lastname']?>></td>
</tr>
<tr><td></td><td colspan=3><span class=note>Leave blank if you don't want to change your password</span></td></tr>
<tr><td valign=top align=right>Old password:</td><td valign=top ><input class=custominput type=password name=save_oldpassword size=30></td>
   <td></td><td></td>
</tr>

<tr><td  valign=top align=right>New Password:</td><td valign=top ><input class=custominput type=password name=save_newpassword1 size=30></td>
    <td valign=top  align=right>Re-type new password:</td><td valign=top > <input type=password class=custominput name=save_newpassword2 size=30></td>
</tr>

<tr><td></td><td><br></td><td align=right></td><td valign=top ></td></tr>
</table>

</fieldset>

<fieldset><legend>Options</legend>
<table>
<?php
 if (isset($_COOKIE['tab']) && $_COOKIE['tab'] == 'on') { $tab = true;} else {$tab=false;} 
?>
<tr><td><input <?php if($tab) echo "checked"; ?> type=checkbox id=tab name=tab value=on></td><td>Open links in new windows/tabs</td><td></td</tr>
</table>

</fieldset>


<center><br>
<input value="Update my data" type=submit class=custombutton name=subscribe_button onclick="
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
