<?php 

function assicura($string) {
  return $string;
}

function db_connect () {
  global $dbhost;
  global $dbuser;
  global $dbpassword;
  global $dbname;
  $conn_string = "host=" . $dbhost . " dbname=" . $dbname . " user="  . $dbuser .  " password=" . $dbpassword;
  $dbconn = pg_pconnect($conn_string);
  return $dbconn;
}


function errore ($testo) {
        ?>
        <script language="JavaScript">
        alert('<?php echo $testo?>'); 
        </script>
        <?php
}

function displayerror ($testo) {
        if ($testo == "unexpanded query") {
          if ($_SESSION['userid'] != 0) {
            $testo = $testo . ". The system still has no informations about this  search query";
          } else {
            $testo = $testo . ". To take advantage of nereau\'s customized results please subscribe and log-in!";
          }
          
        }
        ?>
        <script language="JavaScript">
        displayerror('<?php echo $testo?>'); 
        </script>
        <?php
}

function back () {
        ?>
        <script language="JavaScript">
        history.back();
        </script>
        <?php
        
}

/* funzione generica per l'invio di comandi al server in formato json */
function exec_cmd ($cmd, $args) {
              $args['userid'] = $_SESSION['userid'];
              $args['session_id'] = session_id();
              global $socket_port;
              global $socket_host;
              $address = gethostbyname ($socket_host);
              $socket = socket_create (AF_INET, SOCK_STREAM, 0);
              
              if ($socket < 0) {
                  echo "socket_create() fallito: motivo: " . socket_strerror ($socket) . "<br>";
              } 
              
              $result = socket_connect ($socket, $address, $socket_port);
              if ($result < 0) {
                  echo "socket_connect() fallito.<br>Motivo: ($result) " . socket_strerror($result) . "<br>";
              } 
            
              $input = array();
              $input['cmd'] = $cmd;
              $input['args']= $args;
              
              
              $in = json_encode($input);
               
              $in .= "\n";
              $out = '';
              $output = '';
              
              
              socket_write ($socket, $in, strlen ($in));
              
              
              while ($out = socket_read ($socket, 2048)) {
                  $output.=$out;
              }
              
              $result = json_decode($output, true);
              
              socket_close ($socket);
              
              if($result['code']!=200) displayerror($result['response']);
              
              
                return $result;
                
}



function auth ($username, $password) {
  
  $args = array();
  $args['username'] = $username;
  $args['password'] = md5($password);
  
  $result = exec_cmd('login', $args);
  if($result['code']==200) {
    $_SESSION['userid'] = $result['results']['userid'];
    $_SESSION['username'] = $result['results']['username'];
    $_SESSION['firstname'] = $result['results']['firstname'];
    $_SESSION['lastname'] = $result['results']['lastname'];
    $_SESSION['email'] = $result['results']['email'];
    $_SESSION['role'] = $result['results']['role'];
  }
}

function logout ($userid) {

    $_SESSION['userid'] = '0';
    $_SESSION['username'] = '';
    $_SESSION['firstname'] = '';
    $_SESSION['lastname'] = '';
    $_SESSION['email'] = '';
    $_SESSION['role'] = '0';
}



function insertRate($userid, $query, $expandedquery, $tags, $vote ) {
  $time = time();
  $query = "INSERT INTO votes (iduser, query, expandedquery, tags, date, vote ) VALUES ('$userid', '$query', '$expandedquery', '$tags', '" . $time . "000', '$vote')";
  if (!pg_query($query)) displayerror(pg_last_error());
}


?>



