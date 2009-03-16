<form id=search_form method=get action=?>
  <input class=custominput size=34 type=text name=key <?php if(isset($key)) echo "value=\"" . $key . "\""; ?>> 
  <input type=submit class=custombutton value="go!">

  <br>
  <p style="margin:4px;"><input type=radio name=lang value=en <?php if($_SESSION['language']=='en') echo "checked=checked" ?> > English
  <input type=radio name=lang value=it <?php if($_SESSION['language']=='it') echo "checked=checked" ?> > Italiano</p>
</form>
