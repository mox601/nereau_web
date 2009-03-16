<form id=login_form onSubmit="document.getElementById('actions').innerHTML = 'Loading ..<br><img src=images/loading.gif>';
new Ajax.Updater('actions', 'actions/login.php', {
              method: 'post',
              parameters: {username:document.getElementById('login_username').value, password:document.getElementById('login_password').value,autologincheck:document.getElementById('autologincheck').checked},
              onSuccess: function(transport) {setTimeout('window.parent.location.reload()', 500); }, evalScripts:true});
  return false;">
  
<table style="margin:0px;padding:0px;">
<tr><td align=left>log-in.. </td><td colspan=2 align=right><span class=note>Remember me on this computer! </span><input id=autologincheck name=autologincheck type=checkbox></td></tr>
<tr>
  <td><input type=text id=login_username class=custominput  name=username size=15 value="<?php echo (isset($_COOKIE['cookieusername']))?$_COOKIE['cookieusername']:'';?>" ></td>
  <td><input id=login_password type=password class=custominput  name=password size=15 value="<?php echo (isset($_COOKIE['cookiepassword']))?$_COOKIE['cookiepassword']:'';?>" ></td>
  <td><input value=Login type=submit class=custombutton name=login_button  onclick="document.getElementById('actions').innerHTML = 'Loading ..<br><img src=images/loading.gif>';
        new Ajax.Updater('actions', 'actions/login.php', {
                      method: 'post',
                      parameters: {username:document.getElementById('login_username').value, password:document.getElementById('login_password').value, autologincheck:document.getElementById('autologincheck').checked
                      },
                      onSuccess: function(transport) {setTimeout('window.parent.location.reload()', 500); }, evalScripts:true});
        "></td>
  </tr>
<tr><td colspan=3 align=right><a href=?content=subscribe>...or subscribe</a></td></tr>
</table>  
</form>
