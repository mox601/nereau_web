<input type=button class=custombutton onclick="document.getElementById('actions').innerHTML = 'Loading ..<br><img src=images/loading.gif>';
new Ajax.Updater('actions', 'actions/logout.php', {
              onSuccess: function(transport) {setTimeout('window.parent.location.reload()', 500); },
              parameters: {userid:'<?php echo $_SESSION['userid']; ?>'} , method:'post', evalScripts:true});
" value=logout><br>
