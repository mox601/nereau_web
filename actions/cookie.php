<?php 
//imposta un cookie sul dominio
$name = $_GET['name'];
$value = $_GET['value'];
$time = $_GET['time'];
$domainalias = $_GET['domainalias'];

setcookie ($name, $value, $time, "/", "." . $domainalias);

echo "new cookie set!";

?>
