<?php
  
  $password1 = assicura($_POST['save_password1']);
  $password2 = assicura($_POST['save_password2']);
  

  if ($password1 != $password2) {
    echo "Error: Confirm password doesn't match";
  } else {
    $args = array();
    $args['username'] = assicura($_POST['save_username']);
    $args['email'] = assicura($_POST['save_email']);
    $args['firstname'] = assicura($_POST['save_firstname']);
    $args['lastname'] = assicura($_POST['save_lastname']);
    $args['password'] = md5($password1);  
    $result = exec_cmd('saveuser', $args);
  }
  


?>
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
<center>
Saving user...
<br><img src=images/loading.gif>
</center>


<?php

if ($result['code']==200) {
  //eseguo il login e redirect alla homepage
  ?>
  
    <SCRIPT language="JavaScript">
    <!--
    new Ajax.Updater('actions', 'actions/login.php', {
              method: 'post',
              parameters: {username:'<?php echo $args['username'] ?>', password:'<?php echo $args['password'] ?>', autologincheck:true
              },
              onSuccess: function(transport) {
              window.location="index.php";

               }});

    //-->
    </SCRIPT>
    
  <?php

} 

?>
