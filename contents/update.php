<?php
  
  
  
  $password1 = assicura($_POST['save_newpassword1']);
  $password2 = assicura($_POST['save_newpassword2']);
  

  if ($password1 != $password2) {
    displasyerror("Error: Passwords mismatch");
    back();
  } else {
  
    
    
    //imposto il cookie per l'opzione apertura links in nuovo tab.....
    global $domainalias;
    $cookiename = "tab";
    $cookietime=time()+60*60*24*30*12;
    if (isset($_POST['tab']) && $_POST['tab']=='on') {    
      $value="on";
    } else {
      $value="off";
    }
    ?>
      <SCRIPT language="JavaScript">
      <!--
    new Ajax.Updater('actions', 'actions/cookie.php', {
                      method: 'get',
                      parameters: {
                      name:'<?php echo $cookiename; ?>', 
                      value:'<?php echo $value; ?>', 
                      time:'<?php echo $cookietime; ?>', 
                      domainalias:'<?php echo $domainalias; ?>'
                      }, evalScripts:true});
        
      //-->
      </SCRIPT>   
    <?php
    
    //..... fatto!
  
  
  
  
  
    //procedo....
  
    $args = array();
    $args['username'] = assicura($_POST['save_username']);
    $args['email'] = assicura($_POST['save_email']);
    $args['firstname'] = assicura($_POST['save_firstname']);
    $args['lastname'] = assicura($_POST['save_lastname']);
    
    if($_POST['save_oldpassword']== "" ) {
      $args['oldpassword'] = "";
    } else {
      $args['oldpassword'] = md5(assicura($_POST['save_oldpassword']));
    }
    
    if($password1 == "" ) {
      $args['newpassword'] = "";
    } else {
      $args['newpassword'] = md5($password1);
    }    
      
    $result = exec_cmd('updateuser', $args);
    
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
              <br>
              <center>
              Updating data...
              <br><img src=images/loading.gif>
              </center>
              <?php
              //se il comando è andato a buon fine
              if ($result['code']==200) {
              
              
                //aggiorno le informazioni di sessione e redirecto alla homepage
                
                $_SESSION['email'] = $args['email'];
                $_SESSION['firstname'] = $args['firstname'];
                $_SESSION['lastname'] = $args['lastname'];
                }
                ?>
      <SCRIPT language="JavaScript">
      <!--

      setTimeout("window.parent.location='index.php'", 500);


      //-->
      </SCRIPT>                  
       <?php          
               
}
?>

